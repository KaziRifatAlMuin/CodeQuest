<x-layout>
    <x-slot:title>User Details - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-user-circle" style="color: var(--info);"></i> User Profile
            </h1>
            <p class="lead">Details for user ID: {{ $user['id'] }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Basic Information</h5>
                    
                    <div class="mb-3">
                        <small class="text-muted">User ID</small>
                        <h4>{{ $user['id'] }}</h4>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Name</small>
                        <h4>{{ $user['name'] }}</h4>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Rating</small>
                        <h3>{{ $user['rating'] }}</h3>
                        @php
                            $r = (int) ($user['rating'] ?? 0);
                            $ratingClass = \App\Helpers\RatingHelper::getRatingClass($r);
                            $ratingTitle = \App\Helpers\RatingHelper::getRatingTitle($r);
                        @endphp
                        <span class="badge {{ $ratingClass }}">{{ $ratingTitle }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <a href="/users" class="btn btn-primary btn-block">
                        Back to Users
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layout>