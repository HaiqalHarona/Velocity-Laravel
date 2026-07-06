<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\Pool;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create demo users
        $usersData = [
            [
                'name' => 'Demo Owner',
                'email' => 'owner@example.com',
                'role' => 'owner',
            ],
            [
                'name' => 'Demo Admin',
                'email' => 'admin@example.com',
                'role' => 'admin',
            ],
            [
                'name' => 'Demo Member 1',
                'email' => 'member1@example.com',
                'role' => 'member',
            ],
            [
                'name' => 'Demo Member 2',
                'email' => 'member2@example.com',
                'role' => 'member',
            ],
            [
                'name' => 'Demo Viewer',
                'email' => 'viewer@example.com',
                'role' => 'viewer',
            ],
        ];

        $users = [];
        foreach ($usersData as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                    'avatar' => "https://ui-avatars.com/api/?name=" . urlencode($data['name']) . "&background=random&color=fff",
                ]
            );
            $users[$data['role']][] = $user;
        }

        // Clean up any existing demo projects first to avoid duplicates
        Project::where('name', 'Velocity Demo Project')->delete();

        // 2. Determine project owner (transfer ownership to jamycharle@gmail.com)
        $ownerEmail = 'jamycharle@gmail.com';
        $ownerUser = User::where('email', $ownerEmail)->first();
        if (!$ownerUser) {
            $ownerUser = $users['owner'][0];
        }

        $project = Project::create([
            'name' => 'Velocity Demo Project',
            'description' => 'A pre-configured demo project demonstrating Kanban board, tasks, tags, and collaboration.',
            'color' => '#6c63ff',
            'owner_email' => $ownerUser->email,
            'status' => 'active',
        ]);

        // 3. Add all existing accounts in the database (including Gmail accounts and seeders) to this project
        $seederRoles = [];
        foreach ($usersData as $data) {
            $seederRoles[$data['email']] = $data['role'];
        }

        $allUsers = User::all();
        foreach ($allUsers as $user) {
            $role = 'member';
            if ($user->email === $ownerUser->email) {
                $role = 'owner';
            } elseif (isset($seederRoles[$user->email])) {
                // If the previous seeder owner is no longer the project owner, make them an admin
                $role = $seederRoles[$user->email] === 'owner' ? 'admin' : $seederRoles[$user->email];
            } elseif (str_ends_with($user->email, '@gmail.com')) {
                $role = 'admin';
            }

            ProjectMember::create([
                'project_id' => $project->id,
                'user_email' => $user->email,
                'role' => $role,
                'added_at' => now(),
            ]);
        }

        // 4. Create some default pools (columns)
        $todoPool = Pool::create([
            'project_id' => $project->id,
            'name' => 'To Do',
            'color' => '#ffc107',
            'position' => 1,
        ]);

        $progressPool = Pool::create([
            'project_id' => $project->id,
            'name' => 'In Progress',
            'color' => '#0d6efd',
            'position' => 2,
        ]);

        $donePool = Pool::create([
            'project_id' => $project->id,
            'name' => 'Done',
            'color' => '#198754',
            'position' => 3,
        ]);

        // 5. Add some sample tasks to make it feel alive
        Task::create([
            'pool_id' => $todoPool->id,
            'title' => 'Explore Velocity Features',
            'description' => 'Review dashboard layout, task assignment, and real-time updates.',
            'position' => 1,
        ]);

        Task::create([
            'pool_id' => $progressPool->id,
            'title' => 'Set Up Demo Mode',
            'description' => 'Verify that AUTO_VERIFY_ACCOUNTS mode works and logs in successfully without email verification.',
            'position' => 1,
        ]);

        Task::create([
            'pool_id' => $donePool->id,
            'title' => 'Initialize Seeder Accounts',
            'description' => 'Successfully seed demo accounts, create project, and invite all users.',
            'position' => 1,
        ]);
    }
}
