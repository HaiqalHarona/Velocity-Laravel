@extends('layouts.app')

@section('content')

    <style>
        .github-icon {
            transition: color 0.3s ease, text-shadow 0.3s ease;
        }

        .github-icon.connected {
            color: #6e40c9;
            text-shadow: 0 0 12px rgba(110, 64, 201, 0.7), 0 0 24px rgba(110, 64, 201, 0.4);
        }

        .btn-github-connect {
            transition: background-color 0.25s ease, color 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
        }

        .btn-github-connect:hover {
            background-color: rgba(255, 255, 255, 0.12);
            color: #fff;
            border-color: #fff;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.15);
        }

        .btn-github-disconnect {
            transition: background-color 0.25s ease, color 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
            border-color: #ffffffff;
            color: #ffffffff;
        }

        .btn-github-disconnect:hover {
            background-color: rgba(255, 0, 0, 1);
            color: #fff;
            border-color: #ffffffff;
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.35);
        }
    </style>

    <h2 class="fw-bold mb-4">Profile Settings</h2>

    <div class="row">
        <div class="col-lg-8">
            <div class="card p-4 rounded-4 mb-4">
                <h5 class="fw-bold mb-4 text-white">Personal Information</h5>
                <form action="#">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small">Full Name</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Email Address</label>
                            <div class="position-relative">
                                <input type="email"
                                    class="form-control @if(Auth::user()->google_id) bg-body-secondary pe-5 @endif"
                                    value="{{ Auth::user()->email }}" @if(Auth::user()->google_id) disabled @endif>
                                @if(Auth::user()->google_id)
                                    <span title="Managed by Google — cannot be changed here" data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        style="position:absolute; right:10px; top:50%; transform:translateY(-50%); line-height:1; cursor:default; pointer-events:auto;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 48 48">
                                            <path fill="#EA4335"
                                                d="M24 9.5c3.5 0 6.6 1.2 9 3.2l6.7-6.7C35.8 2.5 30.2 0 24 0 14.6 0 6.6 5.4 2.6 13.3l7.8 6C12.4 13 17.8 9.5 24 9.5z" />
                                            <path fill="#4285F4"
                                                d="M46.5 24.5c0-1.6-.1-3.1-.4-4.5H24v8.5h12.7c-.6 3-2.3 5.5-4.8 7.2l7.5 5.8c4.4-4 6.9-10 6.9-17z" />
                                            <path fill="#FBBC05"
                                                d="M10.4 28.6A14.6 14.6 0 0 1 9.5 24c0-1.6.3-3.2.9-4.6l-7.8-6A23.9 23.9 0 0 0 0 24c0 3.9.9 7.5 2.6 10.7l7.8-6.1z" />
                                            <path fill="#34A853"
                                                d="M24 48c6.2 0 11.4-2 15.2-5.5l-7.5-5.8c-2 1.4-4.6 2.2-7.7 2.2-6.2 0-11.5-4.2-13.4-9.8l-7.8 6C6.6 42.6 14.6 48 24 48z" />
                                        </svg>
                                    </span>
                                @endif
                            </div>
                            @if(Auth::user()->google_id)
                                <div class="form-text" style="font-size:.75rem; color: white !important;">
                                    <i class="bi bi-lock me-1"></i>Email is managed by Google and cannot be changed.
                                </div>
                            @endif
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mt-2">Update</button>
                </form>
            </div>

            <div class="card p-4 rounded-4">
                <h5 class="fw-bold mb-1 text-white">Connected Accounts</h5>
                <p class="text-muted small mb-4 text-white">Connect your Github Account to import your repositories into
                    projects.</p>

                <div class="d-flex align-items-center justify-content-between p-3 rounded-3 mb-3"
                    style="border: 1px solid var(--border);">
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-github fs-2 github-icon {{ Auth::user()->github_id ? 'connected' : '' }}"></i>
                        <div>
                            <h6 class="m-0 fw-bold text-white">GitHub</h6>
                            @if (Auth::user()->github_id)
                                <small class="text-white" style="opacity:.75;">Connected</small>
                            @else
                                <small class="text-white" style="opacity:.5;">Not connected</small>
                            @endif
                        </div>
                    </div>
                    @if (Auth::user()->github_id)
                        <a href="{{ route('social.redirect', 'github') }}"
                            class="btn btn-outline-light d-flex align-items-center gap-2 btn-github-disconnect">
                            Disconnect
                        </a>
                    @else
                        <a href="{{ route('social.redirect', 'github') }}"
                            class="btn btn-outline-light d-flex align-items-center gap-2 btn-github-connect">
                            Connect
                        </a>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection