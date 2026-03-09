@extends('layouts.app')

@section('content')
    <style>
        .fw-bold {
            color: var(--text-main);
        }
    </style>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Dashboard</h2>
        <span class="text-muted">
            {{ now()->timezone(auth()->user()->timezone ?? config('app.timezone'))->format('l, F j, Y') }}
        </span>
    </div>

    <div class="row g-4 mb-5 justify-content-center">
        <livewire:dashboard-display />
    </div>


    <h5 class="fw-bold mb-3">Recent Tasks</h5>
    <div class="card rounded-4 p-0 overflow-hidden border-0 shadow-sm">
        <ul class="list-group list-group-flush" style="background-color: transparent;">
            <!-- Task Item 1 -->
            <li class="list-group-item p-4" style="background-color: var(--bg-main); border-color: var(--border);">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h6 class="m-0 fw-bold" style="color: var(--text-main);">Update Landing Page Copy</h6>
                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill border border-danger border-opacity-25" style="font-size: 0.7rem;">High Priority</span>
                        </div>
                        <small class="text-muted d-flex align-items-center gap-2">
                            <i class="bi bi-briefcase"></i> Marketing Workspace
                            <span class="text-secondary">&bull;</span>
                            <i class="bi bi-calendar-event"></i> Due Today
                        </small>
                    </div>
                    
                    <div class="d-flex align-items-center">
                        <div class="d-flex">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white bg-primary shadow-sm" 
                                style="width: 32px; height: 32px; border: 2px solid var(--bg-main); font-size: 0.8rem; z-index: 3;">
                                JD
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white bg-success shadow-sm" 
                                style="width: 32px; height: 32px; border: 2px solid var(--bg-main); font-size: 0.8rem; z-index: 2; margin-left: -10px;">
                                AS
                            </div>
                        </div>
                    </div>
                </div>
                
                <p class="text-muted mb-3 mt-3" style="font-size: 0.95rem; line-height: 1.5;">
                    Revise the main headline and body copy to better align with our new brand guidelines. Ensure SEO keywords are integrated naturally throughout the text before passing it to design.
                </p>

                <div class="d-flex gap-2">
                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill fw-normal px-2 py-1">Marketing</span>
                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill fw-normal px-2 py-1">Copywriting</span>
                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill fw-normal px-2 py-1">Website</span>
                </div>
            </li>

            <!-- Task Item 2 -->
            <li class="list-group-item p-4" style="background-color: var(--bg-main); border-color: var(--border);">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h6 class="m-0 fw-bold" style="color: var(--text-main);">Fix Navigation Bug</h6>
                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill border border-warning border-opacity-25" style="font-size: 0.7rem;">Medium Priority</span>
                        </div>
                        <small class="text-muted d-flex align-items-center gap-2">
                            <i class="bi bi-briefcase"></i> Engineering Workspace
                            <span class="text-secondary">&bull;</span>
                            <i class="bi bi-calendar-event"></i> Due Tomorrow
                        </small>
                    </div>
                    
                    <div class="d-flex align-items-center">
                        <div class="d-flex">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white bg-info shadow-sm" 
                                style="width: 32px; height: 32px; border: 2px solid var(--bg-main); font-size: 0.8rem; z-index: 3;">
                                MK
                            </div>
                        </div>
                    </div>
                </div>
                
                <p class="text-muted mb-3 mt-3" style="font-size: 0.95rem; line-height: 1.5;">
                    The dropdown menu on the mobile responsive layout is not collapsing when tapping outside. Needs to be fixed before the next release cycle this Friday.
                </p>

                <div class="d-flex gap-2">
                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill fw-normal px-2 py-1">Bug</span>
                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill fw-normal px-2 py-1">Frontend</span>
                </div>
            </li>
        </ul>
    </div>
@endsection