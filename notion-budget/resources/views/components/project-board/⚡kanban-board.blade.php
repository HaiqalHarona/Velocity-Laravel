<?php

use Livewire\Component;
use App\Models\Project;
// use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
// use Livewire\Attributes\On;
use App\Models\Task;

new class extends Component {
    public $projectId;
    #[Computed]
    public function project()
    {
        return Project::findOrFail($this->projectId);
    }
    #[Computed]
    public function columns()
    {
        // Return from project Function
        return $this->project->pools;
    }
    #[Computed]
    public function tasks()
    {
        return Task::with(['comments', 'task_assignees', 'tags'])
            ->whereIn('pool_id', $this->project->pools->pluck('id'))
            ->get();
    }
};
?>

<div class="kanban-board">
    @foreach($this->columns as $pool)
        <div class="kanban-column">
            <div class="kanban-column-header">
                <div class="col-title">
                    <span
                        style="width:10px;height:10px;border-radius:50%;background:{{ $pool->color }};display:inline-block;"></span>
                    {{ $pool->name }}
                    <span class="col-count">1</span>
                </div>
                <button class="btn btn-sm p-0" style="color:var(--text-muted);background:none;border:none;">
                    <i class="bi bi-three-dots"></i>
                </button>
            </div>
            <div class="kanban-column-body">
                <div class="task-card">
                    <div class="task-title">Design landing page mockup</div>
                    <div class="task-desc">Create high-fidelity mockups for the new marketing landing page with responsive
                        layouts.</div>
                    <div class="task-dates">
                        <i class="bi bi-calendar3"></i> Mar 1
                        <span class="date-separator"><i class="bi bi-arrow-right"></i></span>
                        <i class="bi bi-calendar3"></i> Mar 5
                    </div>
                    <div class="task-meta">
                        <div class="d-flex align-items-center gap-1">
                            <span class="task-tag tag-design">Design</span>
                            <span class="task-tag tag-high">High</span>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <span class="task-due"><i class="bi bi-calendar3"></i> Mar 5</span>
                            <img src="https://ui-avatars.com/api/?name=JD&background=8b5cf6&color=fff&size=24&bold=true"
                                class="task-avatar" alt="JD">
                        </div>
                    </div>
                </div>
                @can('roleBoardActions', $this->project)
                    <button class="btn btn-primary btn-sm d-flex align-items-center gap-1"
                        style="border-radius:10px; font-size:.8rem; box-shadow: 0 3px 12px rgba(139,92,246,.3);"
                        data-bs-toggle="modal" data-bs-target="#addTaskModal">
                        <i class="bi bi-plus-lg"></i> Add Task
                    </button>
                @endcan
            </div>
        </div>
    @endforeach

    {{-- Add Column --}}
    @can('roleBoardActions', $this->project)
        <div class="add-column" data-bs-toggle="modal" data-bs-target="#addColumnModal" style="cursor: pointer;">
            <i class="bi bi-plus-lg"></i> Add Pool
        </div>

        {{-- Add Pool Modal --}}
        <div class="modal fade" id="addColumnModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-layout-three-columns me-2"></i>Add Pool</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('project.pools.add', $this->project->hashed_id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Pool Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="e.g. To Do, Review"
                                    required>
                            </div>
                            <div class="mb-1">
                                <label class="form-label small fw-semibold">Pool Color</label>
                                <input type="color" name="color" class="form-control form-control-color w-100"
                                    value="#a78bfa" title="Choose column color">
                            </div>
                            <input type="hidden" name="project_id" value="{{ $this->project->id }}">
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create Pool</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan

    @can('roleBoardActions', $this->project)
        <div class="modal fade" id="addTaskModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-plus-lg me-2"></i>Add Task</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="#" method="POST">
                        @csrf
                        <div class="modal-body">

                            {{-- Title (required) --}}
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Task Title <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" placeholder="What needs to be done?"
                                    required>
                            </div>

                            {{-- Description (optional) --}}
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Description</label>
                                <textarea name="description" class="form-control" rows="3"
                                    placeholder="Add details..."></textarea>
                            </div>

                            {{-- Priority & Tags row --}}
                            <div class="row mb-3">
                                {{-- Tags (optional) --}}
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Tags <span
                                            class="text-muted fw-normal">(optional)</span></label>
                                    <div class="tags-checkbox-list">
                                        @foreach($this->project->tags as $tag)
                                            <label class="tag-checkbox-item">
                                                <input type="checkbox" name="task_tags[]" value="{{ $tag->id }}">
                                                <span class="tag-color-dot" style="background: {{ $tag->color }};"></span>
                                                {{ $tag->name }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- Start Date & End Date row --}}
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label small fw-semibold">Start Date <span
                                            class="text-muted fw-normal">(optional)</span></label>
                                    <input type="date" name="start_date" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">End Date <span
                                            class="text-muted fw-normal">(optional)</span></label>
                                    <input type="date" name="end_date" class="form-control">
                                </div>
                            </div>

                            {{-- Assign Users (optional) --}}
                            <div class="mb-1">
                                <label class="form-label small fw-semibold">Assign Users <span
                                        class="text-muted fw-normal">(optional)</span></label>
                                <div class="user-search-wrapper" x-data="{
                                                search: '',
                                                users: {{ json_encode($this->project->members->map(fn($m) => [
            'name' => $m->user->name,
            'email' => $m->user->email,
            'avatar' => $m->user->avatar
                ? (Str::startsWith($m->user->avatar, ['http://', 'https://'])
                    ? $m->user->avatar
                    : Storage::url($m->user->avatar))
                : 'https://ui-avatars.com/api/?name=' . urlencode($m->user->name) . '&background=' . substr(md5($m->user->email), 0, 6) . '&color=fff&size=32&bold=true'
        ])->values()->toArray()) }},
                                                selected: [],
                                                get filtered() {
                                                    if (!this.search) return this.users;
                                                    return this.users.filter(u =>
                                                        u.name.toLowerCase().includes(this.search.toLowerCase()) ||
                                                        u.email.toLowerCase().includes(this.search.toLowerCase())
                                                    );
                                                },
                                                toggle(user) {
                                                    const idx = this.selected.findIndex(s => s.email === user.email);
                                                    if (idx > -1) this.selected.splice(idx, 1);
                                                    else this.selected.push(user);
                                                },
                                                isSelected(email) {
                                                    return this.selected.some(s => s.email === email);
                                                }
                                            }">
                                    {{-- Search input --}}
                                    <div class="position-relative">
                                        <i class="bi bi-search user-search-icon"></i>
                                        <input type="text" class="form-control user-search-input"
                                            placeholder="Search by name..." x-model="search">
                                    </div>

                                    {{-- Selected users chips --}}
                                    <div class="selected-users-chips" x-show="selected.length > 0" x-cloak>
                                        <template x-for="user in selected" :key="user.email">
                                            <span class="user-chip">
                                                <img :src="user.avatar" class="user-chip-avatar" style="object-fit: cover;"
                                                    :alt="user.name">
                                                <span x-text="user.name"></span>
                                                <i class="bi bi-x-lg user-chip-remove" @click="toggle(user)"></i>
                                                <input type="hidden" name="assignees[]" :value="user.email">
                                            </span>
                                        </template>
                                    </div>

                                    {{-- User results list --}}
                                    <div class="user-results-list">
                                        <template x-for="user in filtered" :key="user.email">
                                            <div class="user-result-item" :class="{ 'selected': isSelected(user.email) }"
                                                @click="toggle(user)">
                                                <img :src="user.avatar" class="user-result-avatar"
                                                    style="object-fit: cover;" :alt="user.name">
                                                <div class="user-result-info">
                                                    <span class="user-result-name" x-text="user.name"></span>
                                                    <span class="user-result-email" x-text="user.email"></span>
                                                </div>
                                                <i class="bi bi-check-lg user-result-check"
                                                    x-show="isSelected(user.email)"></i>
                                            </div>
                                        </template>
                                        <div class="user-result-empty" x-show="filtered.length === 0">
                                            <i class="bi bi-person-x"></i> No users found
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Create Task</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>

    @endcan



</div>