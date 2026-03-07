<?php

use Livewire\Component;
use App\Models\Project;
use App\Models\ProjectMember;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
/**
 * This component handles form submission for member invite and object creation within the project
 **/
new class extends Component {

    public $projectId;

    // Listens for stupid events like project updates from stupid owners and admins of the project
    #[On('project-updated')]

    public function refreshHeader()
    {
    }

    #[Computed]
    public function project()
    {
        return Project::findOrFail($this->projectId);
    }

    #[Computed]
    public function projectHeader()
    {
        /**
         Query to show the damn project header and the details on live update
        **/

        $header = Project::whereHas('members', function ($query) {
            $query->where('user_email', Auth::user()->email);
        })->where('status', 'active')->where('id', $this->projectId)->withCount(['members', 'pools', 'tasks'])->first();

        return $header;
    }
};
?>

<div>
    {{-- Board Header --}}
    <div class="board-header">
        <div class="board-icon">
            @if($this->projectHeader->icon)
                <img src="{{ Storage::url($this->projectHeader->icon) }}" alt="Project icon">
            @else
                <div class="board-icon"
                    style="background: {{ $this->projectHeader->color }}; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:700; font-size:1.2rem;">
                    {{ strtoupper(substr($this->projectHeader->name, 0, 1)) }}
                </div>
            @endif
        </div>
        <div>
            <h2>{{ $this->projectHeader->name }}</h2>
            <span class="text-muted" style="font-size:.8rem;">{{ $this->projectHeader->pools_count }} pools &bull;
                {{ $this->projectHeader->tasks_count }} tasks &bull;
                {{ $this->projectHeader->members_count }} members</span>
        </div>
        <div class="ms-auto d-flex gap-2">
            @can('roleBoardActions', $this->project)
                <button class="btn btn-outline-light btn-sm d-flex align-items-center gap-1"
                    style="border-radius:10px; font-size:.8rem;" data-bs-toggle="modal" data-bs-target="#addTagsModal">
                    <i class="bi bi-tag"></i> Add Tags
                </button>
            @endcan
            <a href="{{ route('project.members', $this->project->hashed_id) }}"
                class="btn btn-outline-light btn-sm d-flex align-items-center gap-1"
                style="border-radius:10px; font-size:.8rem;">
                <i class="bi bi-people"></i> Members
            </a>
        </div>
    </div>

    {{-- Add Tags Modal --}}
    @can('roleBoardActions', $this->project)
        <div class="modal fade" id="addTagsModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-tag me-2"></i>Add Tag</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('project.tags.add', $this->projectHeader->hashed_id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Tag Name</label>
                                <input type="text" name="tag_name" class="form-control" placeholder="e.g. Bug, Feature"
                                    required>
                            </div>
                            <div class="mb-1">
                                <label class="form-label small fw-semibold">Tag Color</label>
                                <input type="color" name="tag_color" class="form-control form-control-color w-100"
                                    value="#6c63ff" title="Choose tag color">
                            </div>
                            <input type="hidden" name="project_id" value="{{ $this->projectHeader->id }}">
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create Tag</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan



</div>