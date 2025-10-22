<x-layout>
    <x-slot:title>Verify Codeforces Handle - CodeQuest</x-slot:title>
    
    <div class="auth-container">
        <div class="auth-header">
            <div class="auth-icon">
                <i class="fas fa-trophy"></i>
            </div>
            <h2>Verify Your Codeforces Handle</h2>
            <p>We need to verify that you own this Codeforces account</p>
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

        @if(session()->has('warning'))
            <div class="alert alert-warning alert-dismissible fade show">
                <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        <div class="bg-light p-3 rounded text-center mb-4 border">
            <label class="text-muted small mb-1 d-block">Your Codeforces Handle:</label>
            <div class="h4 text-primary font-weight-bold mb-0">
                <i class="fas fa-user-circle"></i> {{ Auth::user()->cf_handle }}
            </div>
        </div>

        <div class="info-box">
            <h5 class="mb-3"><i class="fas fa-info-circle"></i> Verification Process:</h5>
            <ol class="mb-0 pl-4">
                <li class="mb-2">We will check if your Codeforces handle exists on Codeforces.com</li>
                <li class="mb-2">If valid, we'll retrieve your rating and contest history</li>
                <li class="mb-2">After verification, you'll proceed to email verification</li>
            </ol>
        </div>

        <form method="POST" action="{{ route('account.verifyHandle') }}">
            @csrf
            <button type="submit" class="btn btn-auth">
                <i class="fas fa-check-circle"></i> Verify My Handle
            </button>
        </form>

        <div class="text-center mt-4">
            <p class="text-muted">
                <small>Wrong handle? Please contact support to update your handle.</small>
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
