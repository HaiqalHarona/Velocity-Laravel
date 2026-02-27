<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/applayout.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    @livewireStyles


</head>

<body>

    {{-- ── Mobile Bottom Nav (hidden on md+) ── --}}
    <nav class="mobile-bottom-nav d-md-none">
        <a href="{{ route('dashboard') }}"
            class="mobile-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('projects') }}" class="mobile-nav-item {{ request()->routeIs('projects') ? 'active' : '' }}">
            <i class="bi bi-briefcase"></i>
            <span>Projects</span>
        </a>
        <a href="{{ route('profile') }}" class="mobile-nav-item {{ request()->routeIs('profile') ? 'active' : '' }}">
            <i class="bi bi-person"></i>
            <span>Profile</span>
        </a>
    </nav>

    {{-- ── Floating Action Button (mobile only) ── --}}
    <a href="#" class="fab d-md-none" data-bs-toggle="modal" data-bs-target="#createProjectModal"
        aria-label="New Project">
        <i class="bi bi-plus-lg"></i>
    </a>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse offcanvas-md offcanvas-start" id="sidebarMenu">
                <div class="offcanvas-header border-bottom border-secondary">
                    <h5 class="offcanvas-title" style="color: var(--primary);">{{ config('app.name') }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
                </div>

                <div class="offcanvas-body d-flex flex-column p-3 pt-4 h-100">
                    <a href="{{ route('dashboard') }}"
                        class="d-none d-md-block text-decoration-none fs-4 mb-4 fw-bold p-2"
                        style="color: var(--primary);">
                        {{ config('app.name') }}
                    </a>

                    <ul class="nav nav-pills flex-column mb-auto gap-1">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }} rounded-3">
                                <i class="bi bi-grid-1x2 me-2"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('projects') }}"
                                class="nav-link {{ request()->routeIs('projects') ? 'active' : '' }} rounded-3">
                                <i class="bi bi-briefcase me-2"></i> Projects
                            </a>
                        </li>
                        <li class="mt-2">
                            <a href="#" class="nav-link rounded-3 text-success d-flex align-items-center"
                                data-bs-toggle="modal" data-bs-target="#createProjectModal">
                                <i class="bi bi-plus-circle me-2"></i> New Project
                            </a>
                        </li>
                    </ul>

                    <hr class="border-secondary">

                    <div class="dropdown">
                        <a href="#" class="user-dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ empty(Auth::user()->avatar) ? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name ?? 'User') . '&background=6366f1&color=fff' : (str_starts_with(Auth::user()->avatar, 'http') ? Auth::user()->avatar : Storage::url(Auth::user()->avatar)) }}"
                                alt="{{ Auth::user()->name ?? 'User' }}" class="user-avatar-ring">
                            <span class="user-name-text">{{ Auth::user()->name ?? 'User Name' }}</span>
                            <i class="bi bi-chevron-up user-caret"></i>
                        </a>
                        <ul class="dropdown-menu user-dropdown-menu">
                            <li class="user-info-header">
                                <div class="fw-semibold" style="font-size:.875rem; color: white">
                                    {{ Auth::user()->name ?? 'User Name' }}
                                </div>
                                <div class="user-email" style="color: white">{{ Auth::user()->email ?? '' }}</div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="bi bi-person-circle"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-gear"></i> Settings
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger w-100 border-0 bg-transparent text-start"
                                        type="submit">
                                        <i class="bi bi-box-arrow-right"></i> Sign out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5 py-4 main-content">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Create Project Modal -->
    <div class="modal fade" id="createProjectModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Project</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('project.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        {{-- Project Name --}}
                        <div class="mb-3">
                            <label class="form-label small">Project Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Marketing Team"
                                required>
                            @error('name')
                                <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Icon (optional) --}}
                        <div class="mb-3">
                            <label class="form-label small d-flex align-items-center gap-2">
                                Icon
                                <span class="badge rounded-pill text-muted fw-normal"
                                    style="background:rgba(255,255,255,.08);font-size:.7rem;padding:2px 8px;">optional</span>
                            </label>
                            <div class="input-group">
                                <input type="text" name="icon" id="iconInput" class="form-control"
                                    placeholder="Paste an emoji, e.g. 🚀" maxlength="5"
                                    oninput="document.getElementById('iconPreview').textContent = this.value.trim() || '📁'">
                            </div>
                            <div class="form-text text-muted" style="font-size:.75rem;">Pick any emoji to represent this
                                project.</div>
                        </div>

                        {{-- Description (optional) --}}
                        <div class="mb-1">
                            <label class="form-label small d-flex align-items-center gap-2">
                                Description
                                <span class="badge rounded-pill text-muted fw-normal"
                                    style="background:rgba(255,255,255,.08);font-size:.7rem;padding:2px 8px;">optional</span>
                            </label>
                            <textarea name="description" class="form-control" rows="3"
                                placeholder="What is this project for?" style="resize:none;"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>

</html>