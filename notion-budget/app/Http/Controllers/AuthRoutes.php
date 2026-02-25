<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Workspace;
use App\Models\WorkspaceMember;

class AuthRoutes
{
    public function profile()
    {
        return view('profile');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function workspace()
    {
        $user = Auth::user();

        // 1. Workspaces owned by the user
        $ownedWorkspaces = Workspace::where('owner_email', $user->email)
            ->with(['projects', 'workspace_members.user'])
            ->get();

        // 2. Workspaces the user is a member of (not owner)
        $memberWorkspaceIds = WorkspaceMember::where('user_email', $user->email)
            ->pluck('workspace_id');

        $memberWorkspaces = Workspace::whereIn('id', $memberWorkspaceIds)
            ->with(['projects', 'workspace_members.user'])
            ->get();

        // Merge and tag each workspace with the user's role
        $workspaces = $ownedWorkspaces->map(function ($ws) {
            $ws->user_role = 'owner';
            return $ws;
        })->concat($memberWorkspaces->map(function ($ws) use ($user) {
            $member = $ws->workspace_members->firstWhere('user_email', $user->email);
            $ws->user_role = $member ? $member->role : 'member';
            return $ws;
        }));

        // Filter each workspace's projects based on the user's role and project visibility
        $workspaces = $workspaces->map(function ($ws) use ($user) {
            if ($ws->user_role === 'owner' || $ws->user_role === 'admin') {
                // Admins and owners see all projects
                return $ws;
            }

            // Members/viewers only see 'all' projects + 'members_only' projects they belong to
            $ws->projects = $ws->projects->filter(function ($project) use ($user) {
                if ($project->visibility === 'all') {
                    return true;
                }
                // Check if user is explicitly added to this project
                return $project->projectMembers()
                    ->where('user_email', $user->email)
                    ->exists();
            })->values();

            return $ws;
        });

        return view('workspace', compact('workspaces'));
    }

    public function project(\App\Models\Workspace $workspace, \App\Models\Project $project)
    {
        $user = Auth::user();

        // Ensure the project belongs to the workspace
        abort_if($project->workspace_id !== $workspace->id, 404);

        // Check access: owner/admin always in; others need project access
        $member = WorkspaceMember::where('workspace_id', $workspace->id)
            ->where('user_email', $user->email)
            ->first();

        $isOwner = $workspace->owner_email === $user->email;
        $isAdmin = $member && $member->role === 'admin';

        if (!$isOwner && !$isAdmin) {
            if ($project->visibility === 'members_only') {
                $inProject = $project->projectMembers()
                    ->where('user_email', $user->email)
                    ->exists();
                abort_if(!$inProject, 403);
            }
        }

        $tasks = $project->tasks()->with('task_assignees.user')->get();

        return view('project', compact('workspace', 'project', 'tasks'));
    }
}
