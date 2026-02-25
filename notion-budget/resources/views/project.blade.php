@extends('layouts.app')

@section('content')
    {{-- Project Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb" class="mb-1">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item">
                        <a href="{{ route('workspace') }}" class="text-decoration-none" style="color: var(--primary);">
                            <i class="bi bi-briefcase me-1"></i>{{ $workspace->name }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-muted">{{ $project->name }}</li>
                </ol>
            </nav>
            <h2 class="fw-bold m-0 d-flex align-items-center gap-2">
                @if($project->icon)
                    <span>{{ $project->icon }}</span>
                @endif
                {{ $project->name }}
                @if($project->visibility === 'members_only')
                    <span class="badge bg-secondary small align-self-center"><i class="bi bi-lock-fill me-1"></i>Members
                        only</span>
                @endif
            </h2>
            @if($project->description)
                <p class="text-muted m-0 small mt-1">{{ $project->description }}</p>
            @endif
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-light d-flex align-items-center gap-2" data-bs-toggle="modal"
                data-bs-target="#addMemberModal">
                <i class="bi bi-person-plus"></i> Add Member
            </button>
            <button class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
                data-bs-target="#addTaskModal">
                <i class="bi bi-plus-lg"></i> New Task
            </button>
        </div>
    </div>

    {{-- Task List --}}
    <div class="card rounded-4 p-0 overflow-hidden">
        <div class="card-header border-bottom p-3 d-flex justify-content-between align-items-center"
            style="background-color: var(--bg-card);">
            <h6 class="m-0 fw-bold">All Tasks</h6>
            <span class="badge bg-secondary rounded-pill">{{ $tasks->count() }}</span>
        </div>

        @if($tasks->isEmpty())
            <div class="p-5 text-center" style="background-color: transparent;">
                <i class="bi bi-check2-all fs-1 text-muted mb-3 d-block"></i>
                <p class="text-muted">No tasks yet. Create the first one!</p>
            </div>
        @else
            <ul class="list-group list-group-flush" style="background-color: transparent;">
                @foreach($tasks as $task)
                    <li class="list-group-item p-3" style="background-color: transparent; border-color: var(--border);">
                        <div class="row align-items-center">
                            <div class="col-md-6 d-flex align-items-center gap-3 mb-2 mb-md-0">
                                <input class="form-check-input mt-0" type="checkbox" {{ $task->status === 'done' ? 'checked' : '' }}
                                    style="width: 1.2rem; height: 1.2rem;">
                                <div>
                                    <h6 class="m-0 {{ $task->status === 'done' ? 'text-decoration-line-through text-muted' : '' }}"
                                        style="color: var(--text-main);">{{ $task->title }}</h6>
                                    <small class="text-muted">
                                        Assigned to:
                                        {{ $task->task_assignees->pluck('user.name')->filter()->join(', ') ?: 'Unassigned' }}
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-2 text-md-center mb-2 mb-md-0">
                                @php
                                    $statusMap = ['todo' => 'bg-secondary', 'in_progress' => 'bg-primary', 'done' => 'bg-success'];
                                    $statusLabel = ['todo' => 'To Do', 'in_progress' => 'In Progress', 'done' => 'Done'];
                                @endphp
                                <span class="badge {{ $statusMap[$task->status] ?? 'bg-secondary' }} rounded-pill">
                                    {{ $statusLabel[$task->status] ?? ucfirst($task->status) }}
                                </span>
                            </div>
                            <div class="col-md-2 text-md-center mb-2 mb-md-0">
                                @php
                                    $prioMap = ['high' => 'bg-danger', 'medium' => 'bg-warning text-dark', 'low' => 'bg-info text-dark'];
                                @endphp
                                @if($task->priority)
                                    <span class="badge {{ $prioMap[$task->priority] ?? 'bg-secondary' }} rounded-pill">
                                        {{ ucfirst($task->priority) }} Priority
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-2 text-md-end text-muted small">
                                {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M j, Y') : '—' }}
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- Add Task Modal --}}
    <div class="modal fade" id="addTaskModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Add New Task</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="#">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        <div class="mb-3">
                            <label class="form-label small">Task Title</label>
                            <input type="text" name="title" class="form-control" placeholder="What needs to be done?"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Description</label>
                            <textarea name="description" class="form-control" rows="4"
                                placeholder="Add some details..."></textarea>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label small">Assign To</label>
                                <select name="assignee" class="form-select">
                                    <option selected>Unassigned</option>
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
                                <label class="form-label small">Due Date</label>
                                <input type="date" name="due_date" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Save Task</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Member Modal --}}
    <div class="modal fade" id="addMemberModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Add to Project</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="#">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="colleague@example.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Project Role</label>
                            <select name="role" class="form-select">
                                <option value="editor">Editor (Can edit tasks)</option>
                                <option value="viewer" selected>Viewer (Read-only)</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Add Member</button>
                </div>
            </div>
        </div>
    </div>
@endsection