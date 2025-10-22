<x-layout>
    <x-slot:title>Register - CodeQuest</x-slot:title>
    
    <div class="auth-container">
        <div class="auth-header">
            <div class="auth-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <h2>Create Account</h2>
            <p>Start your coding journey with CodeQuest!</p>
        </div>

        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        <div class="info-box">
            <i class="fas fa-info-circle"></i>
            <small>You'll need a valid Codeforces handle to register. We'll verify it during the registration process.</small>
        </div>

        <form method="POST" action="{{ route('account.register') }}">
            @csrf

            <div class="form-group">
                <label for="name"><i class="fas fa-user"></i> Full Name</label>
                <input type="text"
                       class="form-control @error('name') is-invalid @enderror"
                       id="name" 
                       name="name"
                       value="{{ old('name') }}" 
                       required 
                       autofocus
                       placeholder="Enter your full name">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                <input type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       id="email" 
                       name="email"
                       value="{{ old('email') }}" 
                       required
                       placeholder="Enter your email">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="cf_handle"><i class="fas fa-trophy"></i> Codeforces Handle</label>
                <input type="text"
                       class="form-control @error('cf_handle') is-invalid @enderror"
                       id="cf_handle" 
                       name="cf_handle"
                       value="{{ old('cf_handle') }}" 
                       required
                       placeholder="Enter your Codeforces handle">
                @error('cf_handle')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">
                    Your Codeforces handle will be verified before you can access the platform.
                </small>
            </div>

            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                <input type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       id="password" 
                       name="password" 
                       required
                       placeholder="Enter a strong password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Minimum 8 characters.</small>
            </div>

            <div class="form-group">
                <label for="password_confirmation"><i class="fas fa-lock"></i> Confirm Password</label>
                <input type="password"
                       class="form-control"
                       id="password_confirmation" 
                       name="password_confirmation" 
                       required
                       placeholder="Re-enter your password">
            </div>

            <button type="submit" class="btn btn-auth">
                <i class="fas fa-user-plus"></i> Register
            </button>
        </form>

        <div class="text-center mt-4">
            <p>
                Already have an account? 
                <a href="{{ route('account.login') }}" class="text-primary font-weight-bold">
                    Login here
                </a>
            </p>
        </div>
    </div>
</x-layout>
