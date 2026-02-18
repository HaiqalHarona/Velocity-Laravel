@extends('layouts.auth')

@section('content')
    <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 24px; background-color: var(--bg-card);">
        <div class="row g-0">

            <div class="col-12 col-lg-5 p-5 d-flex flex-column justify-content-center">

                <div class="auth-toggle">
                    <a href="{{ route('login') }}">Log In</a>
                    <a href="{{ route('register') }}" class="active">Sign Up</a>
                </div>

                <h2 class="fw-bold mb-1">Create Account</h2>

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small ">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="John Doe"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small ">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="name@company.com"
                            value="{{ old('email') }}" required>
                        @error('email')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small ">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Create password" required>
                        @error('password')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label small ">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Repeat password" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-3">Create Account</button>
                </form>

                <div class="d-flex align-items-center my-4">
                    <hr class="flex-grow-1 border-secondary opacity-25">
                    <span class="mx-3  small">OR</span>
                    <hr class="flex-grow-1 border-secondary opacity-25">
                </div>

                <a href="{{ route('social.redirect', 'google') }}"
                    class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center gap-2"
                    style="border-color: var(--border); color: var(--text-main);">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="20" alt="Google">
                    Continue with Google
                </a>
            </div>

            <div class="col-lg-7 d-none d-lg-block position-relative" style="min-height: 600px; background: #000;">
                <div class="slideshow">
                    <div class="slide"></div>
                    <div class="slide"></div>
                    <div class="slide"></div>
                </div>
                <div class="position-absolute bottom-0 start-0 p-5 text-white"
                    style="z-index: 10; background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);">
                    <h3 class="fw-bold">Join the community.</h3>
                    <p class="opacity-75">Thousands of developers use TaskCollab to ship faster.</p>
                </div>
            </div>

        </div>
    </div>
@endsection
