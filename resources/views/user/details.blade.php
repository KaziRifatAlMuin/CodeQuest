<x-layout>
    <x-slot:title>User Details - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-user-circle" style="color: var(--info);"></i> User Profile
            </h1>
            <p class="lead">Details for {{ $user->name }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Basic Information</h5>
                    
                    <div class="mb-3">
                        <small class="text-muted">User ID</small>
                        <h4>{{ $user->user_id }}</h4>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Name</small>
                        <h4>{{ $user->name }}</h4>
                    </div>

                    @if($user->cf_handle)
                    <div class="mb-3">
                        <small class="text-muted">Codeforces Handle</small>
                        <h5>{{ $user->cf_handle }}</h5>
                    </div>
                    @endif

                    <div class="mb-3">
                        <small class="text-muted">Max Rating</small>
                        <h3>{{ $user->cf_max_rating ?? 0 }}</h3>
                        @php
                            $r = (int) ($user->cf_max_rating ?? 0);
                            $ratingClass = \App\Helpers\RatingHelper::getRatingClass($r);
                            $ratingTitle = \App\Helpers\RatingHelper::getRatingTitle($r);
                        @endphp
                        <span class="badge {{ $ratingClass }}">{{ $ratingTitle }}</span>
                    </div>

                    @if($user->country)
                    <div class="mb-3">
                        <small class="text-muted">Country</small>
                        <p>{{ $user->country }}</p>
                    </div>
                    @endif

                    @if($user->university)
                    <div class="mb-3">
                        <small class="text-muted">University</small>
                        <p>{{ $user->university }}</p>
                    </div>
                    @endif

                    @if($user->bio)
                    <div class="mb-3">
                        <small class="text-muted">Bio</small>
                        <p>{{ $user->bio }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Statistics</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="text-muted">Problems Solved</small>
                                <h4>{{ $user->solved_problems_count ?? 0 }}</h4>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="text-muted">Average Problem Rating</small>
                                <h4>{{ $user->average_problem_rating ?? 0 }}</h4>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="text-muted">Followers</small>
                                <h4>{{ number_format($user->followers_count ?? 0) }}</h4>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="text-muted">Role</small>
                                <h4><span class="badge badge-info">{{ ucfirst($user->role ?? 'user') }}</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <a href="{{ route('users.index') }}" class="btn btn-primary btn-block">
                        <i class="fas fa-arrow-left"></i> Back to Users
                    </a>
                    <a href="{{ route('leaderboard') }}" class="btn btn-outline-warning btn-block mt-2">
                        <i class="fas fa-trophy"></i> View Leaderboard
                    </a>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-secondary btn-block mt-2">
                        <i class="fas fa-edit"></i> Edit User
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layout>