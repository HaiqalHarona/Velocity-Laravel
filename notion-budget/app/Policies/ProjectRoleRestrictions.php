<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use App\Models\ProjectMember;

class ProjectRoleRestrictions
{

    // Check if the user is part of the project
    private function getMembership(User $user, Project $project): ?ProjectMember
    {
        return $project->members()->where('user_email', $user->email)->first();
    }

    // Check if the user accessing is the owner of the project
    private function isOwner(User $user, Project $project): bool
    {
        return $user->email === $project->owner_email;
    }

    // Check if the user can view the project (Even though the link is hashed)
    public function roleView(User $user, Project $project): bool
    {
        if($this->isOwner($user, $project)){
            return true;
        }
        return $this->getMembership($user, $project) !== null;
    }

    public function roleProjectActions(User $user, Project $project)
    {

    }
}
