<x-layout>
    <x-slot:title>Reset Password - CodeQuest</x-slot:title>
    
    <div class="auth-container">
        <div class="auth-header">
            <div class="auth-icon">
                <i class="fas fa-lock-open"></i>
            </div>
            <h2>Reset Your Password</h2>
            <p>Enter your new password below</p>
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

        @if($errors->any() && !$errors->has('email') && !$errors->has('password'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i>
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror"
                       id="email" 
                       name="email" 
                       value="{{ $email ?? old('email') }}" 
                       required 
                       autofocus
                       readonly>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> New Password</label>
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror"
                       id="password" 
                       name="password" 
                       required
                       placeholder="Enter new password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Minimum 8 characters.</small>
            </div>

            <div class="form-group">
                <label for="password_confirmation"><i class="fas fa-lock"></i> Confirm New Password</label>
                <input type="password" 
                       class="form-control"
                       id="password_confirmation" 
                       name="password_confirmation" 
                       required
                       placeholder="Re-enter new password">
            </div>

            <button type="submit" class="btn btn-auth">
                <i class="fas fa-check-circle"></i> Reset Password
            </button>
        </form>

        <div class="text-center mt-4">
            <p>
                <a href="{{ route('account.login') }}" class="text-primary">
                    <i class="fas fa-arrow-left"></i> Back to Login
                </a>
            </p>
        </div>
    </div>
</x-layout>
