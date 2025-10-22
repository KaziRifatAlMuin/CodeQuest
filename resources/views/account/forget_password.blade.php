<x-layout>
    <x-slot:title>Forgot Password - CodeQuest</x-slot:title>
    
    <div class="auth-container">
        <div class="auth-header">
            <div class="auth-icon">
                <i class="fas fa-key"></i>
            </div>
            <h2>Forgot Password?</h2>
            <p>Enter your email to reset your password</p>
        </div>

        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                
                @if(session()->has('resetUrl'))
                    <hr class="my-3">
                    <p class="mb-2"><strong><i class="fas fa-link"></i> Development Mode - Quick Reset:</strong></p>
                    <p class="mb-2 small">Click the button below to reset your password:</p>
                    <a href="{{ session('resetUrl') }}" class="btn btn-sm btn-primary btn-block">
                        <i class="fas fa-key"></i> Click Here to Reset Password
                    </a>
                    <p class="mt-2 mb-0 small">
                        Or copy this link: <br>
                        <input type="text" class="form-control form-control-sm mt-1" value="{{ session('resetUrl') }}" readonly onclick="this.select()">
                    </p>
                @endif
            </div>
        @endif

        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        <div class="info-box">
            <p class="mb-0">
                <i class="fas fa-info-circle"></i>
                <strong>How it works:</strong> Enter your registered email address and we'll send you a link to reset your password.
                @if(config('app.env') === 'local')
                    <br><small class="text-success"><i class="fas fa-code"></i> Development mode: Reset link will be displayed on this page.</small>
                @endif
            </p>
        </div>

        <form method="POST" action="{{ route('password.email') }}">
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
                       placeholder="Enter your registered email">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-auth">
                <i class="fas fa-paper-plane"></i> Send Reset Link
            </button>
        </form>

        <div class="text-center mt-4">
            <p>
                Remember your password? 
                <a href="{{ route('account.login') }}" class="text-primary font-weight-bold">
                    Login here
                </a>
            </p>
            <p class="mt-2">
                Don't have an account? 
                <a href="{{ route('account.register') }}" class="text-primary">
                    Register
                </a>
            </p>
        </div>
    </div>
</x-layout>
