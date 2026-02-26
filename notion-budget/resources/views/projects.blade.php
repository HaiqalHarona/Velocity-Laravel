@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold m-0">My Projects</h2>
            <p class="text-muted m-0 small">All your projects in one place</p>
        </div>
        <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
            data-bs-target="#createProjectModal">
            <i class="bi bi-plus-lg"></i> New Project
        </button>
    </div>

    {{-- Projects Grid --}}
    @forelse($projects as $project)
        <div class="card rounded-4 mb-5 overflow-hidden">
            {{-- Project Header --}}
            <div class="card-header p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3"
                style="background-color: var(--bg-card); border-bottom: 1px solid var(--border); border-left: 4px solid {{ $project['color'] }};">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center fs-4"
                        style="background-color: {{ $project['color'] }}22; width: 48px; height: 48px; flex-shrink: 0;">
                        {{ $project['icon'] }}
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <h5 class="fw-bold m-0">{{ $project['name'] }}</h5>
                            @php
                                $myRole = collect($project['members'])->firstWhere('name', 'You')['role'] ?? 'viewer';
                                $roleBadge = match ($myRole) {
                                    'owner' => 'bg-warning text-dark',
                                    'admin' => 'bg-danger',
                                    'member' => 'bg-primary',
                                    default => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge rounded-pill small {{ $roleBadge }}">{{ ucfirst($myRole) }}</span>
                        </div>
                        <p class="text-muted small m-0 mt-1">
                            {{ count($project['pools']) }} pools &middot;
                            {{ array_sum(array_map(fn($p) => count($p['tasks']), $project['pools'])) }} tasks
                        </p>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3 flex-wrap">
                    {{-- Member Avatars --}}
                    <div class="d-flex align-items-center">
                        @foreach(array_slice($project['members'], 0, 5) as $i => $member)
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($member['name']) }}&background=random&color=fff"
                                alt="{{ $member['name'] }}" title="{{ $member['name'] }} ({{ $member['role'] }})"
                                class="rounded-circle border border-dark" width="30" height="30"
                                style="{{ $i > 0 ? 'margin-left:-10px;' : '' }}">
                        @endforeach
                        @if(count($project['members']) > 5)
                            <span class="badge bg-secondary rounded-pill ms-1 small">+{{ count($project['members']) - 5 }}</span>
                        @endif
                    </div>
                    <button class="btn btn-outline-light btn-sm d-flex align-items-center gap-1">
                        <i class="bi bi-kanban"></i> Open Board
                    </button>
                </div>
            </div>

            {{-- Kanban Board Preview --}}
            <div class="p-3" style="background-color: var(--bg-main); overflow-x: auto;">
                <div class="d-flex gap-3" style="min-width: max-content;">
                    @foreach($project['pools'] as $pool)
                        <div class="rounded-3 p-3 d-flex flex-column gap-2"
                            style="width: 240px; background-color: var(--bg-card); border: 1px solid var(--border); min-height: 120px;">

                            {{-- Pool Header --}}
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="rounded-circle d-inline-block"
                                        style="width: 10px; height: 10px; background-color: {{ $pool['color'] }}; flex-shrink: 0;"></span>
                                    <span class="fw-semibold small">{{ $pool['name'] }}</span>
                                </div>
                                <span class="badge bg-secondary rounded-pill" style="font-size: 0.7rem;">
                                    {{ count($pool['tasks']) }}
                                </span>
                            </div>

                            {{-- Tasks in Pool --}}
                            @foreach($pool['tasks'] as $task)
                                <div class="rounded-3 p-2 task-card"
                                    style="background-color: var(--bg-main); border: 1px solid var(--border); cursor: pointer;">
                                    <div class="small fw-semibold mb-1" style="color: var(--text-main); line-height: 1.3;">
                                        {{ $task['title'] }}
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-1 mt-1">
                                        @php
                                            $prioColor = match ($task['priority']) {
                                                'high' => 'bg-danger',
                                                'medium' => 'bg-warning text-dark',
                                                'low' => 'bg-info text-dark',
                                                default => 'bg-secondary',
                                            };
                                        @endphp
                                        <span class="badge {{ $prioColor }} rounded-pill" style="font-size: 0.65rem;">
                                            {{ ucfirst($task['priority']) }}
                                        </span>
                                        @foreach($task['tags'] as $tag)
                                            <span class="badge bg-secondary rounded-pill" style="font-size: 0.65rem;">{{ $tag }}</span>
                                        @endforeach
                                        @if($task['end_date'])
                                            <span class="text-muted" style="font-size: 0.7rem;">
                                                <i
                                                    class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($task['end_date'])->format('M j') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            @if(empty($pool['tasks']))
                                <div class="text-center py-2">
                                    <span class="text-muted" style="font-size: 0.75rem;">No tasks</span>
                                </div>
                            @endif

                            {{-- Add Task Button --}}
                            <button class="btn btn-sm w-100 mt-1 d-flex align-items-center justify-content-center gap-1"
                                style="background: transparent; border: 1px dashed var(--border); color: var(--text-muted);">
                                <i class="bi bi-plus"></i>
                                <span style="font-size: 0.75rem;">Add task</span>
                            </button>
                        </div>
                    @endforeach

                    {{-- Add Pool Button --}}
                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                        style="width: 200px; min-height: 120px; border: 2px dashed var(--border); cursor: pointer; flex-shrink: 0; color: var(--text-muted);"
                        onclick="">
                        <div class="text-center">
                            <i class="bi bi-plus-circle fs-4 d-block mb-1"></i>
                            <span style="font-size: 0.8rem;">Add pool</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Members Footer --}}
            <div class="px-4 py-2 d-flex align-items-center gap-3 flex-wrap"
                style="background-color: var(--bg-card); border-top: 1px solid var(--border);">
                <span class="text-muted" style="font-size: 0.8rem;"><i class="bi bi-people me-1"></i>Members:</span>
                @foreach($project['members'] as $member)
                    @php
                        $mr = match ($member['role']) {
                            'owner' => 'bg-warning text-dark',
                            'admin' => 'bg-danger',
                            'member' => 'bg-primary',
                            default => 'bg-secondary',
                        };
                    @endphp
                    <span class="d-flex align-items-center gap-1" style="font-size: 0.8rem;">
                        <span class="badge {{ $mr }} rounded-pill" style="font-size: 0.65rem;">{{ ucfirst($member['role']) }}</span>
                        {{ $member['name'] }}
                    </span>
                @endforeach
                <button class="btn btn-sm btn-outline-light ms-auto d-flex align-items-center gap-1"
                    style="font-size: 0.75rem;">
                    <i class="bi bi-person-plus"></i> Invite
                </button>
            </div>
        </div>
    @empty
        <div class="card rounded-4 p-5 text-center">
            <i class="bi bi-kanban fs-1 mb-3" style="color: var(--primary);"></i>
            <h5 class="fw-bold">No projects yet</h5>
            <p class="text-muted small mb-4">Create your first project and start organizing tasks into pools.</p>
            <div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProjectModal">
                    <i class="bi bi-plus-lg me-1"></i> Create Project
                </button>
            </div>
        </div>
    @endforelse

    {{-- Create Project Modal --}}
    <div class="modal fade" id="createProjectModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="bi bi-kanban me-2"></i>New Project</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="#" method="POST">
                    @csrf
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
                                <input type="text" name="icon" class="form-control" placeholder="🚀" maxlength="4">
                            </div>
                            <div class="col-6">
                                <label class="form-label small">Colour</label>
                                <input type="color" name="color" class="form-control form-control-color w-100"
                                    value="#6366f1">
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label small">Default Pools</label>
                            <div class="form-text mb-2">These pools will be created automatically.</div>
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach(['Backlog', 'In Progress', 'Review', 'Done'] as $poolName)
                                    <label class="d-flex align-items-center gap-1 small">
                                        <input type="checkbox" name="default_pools[]" value="{{ $poolName }}" checked>
                                        {{ $poolName }}
                                    </label>
                                @endforeach
                            </div>
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

    <style>
        .task-card:hover {
            border-color: var(--primary) !important;
            transform: translateY(-1px);
            box-shadow: 0 3px 12px rgba(0, 0, 0, .2);
            transition: all .15s ease;
        }

        .task-card {
            transition: all .15s ease;
        }
    </style>
@endsection