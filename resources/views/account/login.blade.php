<x-layout>
    <x-slot:title>Login - CodeQuest</x-slot:title>
    
    <div class="auth-container">
        <div class="auth-header">
            <div class="auth-icon">
                <i class="fas fa-code"></i>
            </div>
            <h2>Login to CodeQuest</h2>
            <p>Welcome back! Please login to your account.</p>
        </div>

        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        <form method="POST" action="{{ route('account.login') }}">
            @csrf
            
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror"
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus
                       placeholder="Enter your email">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror"
                       id="password" 
                       name="password" 
                       required
                       placeholder="Enter your password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- <div class="form-group form-check d-flex align-items-center gap-2">
                <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label mb-0" for="remember">Remember me</label>
                <small class="text-muted">Keeps you signed in on this device</small>
            </div> --}}

            <button type="submit" class="btn btn-auth">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>

        <div class="divider">
            <span>OR</span>
        </div>

        <div class="text-center">
            <p class="mb-2">
                <a href="{{ route('account.forgotPassword') }}" class="text-primary">
                    <i class="fas fa-key"></i> Forgot Password?
                </a>
            </p>
            <p>
                Don't have an account? 
                <a href="{{ route('account.register') }}" class="text-primary font-weight-bold">
                    Register here
                </a>
            </p>
        </div>
    </div>
</x-layout>
