<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4 alert alert-success" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="form-label fw-bold">{{ __('Email') }}</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                <input id="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="name@example.com">
            </div>
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="form-label fw-bold">{{ __('Password') }}</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                <input id="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password" placeholder="********">
            </div>
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label for="remember_me" class="form-check-label text-secondary small">{{ __('Remember me') }}</label>
            </div>
            @if (Route::has('password.request'))
                <a class="text-sm text-primary text-decoration-none fw-bold small" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-lg">
                {{ __('Login') }} <i class="bi bi-arrow-right-short"></i>
            </button>
        </div>

        <div class="text-center mt-4">
            <p class="text-muted mb-0">
                {{ __('Don\'t have an account?') }} 
                <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">{{ __('Register Now') }}</a>
            </p>
        </div>
    </form>
</x-guest-layout>
