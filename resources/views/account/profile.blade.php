<x-layout>
    <x-slot:title>My Profile - CodeQuest</x-slot:title>
    
    <div class="container mt-5 mb-5" style="max-width: 900px;">
        <!-- Success/Error Messages -->
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Profile Header -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header text-white text-center py-5 position-relative" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px 15px 0 0;">
                <!-- Edit Profile Button -->
                <a href="{{ route('account.editProfile') }}" class="btn btn-light btn-sm position-absolute" style="top: 1rem; right: 1rem;">
                    <i class="fas fa-edit"></i> Edit Profile
                </a>

                <!-- Profile Picture -->
                <div class="position-relative d-inline-block mb-3">
                    @if($user->profile_picture)
                        <img src="{{ asset('images/profile/' . $user->profile_picture) }}" 
                             alt="{{ $user->name }}" 
                             class="rounded-circle" 
                             style="width: 120px; height: 120px; object-fit: cover; border: 5px solid white;">
                    @else
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 120px; height: 120px; border: 5px solid white; background: white;">
                            <i class="fas fa-user-circle" style="font-size: 3rem; color: #667eea;"></i>
                        </div>
                    @endif
                </div>

                <h2 class="mb-2 font-weight-bold">{{ $user->name }}</h2>
                <p class="mb-0">
                    <i class="fas fa-trophy"></i> {{ $user->cf_handle }}
                    @if($user->handle_verified_at)
                        <span class="badge badge-success ms-2">
                            <i class="fas fa-check-circle"></i> Verified
                        </span>
                    @else
                        <span class="badge badge-danger ms-2">
                            <i class="fas fa-times-circle"></i> Not Verified
                        </span>
                    @endif
                </p>
            </div>

            <div class="card-body p-4">
                <!-- Verification Alerts -->
                @if(!$user->email_verified_at)
                    <div class="alert alert-warning mb-3">
                        <i class="fas fa-exclamation-triangle"></i> Your email is not verified. 
                        <a href="{{ route('verification.notice') }}" class="alert-link font-weight-bold">Verify now</a>
                    </div>
                @endif

                @if(!$user->handle_verified_at)
                    <div class="alert alert-warning mb-4">
                        <i class="fas fa-exclamation-triangle"></i> Your Codeforces handle is not verified. 
                        <a href="{{ route('account.handleVerification') }}" class="alert-link font-weight-bold">Verify now</a>
                    </div>
                @endif

                <!-- Stats Grid -->
                <div class="row mb-4">
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card bg-light border text-center p-3">
                            <h3 class="text-primary font-weight-bold mb-0">{{ $user->cf_max_rating }}</h3>
                            <small class="text-muted">Max Rating</small>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card bg-light border text-center p-3">
                            <h3 class="text-primary font-weight-bold mb-0">{{ $user->solved_problems_count }}</h3>
                            <small class="text-muted">Problems Solved</small>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card bg-light border text-center p-3">
                            <h3 class="text-primary font-weight-bold mb-0">{{ number_format($user->average_problem_rating, 0) }}</h3>
                            <small class="text-muted">Avg. Problem Rating</small>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card bg-light border text-center p-3">
                            <h3 class="text-primary font-weight-bold mb-0">{{ $user->followers_count }}</h3>
                            <small class="text-muted">Followers</small>
                        </div>
                    </div>
                </div>

                <!-- Profile Information -->
                <div class="row mt-4">
                    <div class="col-md-6 mb-4">
                        <div class="pb-3 border-bottom">
                            <label class="text-muted small font-weight-bold text-uppercase mb-1">
                                <i class="fas fa-envelope"></i> Email
                            </label>
                            <div class="h6 mb-0">
                                {{ $user->email }}
                                @if($user->email_verified_at)
                                    <span class="badge badge-success badge-sm ml-2">
                                        <i class="fas fa-check"></i> Verified
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="pb-3 border-bottom">
                            <label class="text-muted small font-weight-bold text-uppercase mb-1">
                                <i class="fas fa-user-tag"></i> Role
                            </label>
                            <div class="h6 mb-0 text-capitalize">{{ $user->role }}</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="pb-3 border-bottom">
                            <label class="text-muted small font-weight-bold text-uppercase mb-1">
                                <i class="fas fa-globe"></i> Country
                            </label>
                            <div class="h6 mb-0">{{ $user->country ?? 'Not specified' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="pb-3 border-bottom">
                            <label class="text-muted small font-weight-bold text-uppercase mb-1">
                                <i class="fas fa-university"></i> University
                            </label>
                            <div class="h6 mb-0">{{ $user->university ?? 'Not specified' }}</div>
                        </div>
                    </div>
                </div>

                @if($user->bio)
                    <div class="mb-4">
                        <div class="pb-3 border-bottom">
                            <label class="text-muted small font-weight-bold text-uppercase mb-1">
                                <i class="fas fa-info-circle"></i> Bio
                            </label>
                            <div class="h6 mb-0">{{ $user->bio }}</div>
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="pb-3 border-bottom">
                            <label class="text-muted small font-weight-bold text-uppercase mb-1">
                                <i class="fas fa-calendar-alt"></i> Member Since
                            </label>
                            <div class="h6 mb-0">{{ $user->created_at->format('F d, Y') }}</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="pb-3 border-bottom">
                            <label class="text-muted small font-weight-bold text-uppercase mb-1">
                                <i class="fas fa-clock"></i> Last Updated
                            </label>
                            <div class="h6 mb-0">{{ $user->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="text-center mt-5 pt-4 border-top">
                    <form action="{{ route('account.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-lg px-5 shadow-sm">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
