<?php

use Livewire\Component;
use App\Models\Workspace;
new class extends Component {
    public $workspaces = [];
    public string $name = '';

    // Get workspaces query builder get email from auth user
    public function getWorkspaces()
    {
        $this->workspaces = Workspace::where(
            'owner_email',
            auth()->user()->email
        )->get();

    }

    // Mount into dashboard view
    public function mount()
    {
        $this->getWorkspaces();
    }

    // Create workspace and clear modal (bootstrap backdrop) event
    public function createWorkspace()
    {
        $this->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
        ]);

        Workspace::create([
            'owner_email' => auth()->user()->email,
            'name' => $this->name,
        ]);
        $this->name = '';
        $this->dispatch('workspace-created');
    }
};
?>

<div>
    <!-- Create Workspace Modal -->

    <div class="modal fade" id="createWorkspaceModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Workspace</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form wire:submit.prevent="createWorkspace">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small">Workspace Name</label>
                            <input type="text" class="form-control" wire:model="name" placeholder="e.g. Marketing Team">
                            @error('name')
                                <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Workspace</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('workspace-created', () => {
        const modalEl = document.getElementById('createWorkspaceModal');
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
    });
</script>