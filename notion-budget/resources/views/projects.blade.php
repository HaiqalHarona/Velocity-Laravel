@extends('layouts.app')

@section('content')
    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold m-0">My Projects</h2>
            <p class="text-muted m-0 small">All your projects in one place</p>
        </div>
        <button class="btn btn-primary d-none d-md-flex align-items-center gap-2" data-bs-toggle="modal"
            data-bs-target="#createProjectModal">
            <i class="bi bi-plus-lg"></i> New Project
        </button>
    </div>

    <livewire:projects-page />

@endsection