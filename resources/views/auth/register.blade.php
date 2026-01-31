<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label fw-bold">{{ __('Full Name') }}</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-person"></i></span>
                <input id="name" class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="{{ __('John Doe') }}">
            </div>
            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="row">
            <!-- Phone -->
            <div class="col-md-6 mb-3">
                <label for="phone" class="form-label fw-bold">{{ __('Phone Number') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-telephone"></i></span>
                    <input id="phone" class="form-control border-start-0 ps-0 @error('phone') is-invalid @enderror" type="text" name="phone" value="{{ old('phone') }}" required placeholder="{{ __('090...') }}">
                </div>
                @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <!-- Role -->
             <div class="col-md-6 mb-3">
                <label for="role" class="form-label fw-bold">{{ __('You are?') }}</label>
                <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="">{{ __('-- Select --') }}</option>
                    <option value="patient" {{ old('role') == 'patient' ? 'selected' : '' }}>{{ __('Patient') }}</option>
                    <option value="doctor" {{ old('role') == 'doctor' ? 'selected' : '' }}>{{ __('Doctor') }}</option>
                </select>
                @error('role') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- City & Address -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="city_id" class="form-label fw-bold">{{ __('City') }}</label>
                <select id="city_id" name="city_id" class="form-select @error('city_id') is-invalid @enderror">
                    <option value="">{{ __('-- Select --') }}</option>
                    @foreach(\App\Models\City::orderBy('name')->get() as $city)
                        <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
             <div class="col-md-6 mb-3">
                <label for="address" class="form-label fw-bold">{{ __('Address') }}</label>
                <input id="address" class="form-control @error('address') is-invalid @enderror" type="text" name="address" value="{{ old('address') }}" required placeholder="{{ __('House number, street...') }}">
            </div>
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-bold">{{ __('Email') }}</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                <input id="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="name@example.com">
            </div>
            @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <!-- Password -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="password" class="form-label fw-bold">{{ __('Password') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                    <input id="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="new-password">
                </div>
                @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="password_confirmation" class="form-label fw-bold">{{ __('Confirm Password') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-lock-fill"></i></span>
                    <input id="password_confirmation" class="form-control border-start-0 ps-0" type="password" name="password_confirmation" required autocomplete="new-password">
                </div>
                @error('password_confirmation') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="d-grid gap-2 mt-4">
            <button type="submit" class="btn btn-primary btn-lg">
                {{ __('Register Account') }} <i class="bi bi-person-plus-fill"></i>
            </button>
        </div>

        <div class="text-center mt-4">
            <p class="text-muted mb-0">
                {{ __('Already have an account?') }} 
                <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">{{ __('Login Now') }}</a>
            </p>
        </div>
    </form>
</x-guest-layout>
