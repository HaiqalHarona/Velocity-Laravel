<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;

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

    public function projects()
    {
        // Placeholder data for the UI until real DB calls are wired up
        $projects = [
            [
                'id' => 1,
                'name' => 'Website Redesign',
                'color' => '#6366f1',
                'icon' => '🌐',
                'pools' => [
                    [
                        'id' => 1,
                        'name' => 'Backlog',
                        'color' => '#64748b',
                        'tasks' => [
                            ['id' => 1, 'title' => 'Audit existing pages', 'priority' => 'medium', 'end_date' => '2026-03-10', 'tags' => ['Research']],
                            ['id' => 2, 'title' => 'Collect brand assets', 'priority' => 'low', 'end_date' => null, 'tags' => []],
                        ]
                    ],
                    [
                        'id' => 2,
                        'name' => 'In Progress',
                        'color' => '#f59e0b',
                        'tasks' => [
                            ['id' => 3, 'title' => 'Design homepage mockup', 'priority' => 'high', 'end_date' => '2026-03-05', 'tags' => ['Design']],
                        ]
                    ],
                    [
                        'id' => 3,
                        'name' => 'Review',
                        'color' => '#3b82f6',
                        'tasks' => [
                            ['id' => 4, 'title' => 'Review nav structure', 'priority' => 'medium', 'end_date' => '2026-03-08', 'tags' => ['UX']],
                        ]
                    ],
                    [
                        'id' => 4,
                        'name' => 'Done',
                        'color' => '#22c55e',
                        'tasks' => [
                            ['id' => 5, 'title' => 'Define project scope', 'priority' => 'high', 'end_date' => '2026-02-20', 'tags' => []],
                        ]
                    ],
                ],
                'members' => [
                    ['name' => 'You', 'role' => 'owner', 'initials' => 'YO'],
                    ['name' => 'Sarah K.', 'role' => 'admin', 'initials' => 'SK'],
                    ['name' => 'Lee M.', 'role' => 'member', 'initials' => 'LM'],
                ],
            ],
            [
                'id' => 2,
                'name' => 'Mobile App MVP',
                'color' => '#ec4899',
                'icon' => '📱',
                'pools' => [
                    [
                        'id' => 5,
                        'name' => 'To Do',
                        'color' => '#64748b',
                        'tasks' => [
                            ['id' => 6, 'title' => 'Setup project repo', 'priority' => 'high', 'end_date' => '2026-03-01', 'tags' => ['Dev']],
                            ['id' => 7, 'title' => 'Design onboarding flow', 'priority' => 'medium', 'end_date' => '2026-03-12', 'tags' => ['Design']],
                        ]
                    ],
                    [
                        'id' => 6,
                        'name' => 'In Progress',
                        'color' => '#f59e0b',
                        'tasks' => [
                            ['id' => 8, 'title' => 'Auth screens', 'priority' => 'high', 'end_date' => '2026-03-03', 'tags' => ['Dev']],
                        ]
                    ],
                    ['id' => 7, 'name' => 'Done', 'color' => '#22c55e', 'tasks' => []],
                ],
                'members' => [
                    ['name' => 'You', 'role' => 'owner', 'initials' => 'YO'],
                    ['name' => 'Marco P.', 'role' => 'member', 'initials' => 'MP'],
                ],
            ],
        ];

        return view('projects', compact('projects'));
    }
}
