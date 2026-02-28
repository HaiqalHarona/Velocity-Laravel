<?php

use Livewire\Component;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed; // Optimisation (Caching queries)


new class extends Component {
    #[Computed]
    public function active_project_count()
    {
        return Project::where('owner_email', Auth::user()->email)->where('status', 'active')->get()->count();
    }

};
?>

<div class="col-md-4" wire:poll.1s>
    <div class="card p-4 h-100 rounded-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h6 class="text-muted m-0">Active Projects</h6>
            <i class="bi bi-briefcase fs-4" style="color: var(--primary);"></i>
        </div>
        <h2 class="fw-bold m-0">
            @if($this->active_project_count == 0)
                0
            @else
                {{ $this->active_project_count }}
            @endif
        </h2>
    </div>
</div>