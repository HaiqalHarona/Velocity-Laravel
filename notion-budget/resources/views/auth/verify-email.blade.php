@extends('layouts.auth')

@section('content')
    <div class="container d-flex flex-column justify-content-center align-items-center min-vh-100 py-5">

        <div
            style="max-width: 450px; width: 100%; background: var(--bg-surface); padding: 3rem; border-radius: 16px; border: 1px solid var(--border-color); box-shadow: 0 20px 40px rgba(0,0,0,0.3);">

            <div class="text-center">
                <div class="logo-placeholder mx-auto mb-4" style="width: 60px; height: 60px; font-size: 1.5rem;">
                    <i class="bi bi-envelope-check-fill"></i>
                </div>

                <h2 class="fw-bold mb-3">Check Your Inbox</h2>
                <p class="text-secondary mb-4">
                    We've sent a verification link to the email address you provided. Please confirm it to activate your
                    account.
                </p>
            </div>

            @if (session('message'))
                <div
                    class="alert alert-success bg-success-subtle text-success border-0 rounded-3 mb-4 d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>A new verification link has been sent.</div>
                </div>
            @endif

            <div class="d-grid gap-3">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100 py-3">
                        Resend Verification Email
                    </button>
                </form>
            </div>
        </div>

        <div class="auth-footer mt-4">
            &copy; {{ date('Y') }} {{ config('app.name') }}.
        </div>

    </div>

    <script>
        // auto refresh to check for email verification (VERY SCUFFED :D)
        setInterval(function() {
            window.location.reload();
        }, 2000);
    </script>
@endsection
