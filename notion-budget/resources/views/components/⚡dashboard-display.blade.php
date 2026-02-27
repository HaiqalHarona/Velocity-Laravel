<?php

use Livewire\Component;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;


new class extends Component {
    public $active_project;

    public function mount()
    {
        $this->active_project = Project::where('owner_email', Auth::user()->email)->where('status', 'active')->get()->count();
    }


};
?>

<div class="col-md-4">
    <div class="card p-4 h-100 rounded-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h6 class="text-muted m-0">Active Projects</h6>
            <i class="bi bi-briefcase fs-4" style="color: var(--primary);"></i>
        </div>
        <h2 class="fw-bold m-0">
            @if($active_project == 0)
                0
            @else
                {{ $active_project }}
            @endif
        </h2>
    </div>
</div>