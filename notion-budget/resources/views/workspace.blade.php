    @extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold m-0">My Workspaces</h2>
            <p class="text-muted m-0 small">Manage your teams and their projects</p>
        </div>
        <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
            data-bs-target="#createWorkspaceModal">
            <i class="bi bi-plus-lg"></i> New Workspace
        </button>
    </div>

    @php
        // Placeholder data — replace with real $workspaces from controller
        $workspaces = [
            [
                'id' => 1,
                'name' => 'Engineering Team',
                'description' => 'Backend, frontend and infrastructure projects.',
                'user_role' => 'owner',
                'members' => [
                    ['name' => 'John Doe', 'email' => 'jd@example.com', 'role' => 'owner'],
                    ['name' => 'Alice Smith', 'email' => 'as@example.com', 'role' => 'admin'],
                    ['name' => 'Rahul Kumar', 'email' => 'rk@example.com', 'role' => 'member'],
                ],
                'projects' => [
                    ['id' => 1, 'name' => 'API Redesign', 'description' => 'REST to GraphQL migration.', 'icon' => '🚀', 'color' => '#8b5cf6', 'visibility' => 'all', 'task_count' => 8],
                    ['id' => 2, 'name' => 'Auth Service', 'description' => 'OAuth2 + SSO integration.', 'icon' => '🔐', 'color' => '#10b981', 'visibility' => 'members_only', 'task_count' => 4],
                    ['id' => 3, 'name' => 'CI/CD Pipeline', 'description' => null, 'icon' => '⚙️', 'color' => '#f59e0b', 'visibility' => 'all', 'task_count' => 2],
                ],
            ],
            [
                'id' => 2,
                'name' => 'Marketing Team',
                'description' => null,
                'user_role' => 'member',
                'members' => [
                    ['name' => 'Sara Lee', 'email' => 'sl@example.com', 'role' => 'owner'],
                    ['name' => 'John Doe', 'email' => 'jd@example.com', 'role' => 'member'],
                ],
                'projects' => [
                    ['id' => 4, 'name' => 'Q2 Campaign', 'description' => 'Summer launch strategy.', 'icon' => '📣', 'color' => '#ef4444', 'visibility' => 'all', 'task_count' => 5],
                ],
            ],
        ];
    @endphp

    @forelse($workspaces as $workspace)
        <div class="card rounded-4 mb-4 overflow-hidden">
            {{-- Workspace Header --}}
            <div class="card-header p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3"
                style="background-color: var(--bg-card); border-bottom: 1px solid var(--border);">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-2 d-flex align-items-center justify-content-center"
                        style="background-color: var(--primary); width: 44px; height: 44px;">
                        <i class="bi bi-briefcase-fill fs-5 text-white"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <h5 class="fw-bold m-0">{{ $workspace['name'] }}</h5>
                            <span class="badge rounded-pill small
                                        {{ $workspace['user_role'] === 'owner' ? 'bg-warning text-dark' :
                ($workspace['user_role'] === 'admin' ? 'bg-danger' : 'bg-secondary') }}">
                                {{ ucfirst($workspace['user_role']) }}
                            </span>
                        </div>
                        <p class="text-muted small m-0 mt-1 {{ $workspace['description'] ? '' : 'fst-italic' }}">
                            {{ $workspace['description'] ?? 'No description' }}
                        </p>
                    </div>
                </div>

                {{-- Member Avatars + Actions --}}
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <div class="d-flex align-items-center">
                        <span class="text-muted small me-2">Members:</span>
                        @foreach(array_slice($workspace['members'], 0, 5) as $i => $member)
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($member['name']) }}&background=random&color=fff"
                                alt="{{ $member['name'] }}" title="{{ $member['name'] }} ({{ $member['role'] }})"
                                class="rounded-circle border border-dark" width="30" height="30"
                                style="{{ $i > 0 ? 'margin-left:-8px;' : '' }}">
                        @endforeach
                        @if(count($workspace['members']) > 5)
                            <span class="badge bg-secondary rounded-pill ms-1 small">+{{ count($workspace['members']) - 5 }}</span>
                        @endif
                    </div>

                    @if(in_array($workspace['user_role'], ['owner', 'admin']))
                        <button class="btn btn-outline-light btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal"
                            data-bs-target="#addProjectModal{{ $workspace['id'] }}">
                            <i class="bi bi-folder-plus"></i> New Project
                        </button>
                    @endif
                </div>
            </div>

            {{-- Projects Grid --}}
            <div class="card-body p-4" style="background-color: var(--bg-main);">
                @if(empty($workspace['projects']))
                    <div class="text-center py-4">
                        <i class="bi bi-folder2-open fs-3 text-muted mb-2 d-block"></i>
                        <p class="text-muted small m-0">No projects yet in this workspace.</p>
                        @if(in_array($workspace['user_role'], ['owner', 'admin']))
                            <button class="btn btn-sm btn-outline-light mt-3" data-bs-toggle="modal"
                                data-bs-target="#addProjectModal{{ $workspace['id'] }}">
                                <i class="bi bi-plus-lg me-1"></i> Create First Project
                            </button>
                        @endif
                    </div>
                @else
                    <div class="row g-3">
                        @foreach($workspace['projects'] as $project)
                            <div class="col-sm-6 col-lg-4 col-xl-3">
                                <a href="#" class="card h-100 rounded-3 text-decoration-none p-3 d-flex flex-column gap-2 project-card"
                                    style="background-color: var(--bg-card); border: 1px solid var(--border); transition: border-color .2s, transform .15s;">

                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="rounded-circle d-inline-block"
                                                style="width:12px; height:12px; background-color: {{ $project['color'] }};"></span>
                                            <span class="fw-semibold" style="color: var(--text-main);">
                                                {{ $project['icon'] ? $project['icon'] . ' ' : '' }}{{ $project['name'] }}
                                            </span>
                                        </div>
                                        @if($project['visibility'] === 'members_only')
                                            <i class="bi bi-lock-fill text-muted small" title="Members only"></i>
                                        @endif
                                    </div>

                                    <p class="text-muted small m-0 flex-grow-1 {{ $project['description'] ? '' : 'fst-italic' }}"
                                        style="line-height: 1.4;">
                                        {{ $project['description'] ? Str::limit($project['description'], 80) : 'No description' }}
                                    </p>

                                    <div class="d-flex align-items-center justify-content-between mt-1">
                                        <span class="badge bg-secondary rounded-pill small">
                                            {{ $project['task_count'] }} tasks
                                        </span>
                                        <i class="bi bi-arrow-right-short text-muted"></i>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Add Project Modal (per workspace) --}}
        @if(in_array($workspace['user_role'], ['owner', 'admin']))
            <div class="modal fade" id="addProjectModal{{ $workspace['id'] }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">
                                <i class="bi bi-folder-plus me-2"></i>New Project in <em>{{ $workspace['name'] }}</em>
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="#" method="POST">
                            @csrf
                            <input type="hidden" name="workspace_id" value="{{ $workspace['id'] }}">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label small">Project Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="e.g. Website Redesign"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small">Description</label>
                                    <textarea name="description" class="form-control" rows="2"
                                        placeholder="What is this project about?"></textarea>
                                </div>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <label class="form-label small">Icon (emoji)</label>
                                        <input type="text" name="icon" class="form-control" placeholder="🚀">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small">Colour</label>
                                        <input type="color" name="color" class="form-control form-control-color w-100"
                                            value="#8b5cf6">
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label class="form-label small">Visibility</label>
                                    <select name="visibility" class="form-select">
                                        <option value="all">🌐 All workspace members</option>
                                        <option value="members_only">🔒 Members only (restricted)</option>
                                    </select>
                                    <div class="form-text">Admins and the owner always see all projects.</div>
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Create Project</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @empty
        <div class="card rounded-4 p-5 text-center">
            <i class="bi bi-briefcase fs-1 mb-3" style="color: var(--primary);"></i>
            <h5 class="fw-bold">No workspaces yet</h5>
            <p class="text-muted small mb-4">Create a workspace to start collaborating with your team.</p>
            <div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createWorkspaceModal">
                    <i class="bi bi-plus-lg me-1"></i> Create Workspace
                </button>
            </div>
        </div>
    @endforelse

    <style>
        .project-card:hover {
            border-color: var(--primary) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, .25);
        }
    </style>
@endsection