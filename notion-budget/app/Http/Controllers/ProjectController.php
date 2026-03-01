<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectController
{
    public function ProjectCreate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon_base64' => 'nullable|string',
            'description' => 'nullable|string|max:255',
        ]);

        $iconPath = null;
        if ($request->filled('icon_base64')) {
            $base64 = $request->input('icon_base64');
            $imageData = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $base64));
            $filename = 'project-icons/' . uniqid('proj_', true) . '.jpg';
            Storage::disk('public')->put($filename, $imageData);
            $iconPath = $filename;
        }

        Project::create([
            'name' => $request->name,
            'icon' => $iconPath,
            'description' => $request->description,
            'owner_email' => Auth::user()->email,
            'status' => 'active',
        ]);

        return redirect()->route('projects')->with('success', 'Project created successfully!');
    }

    public function ProjectDelete()
    {

    }

    public function ProjectUpdate()
    {
    }

    public function ProjectEdit()
    {

    }
}
