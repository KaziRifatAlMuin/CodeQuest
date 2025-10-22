<x-layout>
    <x-slot:title>Verify Email - CodeQuest</x-slot:title>
    
    <div class="auth-container">
        <div class="auth-header">
            <div class="auth-icon">
                <i class="fas fa-envelope-open"></i>
            </div>
            <h2>Verify Your Email</h2>
            <p>Please check your inbox for verification link</p>
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

        <div class="bg-light p-3 rounded text-center mb-4 border">
            <label class="text-muted small mb-1 d-block">We sent a verification link to:</label>
            <div class="h5 text-primary font-weight-semibold mb-0">
                <i class="fas fa-envelope"></i> {{ Auth::user()->email }}
            </div>
        </div>

        <div class="info-box">
            <p class="mb-2"><strong><i class="fas fa-info-circle"></i> Next Steps:</strong></p>
            <ol class="mb-0 pl-4">
                <li class="mb-2">Check your email inbox (and spam folder)</li>
                <li class="mb-2">Click the verification link in the email</li>
                <li class="mb-2">You'll be redirected to the platform after verification</li>
            </ol>
            
            @if(isset($verificationUrl))
            <hr class="my-3">
            
            <p class="mb-2 text-success"><strong><i class="fas fa-exclamation-triangle"></i> Development Mode - Quick Verify:</strong></p>
            <p class="mb-2 small">
                Since this is running in local development mode, you can click the button below to verify your email directly:
            </p>
            <a href="{{ $verificationUrl }}" class="btn btn-sm btn-success btn-block">
                <i class="fas fa-check-circle"></i> Click Here to Verify Email
            </a>
            <p class="mt-2 mb-0 small text-muted">
                Or copy this link: <br>
                <input type="text" class="form-control form-control-sm mt-1" value="{{ $verificationUrl }}" readonly onclick="this.select()">
            </p>
            @endif
        </div>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-auth">
                <i class="fas fa-paper-plane"></i> Resend Verification Email
            </button>
        </form>

        <div class="text-center mt-4">
            <p class="text-muted">
                <small>Didn't receive the email? Check your spam folder or click resend.</small>
            </p>
            <p class="mt-3">
                <form action="{{ route('account.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link text-danger p-0" style="text-decoration: none;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </p>
        </div>
    </div>
</x-layout>
