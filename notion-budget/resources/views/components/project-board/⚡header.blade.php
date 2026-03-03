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
    public function projectHeader()
    {
        /**
         Query to show the damn project header and the details on live update
        **/

        $header = Project::whereHas('members', function ($query) {
            $query->where('user_email', Auth::user()->email);
        })->where('status', 'active')->with('members.user')->where('id', $this->projectId)->withCount('members')->first();

        return $header;
    }
};
?>

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
        <span class="text-muted" style="font-size:.8rem;">4 pools &bull; 12 tasks &bull;
            {{ $this->projectHeader->members_count }} members</span>
    </div>
    <div class="ms-auto d-flex gap-2">
        <button class="btn btn-outline-light btn-sm d-flex align-items-center gap-1"
            style="border-radius:10px; font-size:.8rem;">
            <i class="bi bi-tag"></i> Add Tags
        </button>
        <button class="btn btn-outline-light btn-sm d-flex align-items-center gap-1"
            style="border-radius:10px; font-size:.8rem;">
            <i class="bi bi-people"></i> Members
        </button>
        <button class="btn btn-primary btn-sm d-flex align-items-center gap-1"
            style="border-radius:10px; font-size:.8rem; box-shadow: 0 3px 12px rgba(139,92,246,.3);">
            <i class="bi bi-plus-lg"></i> Add Task
        </button>
    </div>
</div>