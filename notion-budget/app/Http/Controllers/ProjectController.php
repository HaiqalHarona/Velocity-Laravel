<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectController
{
    public function ProjectCreate(Request $request)
    {
        $form = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $project = Project::create([
            'name' => $form['name'],
            'icon' => $form['icon'],
            'description' => $form['description'],
            'owner_email' => Auth::user()->email,
            'status' => 'active',
        ]);
        return redirect()->route('projects')->with('success', 'Project created successfully');
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
