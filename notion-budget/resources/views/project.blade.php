@extends('layouts.app')

@section('content')
    {{-- Project Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <nav aria-label="breadcrumb" class="mb-1">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item">
                        <a href="{{ route('projects') }}" class="text-decoration-none" style="color: var(--primary);">
                            <i class="bi bi-kanban me-1"></i>Projects
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-muted">{{ $project['name'] }}</li>
                </ol>
            </nav>
            <h2 class="fw-bold m-0 d-flex align-items-center gap-2">
                <span>{{ $project['icon'] }}</span>
                {{ $project['name'] }}
            </h2>
            <p class="text-muted m-0 small mt-1">{{ $project['description'] ?? 'No description' }}</p>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <button class="btn btn-outline-light d-flex align-items-center gap-2" data-bs-toggle="modal"
                data-bs-target="#addMemberModal">
                <i class="bi bi-person-plus"></i> Invite
            </button>
            <button class="btn btn-outline-light d-flex align-items-center gap-2" data-bs-toggle="modal"
                data-bs-target="#addPoolModal">
                <i class="bi bi-layout-three-columns"></i> Add Pool
            </button>
            <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
                data-bs-target="#addTaskModal">
                <i class="bi bi-plus-lg"></i> New Task
            </button>
        </div>
    </div>

    {{-- Members Bar --}}
    <div class="d-flex align-items-center gap-2 mb-4 flex-wrap">
        @foreach($project['members'] as $i => $member)
            @php
                $mr = match ($member['role']) {
                    'owner' => 'bg-warning text-dark',
                    'admin' => 'bg-danger',
                    'member' => 'bg-primary',
                    default => 'bg-secondary',
                };
            @endphp
            <div class="d-flex align-items-center gap-2 px-2 py-1 rounded-pill"
                style="background-color: var(--bg-card); border: 1px solid var(--border); font-size: 0.8rem;">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($member['name']) }}&background=random&color=fff"
                    alt="{{ $member['name'] }}" class="rounded-circle" width="22" height="22">
                <span style="color: var(--text-main);">{{ $member['name'] }}</span>
                <span class="badge {{ $mr }} rounded-pill" style="font-size: 0.6rem;">{{ ucfirst($member['role']) }}</span>
            </div>
        @endforeach
    </div>

    {{-- Kanban Board --}}
    <div style="overflow-x: auto; padding-bottom: 1.5rem;">
        <div class="d-flex gap-3 align-items-start" style="min-width: max-content;">
            @foreach($project['pools'] as $pool)
                <div class="rounded-4 d-flex flex-column gap-2"
                    style="width: 280px; background-color: var(--bg-card); border: 1px solid var(--border); overflow: hidden;">

                    {{-- Pool Header --}}
                    <div class="d-flex align-items-center justify-content-between px-3 py-2"
                        style="border-bottom: 3px solid {{ $pool['color'] }}; background-color: var(--bg-card);">
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-semibold">{{ $pool['name'] }}</span>
                            <span class="badge bg-secondary rounded-pill"
                                style="font-size: 0.7rem;">{{ count($pool['tasks']) }}</span>
                        </div>
                        <button class="btn btn-sm p-0 text-muted" style="line-height: 1;" title="Options">
                            <i class="bi bi-three-dots"></i>
                        </button>
                    </div>

                    {{-- Task Cards --}}
                    <div class="d-flex flex-column gap-2 px-2 pb-2">
                        @foreach($pool['tasks'] as $task)
                            <div class="task-card rounded-3 p-3"
                                style="background-color: var(--bg-main); border: 1px solid var(--border); cursor: pointer;"
                                data-bs-toggle="modal" data-bs-target="#taskDetailModal{{ $task['id'] }}">

                                {{-- Tags --}}
                                @if(!empty($task['tags']))
                                    <div class="d-flex flex-wrap gap-1 mb-2">
                                        @foreach($task['tags'] as $tag)
                                            <span class="badge bg-secondary rounded-pill" style="font-size: 0.65rem;">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="fw-semibold small mb-2" style="color: var(--text-main); line-height: 1.3;">
                                    {{ $task['title'] }}
                                </div>

                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-1">
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

                                    <div class="d-flex align-items-center gap-2">
                                        @if($task['start_date'] || $task['end_date'])
                                            <span class="text-muted" style="font-size: 0.7rem;">
                                                <i class="bi bi-calendar3 me-1"></i>
                                                @if($task['start_date'] && $task['end_date'])
                                                    {{ \Carbon\Carbon::parse($task['start_date'])->format('M j') }}
                                                    → {{ \Carbon\Carbon::parse($task['end_date'])->format('M j') }}
                                                @elseif($task['end_date'])
                                                    Due {{ \Carbon\Carbon::parse($task['end_date'])->format('M j') }}
                                                @else
                                                    From {{ \Carbon\Carbon::parse($task['start_date'])->format('M j') }}
                                                @endif
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Task Detail Modal --}}
                            <div class="modal fade" id="taskDetailModal{{ $task['id'] }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">{{ $task['title'] }}</h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-md-8">
                                                    <label class="form-label small text-muted">Description</label>
                                                    <p class="small" style="color: var(--text-main);">
                                                        {{ $task['description'] ?? 'No description added yet.' }}
                                                    </p>
                                                    <hr style="border-color: var(--border);">
                                                    <label class="form-label small text-muted">Comments</label>
                                                    <div class="text-muted small fst-italic">No comments yet.</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="d-flex flex-column gap-3">
                                                        <div>
                                                            <label class="form-label small text-muted d-block">Pool</label>
                                                            <span class="badge bg-secondary rounded-pill">{{ $pool['name'] }}</span>
                                                        </div>
                                                        <div>
                                                            <label class="form-label small text-muted d-block">Priority</label>
                                                            <span
                                                                class="badge {{ $prioColor }} rounded-pill">{{ ucfirst($task['priority']) }}</span>
                                                        </div>
                                                        @if($task['start_date'])
                                                            <div>
                                                                <label class="form-label small text-muted d-block">Start Date</label>
                                                                <span
                                                                    class="small">{{ \Carbon\Carbon::parse($task['start_date'])->format('M j, Y') }}</span>
                                                            </div>
                                                        @endif
                                                        @if($task['end_date'])
                                                            <div>
                                                                <label class="form-label small text-muted d-block">End Date</label>
                                                                <span
                                                                    class="small">{{ \Carbon\Carbon::parse($task['end_date'])->format('M j, Y') }}</span>
                                                            </div>
                                                        @endif
                                                        @if(!empty($task['tags']))
                                                            <div>
                                                                <label class="form-label small text-muted d-block">Tags</label>
                                                                <div class="d-flex flex-wrap gap-1">
                                                                    @foreach($task['tags'] as $tag)
                                                                        <span class="badge bg-secondary rounded-pill"
                                                                            style="font-size: 0.7rem;">{{ $tag }}</span>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-outline-light"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Edit Task</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if(empty($pool['tasks']))
                            <div class="text-center py-3">
                                <i class="bi bi-inbox text-muted d-block mb-1"></i>
                                <span class="text-muted" style="font-size: 0.75rem;">Empty pool</span>
                            </div>
                        @endif

                        {{-- Add Task in Pool --}}
                        <button class="btn btn-sm w-100 d-flex align-items-center justify-content-center gap-1 mt-1"
                            style="background: transparent; border: 1px dashed var(--border); color: var(--text-muted); font-size: 0.8rem;"
                            data-bs-toggle="modal" data-bs-target="#addTaskModal">
                            <i class="bi bi-plus"></i> Add task
                        </button>
                    </div>
                </div>
            @endforeach

            {{-- Add Pool Column --}}
            <div class="rounded-4 d-flex align-items-center justify-content-center"
                style="width: 220px; min-height: 160px; border: 2px dashed var(--border); cursor: pointer; flex-shrink: 0; color: var(--text-muted);"
                data-bs-toggle="modal" data-bs-target="#addPoolModal">
                <div class="text-center">
                    <i class="bi bi-plus-circle fs-3 d-block mb-2"></i>
                    <span style="font-size: 0.85rem;">New Pool</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Task Modal --}}
    <div class="modal fade" id="addTaskModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="bi bi-plus-lg me-2"></i>New Task</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="#">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small">Task Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" placeholder="What needs to be done?"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Description</label>
                            <textarea name="description" class="form-control" rows="3"
                                placeholder="Add some details…"></textarea>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label small">Pool <span class="text-danger">*</span></label>
                                <select name="pool_id" class="form-select">
                                    @foreach($project['pools'] as $pool)
                                        <option value="{{ $pool['id'] }}">{{ $pool['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Priority</label>
                                <select name="priority" class="form-select">
                                    <option value="low">Low</option>
                                    <option value="medium" selected>Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small">Assign To</label>
                                <select name="assignee_email" class="form-select">
                                    <option value="">Unassigned</option>
                                    @foreach($project['members'] as $member)
                                        <option value="{{ $member['name'] }}">{{ $member['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small">Start Date</label>
                                <input type="date" name="start_date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">End Date</label>
                                <input type="date" name="end_date" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Add Pool Modal --}}
    <div class="modal fade" id="addPoolModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="bi bi-layout-three-columns me-2"></i>New Pool</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="#">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small">Pool Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. To Do, In Progress, Done…"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Colour</label>
                            <input type="color" name="color" class="form-control form-control-color w-100" value="#6366f1">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Pool</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Invite Member Modal --}}
    <div class="modal fade" id="addMemberModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="bi bi-person-plus me-2"></i>Invite to Project</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="#">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="colleague@example.com"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Project Role</label>
                            <select name="role" class="form-select">
                                <option value="admin">Admin — Can manage members &amp; pools</option>
                                <option value="member" selected>Member — Can create &amp; edit tasks</option>
                                <option value="viewer">Viewer — Read-only access</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Send Invite</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .task-card {
            transition: all .15s ease;
        }

        .task-card:hover {
            border-color: var(--primary) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, .25);
        }
    </style>
@endsection