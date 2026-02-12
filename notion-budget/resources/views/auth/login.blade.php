@extends('layouts.auth')

@section('content')
    <h2 class="text-center mb-4">Login</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Capture the manual login error from Controller --}}
    @error('LoginError')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-dark w-100">Login</button>
    </form>

    <div class="mt-3 pt-3 border-top text-center">
        <p>Or login with:</p>
        <div style="margin-top: 20px; border-top: 1px solid #ddd; padding-top: 10px;">
            <p style="text-align: center;">Or login with:</p>
            <a href="{{ route('social.redirect', 'google') }}" class="social-btn google">Login with Google</a>
            <a href="{{ route('social.redirect', 'github') }}" class="social-btn github">Login with GitHub</a>
        </div>
    </div>

    <p class="text-center mt-3">
        No account? <a href="{{ route('register') }}" class="text-decoration-none">Register here</a>
    </p>
@endsection
