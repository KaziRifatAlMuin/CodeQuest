<x-layout>
    <x-slot:title>User Details - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-user-circle"></i> User Profile
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
                            if ($r >= 2400) {
                                $label = 'Grandmaster';
                                $color = 'danger';
                            } elseif ($r >= 2100) {
                                $label = 'Master';
                                $color = 'warning';
                            } elseif ($r >= 1900) {
                                $label = 'Candidate Master';
                                $color = 'purple';
                            } elseif ($r >= 1600) {
                                $label = 'Expert';
                                $color = 'primary';
                            } elseif ($r >= 1400) {
                                $label = 'Specialist';
                                $color = 'info';
                            } elseif ($r >= 1200) {
                                $label = 'Pupil';
                                $color = 'success';
                            } else {
                                $label = 'Newbie';
                                $color = 'secondary';
                            }
                        @endphp
                        <span class="badge badge-{{ $color }}">{{ $label }}</span>
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