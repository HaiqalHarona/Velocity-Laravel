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

    {{-- ═══════════════════════════════════════════
    PROJECT 1 — Website Redesign
    ═══════════════════════════════════════════ --}}
    <div class="card rounded-4 mb-5 overflow-hidden">
        {{-- Project Header --}}
        <div class="card-header p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3"
            style="background-color: var(--bg-card); border-bottom: 1px solid var(--border); border-left: 4px solid #6366f1;">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center fs-4"
                    style="background-color: #6366f122; width: 48px; height: 48px; flex-shrink: 0;">
                    🌐
                </div>
                <div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <h5 class="fw-bold m-0 text-white">Website Redesign</h5>
                        <span class="badge rounded-pill small bg-warning text-dark">Owner</span>
                    </div>
                    <p class="text-muted small m-0 mt-1">4 pools &middot; 5 tasks</p>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3 flex-wrap">
                {{-- Member Avatars --}}
                <div class="d-flex align-items-center">
                    <img src="https://ui-avatars.com/api/?name=You&background=6366f1&color=fff" alt="You"
                        title="You (Owner)" class="rounded-circle" width="30" height="30"
                        style="border: 2px solid var(--border);">
                    <img src="https://ui-avatars.com/api/?name=Sarah+K&background=ec4899&color=fff" alt="Sarah K."
                        title="Sarah K. (Admin)" class="rounded-circle" width="30" height="30"
                        style="margin-left:-10px; border: 2px solid var(--border);">
                    <img src="https://ui-avatars.com/api/?name=Lee+M&background=22c55e&color=fff" alt="Lee M."
                        title="Lee M. (Member)" class="rounded-circle" width="30" height="30"
                        style="margin-left:-10px; border: 2px solid var(--border);">
                </div>
                <button class="btn btn-outline-light btn-sm d-flex align-items-center gap-1">
                    <i class="bi bi-kanban"></i> Open Board
                </button>
            </div>
        </div>

        {{-- Kanban Board Preview --}}
        <div class="p-3" style="background-color: var(--bg-main); overflow-x: auto;">
            <div class="d-flex gap-3" style="min-width: max-content;">

                {{-- Pool: Backlog --}}
                <div class="rounded-3 p-3 d-flex flex-column gap-2"
                    style="width: 240px; background-color: var(--bg-card); border: 1px solid var(--border); min-height: 120px;">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-circle d-inline-block"
                                style="width:10px;height:10px;background:#64748b;flex-shrink:0;"></span>
                            <span class="fw-semibold small">Backlog</span>
                        </div>
                        <span class="badge bg-secondary rounded-pill" style="font-size:.7rem;">2</span>
                    </div>
                    {{-- Task --}}
                    <div class="rounded-3 p-2 task-card"
                        style="background-color:var(--bg-main);border:1px solid var(--border);cursor:pointer;">
                        <div class="small fw-semibold mb-1" style="color:var(--text-main);line-height:1.3;">Audit existing
                            pages</div>
                        <div class="d-flex align-items-center gap-1 flex-wrap mt-1">
                            <span class="badge bg-warning text-dark rounded-pill" style="font-size:.65rem;">Medium</span>
                            <span class="badge bg-secondary rounded-pill" style="font-size:.65rem;">Research</span>
                            <span class="text-muted" style="font-size:.7rem;"><i class="bi bi-calendar3 me-1"></i>Mar
                                10</span>
                        </div>
                    </div>
                    {{-- Task --}}
                    <div class="rounded-3 p-2 task-card"
                        style="background-color:var(--bg-main);border:1px solid var(--border);cursor:pointer;">
                        <div class="small fw-semibold mb-1" style="color:var(--text-main);line-height:1.3;">Collect brand
                            assets</div>
                        <div class="d-flex align-items-center gap-1 flex-wrap mt-1">
                            <span class="badge bg-info text-dark rounded-pill" style="font-size:.65rem;">Low</span>
                        </div>
                    </div>
                    <button class="btn btn-sm w-100 mt-1 d-flex align-items-center justify-content-center gap-1"
                        style="background:transparent;border:1px dashed var(--border);color:var(--text-muted);">
                        <i class="bi bi-plus"></i><span style="font-size:.75rem;">Add task</span>
                    </button>
                </div>

                {{-- Pool: In Progress --}}
                <div class="rounded-3 p-3 d-flex flex-column gap-2"
                    style="width: 240px; background-color: var(--bg-card); border: 1px solid var(--border); min-height: 120px;">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-circle d-inline-block"
                                style="width:10px;height:10px;background:#f59e0b;flex-shrink:0;"></span>
                            <span class="fw-semibold small">In Progress</span>
                        </div>
                        <span class="badge bg-secondary rounded-pill" style="font-size:.7rem;">1</span>
                    </div>
                    <div class="rounded-3 p-2 task-card"
                        style="background-color:var(--bg-main);border:1px solid var(--border);cursor:pointer;">
                        <div class="small fw-semibold mb-1" style="color:var(--text-main);line-height:1.3;">Design homepage
                            mockup</div>
                        <div class="d-flex align-items-center gap-1 flex-wrap mt-1">
                            <span class="badge bg-danger rounded-pill" style="font-size:.65rem;">High</span>
                            <span class="badge bg-secondary rounded-pill" style="font-size:.65rem;">Design</span>
                            <span class="text-muted" style="font-size:.7rem;"><i class="bi bi-calendar3 me-1"></i>Mar
                                5</span>
                        </div>
                    </div>
                    <button class="btn btn-sm w-100 mt-1 d-flex align-items-center justify-content-center gap-1"
                        style="background:transparent;border:1px dashed var(--border);color:var(--text-muted);">
                        <i class="bi bi-plus"></i><span style="font-size:.75rem;">Add task</span>
                    </button>
                </div>

                {{-- Pool: Review --}}
                <div class="rounded-3 p-3 d-flex flex-column gap-2"
                    style="width: 240px; background-color: var(--bg-card); border: 1px solid var(--border); min-height: 120px;">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-circle d-inline-block"
                                style="width:10px;height:10px;background:#3b82f6;flex-shrink:0;"></span>
                            <span class="fw-semibold small">Review</span>
                        </div>
                        <span class="badge bg-secondary rounded-pill" style="font-size:.7rem;">1</span>
                    </div>
                    <div class="rounded-3 p-2 task-card"
                        style="background-color:var(--bg-main);border:1px solid var(--border);cursor:pointer;">
                        <div class="small fw-semibold mb-1" style="color:var(--text-main);line-height:1.3;">Review nav
                            structure</div>
                        <div class="d-flex align-items-center gap-1 flex-wrap mt-1">
                            <span class="badge bg-warning text-dark rounded-pill" style="font-size:.65rem;">Medium</span>
                            <span class="badge bg-secondary rounded-pill" style="font-size:.65rem;">UX</span>
                            <span class="text-muted" style="font-size:.7rem;"><i class="bi bi-calendar3 me-1"></i>Mar
                                8</span>
                        </div>
                    </div>
                    <button class="btn btn-sm w-100 mt-1 d-flex align-items-center justify-content-center gap-1"
                        style="background:transparent;border:1px dashed var(--border);color:var(--text-muted);">
                        <i class="bi bi-plus"></i><span style="font-size:.75rem;">Add task</span>
                    </button>
                </div>

                {{-- Pool: Done --}}
                <div class="rounded-3 p-3 d-flex flex-column gap-2"
                    style="width: 240px; background-color: var(--bg-card); border: 1px solid var(--border); min-height: 120px;">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-circle d-inline-block"
                                style="width:10px;height:10px;background:#22c55e;flex-shrink:0;"></span>
                            <span class="fw-semibold small">Done</span>
                        </div>
                        <span class="badge bg-secondary rounded-pill" style="font-size:.7rem;">1</span>
                    </div>
                    <div class="rounded-3 p-2 task-card"
                        style="background-color:var(--bg-main);border:1px solid var(--border);cursor:pointer;">
                        <div class="small fw-semibold mb-1" style="color:var(--text-main);line-height:1.3;">Define project
                            scope</div>
                        <div class="d-flex align-items-center gap-1 flex-wrap mt-1">
                            <span class="badge bg-danger rounded-pill" style="font-size:.65rem;">High</span>
                            <span class="text-muted" style="font-size:.7rem;"><i class="bi bi-calendar3 me-1"></i>Feb
                                20</span>
                        </div>
                    </div>
                    <button class="btn btn-sm w-100 mt-1 d-flex align-items-center justify-content-center gap-1"
                        style="background:transparent;border:1px dashed var(--border);color:var(--text-muted);">
                        <i class="bi bi-plus"></i><span style="font-size:.75rem;">Add task</span>
                    </button>
                </div>

                {{-- Add Pool --}}
                <div class="rounded-3 d-flex align-items-center justify-content-center"
                    style="width:200px;min-height:120px;border:2px dashed var(--border);cursor:pointer;flex-shrink:0;color:var(--text-muted);">
                    <div class="text-center">
                        <i class="bi bi-plus-circle fs-4 d-block mb-1"></i>
                        <span style="font-size:.8rem;">Add pool</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Members Footer --}}
        <div class="px-4 py-2 d-flex align-items-center gap-3 flex-wrap"
            style="background-color:var(--bg-card);border-top:1px solid var(--border);">
            <span class="text-muted" style="font-size:.8rem;"><i class="bi bi-people me-1"></i>Members:</span>
            <span class="d-flex align-items-center gap-1 text-white" style="font-size:.8rem;">
                <span class="badge bg-warning text-dark rounded-pill" style="font-size:.65rem;">Owner</span> You
            </span>
            <span class="d-flex align-items-center gap-1 text-white" style="font-size:.8rem;">
                <span class="badge bg-danger rounded-pill" style="font-size:.65rem;">Admin</span> Sarah K.
            </span>
            <span class="d-flex align-items-center gap-1 text-white" style="font-size:.8rem;">
                <span class="badge bg-primary rounded-pill" style="font-size:.65rem;">Member</span> Lee M.
            </span>
            <button class="btn btn-sm btn-outline-light ms-auto d-flex align-items-center gap-1" style="font-size:.75rem;">
                <i class="bi bi-person-plus"></i> Invite
            </button>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════
    PROJECT 2 — Mobile App MVP
    ═══════════════════════════════════════════ --}}
    <div class="card rounded-4 mb-5 overflow-hidden">
        {{-- Project Header --}}
        <div class="card-header p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3"
            style="background-color: var(--bg-card); border-bottom: 1px solid var(--border); border-left: 4px solid #ec4899;">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-3 d-flex align-items-center justify-content-center fs-4"
                    style="background-color: #ec489922; width: 48px; height: 48px; flex-shrink: 0;">
                    📱
                </div>
                <div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <h5 class="fw-bold m-0 text-white">Mobile App MVP</h5>
                        <span class="badge rounded-pill small bg-warning text-dark">Owner</span>
                    </div>
                    <p class="text-muted small m-0 mt-1">3 pools &middot; 3 tasks</p>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3 flex-wrap">
                <div class="d-flex align-items-center">
                    <img src="https://ui-avatars.com/api/?name=You&background=6366f1&color=fff" alt="You"
                        title="You (Owner)" class="rounded-circle" width="30" height="30"
                        style="border: 2px solid var(--border);">
                    <img src="https://ui-avatars.com/api/?name=Marco+P&background=f59e0b&color=fff" alt="Marco P."
                        title="Marco P. (Member)" class="rounded-circle" width="30" height="30"
                        style="margin-left:-10px; border: 2px solid var(--border);">
                </div>
                <button class="btn btn-outline-light btn-sm d-flex align-items-center gap-1">
                    <i class="bi bi-kanban"></i> Open Board
                </button>
            </div>
        </div>

        {{-- Kanban Board Preview --}}
        <div class="p-3" style="background-color: var(--bg-main); overflow-x: auto;">
            <div class="d-flex gap-3" style="min-width: max-content;">

                {{-- Pool: To Do --}}
                <div class="rounded-3 p-3 d-flex flex-column gap-2"
                    style="width: 240px; background-color: var(--bg-card); border: 1px solid var(--border); min-height: 120px;">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-circle d-inline-block"
                                style="width:10px;height:10px;background:#64748b;flex-shrink:0;"></span>
                            <span class="fw-semibold small">To Do</span>
                        </div>
                        <span class="badge bg-secondary rounded-pill" style="font-size:.7rem;">2</span>
                    </div>
                    <div class="rounded-3 p-2 task-card"
                        style="background-color:var(--bg-main);border:1px solid var(--border);cursor:pointer;">
                        <div class="small fw-semibold mb-1" style="color:var(--text-main);line-height:1.3;">Setup project
                            repo</div>
                        <div class="d-flex align-items-center gap-1 flex-wrap mt-1">
                            <span class="badge bg-danger rounded-pill" style="font-size:.65rem;">High</span>
                            <span class="badge bg-secondary rounded-pill" style="font-size:.65rem;">Dev</span>
                            <span class="text-muted" style="font-size:.7rem;"><i class="bi bi-calendar3 me-1"></i>Mar
                                1</span>
                        </div>
                    </div>
                    <div class="rounded-3 p-2 task-card"
                        style="background-color:var(--bg-main);border:1px solid var(--border);cursor:pointer;">
                        <div class="small fw-semibold mb-1" style="color:var(--text-main);line-height:1.3;">Design
                            onboarding flow</div>
                        <div class="d-flex align-items-center gap-1 flex-wrap mt-1">
                            <span class="badge bg-warning text-dark rounded-pill" style="font-size:.65rem;">Medium</span>
                            <span class="badge bg-secondary rounded-pill" style="font-size:.65rem;">Design</span>
                            <span class="text-muted" style="font-size:.7rem;"><i class="bi bi-calendar3 me-1"></i>Mar
                                12</span>
                        </div>
                    </div>
                    <button class="btn btn-sm w-100 mt-1 d-flex align-items-center justify-content-center gap-1"
                        style="background:transparent;border:1px dashed var(--border);color:var(--text-muted);">
                        <i class="bi bi-plus"></i><span style="font-size:.75rem;">Add task</span>
                    </button>
                </div>

                {{-- Pool: In Progress --}}
                <div class="rounded-3 p-3 d-flex flex-column gap-2"
                    style="width: 240px; background-color: var(--bg-card); border: 1px solid var(--border); min-height: 120px;">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-circle d-inline-block"
                                style="width:10px;height:10px;background:#f59e0b;flex-shrink:0;"></span>
                            <span class="fw-semibold small">In Progress</span>
                        </div>
                        <span class="badge bg-secondary rounded-pill" style="font-size:.7rem;">1</span>
                    </div>
                    <div class="rounded-3 p-2 task-card"
                        style="background-color:var(--bg-main);border:1px solid var(--border);cursor:pointer;">
                        <div class="small fw-semibold mb-1" style="color:var(--text-main);line-height:1.3;">Auth screens
                        </div>
                        <div class="d-flex align-items-center gap-1 flex-wrap mt-1">
                            <span class="badge bg-danger rounded-pill" style="font-size:.65rem;">High</span>
                            <span class="badge bg-secondary rounded-pill" style="font-size:.65rem;">Dev</span>
                            <span class="text-muted" style="font-size:.7rem;"><i class="bi bi-calendar3 me-1"></i>Mar
                                3</span>
                        </div>
                    </div>
                    <button class="btn btn-sm w-100 mt-1 d-flex align-items-center justify-content-center gap-1"
                        style="background:transparent;border:1px dashed var(--border);color:var(--text-muted);">
                        <i class="bi bi-plus"></i><span style="font-size:.75rem;">Add task</span>
                    </button>
                </div>

                {{-- Pool: Done --}}
                <div class="rounded-3 p-3 d-flex flex-column gap-2"
                    style="width: 240px; background-color: var(--bg-card); border: 1px solid var(--border); min-height: 120px;">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-circle d-inline-block"
                                style="width:10px;height:10px;background:#22c55e;flex-shrink:0;"></span>
                            <span class="fw-semibold small">Done</span>
                        </div>
                        <span class="badge bg-secondary rounded-pill" style="font-size:.7rem;">0</span>
                    </div>
                    <div class="text-center py-2">
                        <span class="text-muted" style="font-size:.75rem;">No tasks</span>
                    </div>
                    <button class="btn btn-sm w-100 mt-auto d-flex align-items-center justify-content-center gap-1"
                        style="background:transparent;border:1px dashed var(--border);color:var(--text-muted);">
                        <i class="bi bi-plus"></i><span style="font-size:.75rem;">Add task</span>
                    </button>
                </div>

                {{-- Add Pool --}}
                <div class="rounded-3 d-flex align-items-center justify-content-center"
                    style="width:200px;min-height:120px;border:2px dashed var(--border);cursor:pointer;flex-shrink:0;color:var(--text-muted);">
                    <div class="text-center">
                        <i class="bi bi-plus-circle fs-4 d-block mb-1"></i>
                        <span style="font-size:.8rem;">Add pool</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Members Footer --}}
        <div class="px-4 py-2 d-flex align-items-center gap-3 flex-wrap"
            style="background-color:var(--bg-card);border-top:1px solid var(--border);">
            <span class="text-muted" style="font-size:.8rem;"><i class="bi bi-people me-1"></i>Members:</span>
            <span class="d-flex align-items-center gap-1 text-white" style="font-size:.8rem;">
                <span class="badge bg-warning text-dark rounded-pill" style="font-size:.65rem;">Owner</span> You
            </span>
            <span class="d-flex align-items-center gap-1 text-white" style="font-size:.8rem;">
                <span class="badge bg-primary rounded-pill" style="font-size:.65rem;">Member</span> Marco P.
            </span>
            <button class="btn btn-sm btn-outline-light ms-auto d-flex align-items-center gap-1" style="font-size:.75rem;">
                <i class="bi bi-person-plus"></i> Invite
            </button>
        </div>
    </div>

    <style>
        .task-card {
            transition: all .15s ease;
        }

        .task-card:hover {
            border-color: var(--primary) !important;
            transform: translateY(-1px);
            box-shadow: 0 3px 12px rgba(0, 0, 0, .2);
        }
    </style>
@endsection