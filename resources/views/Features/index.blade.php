<x-layout>
    <x-slot:title>Users - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-users text-success"></i> Users Directory
            </h1>
            <p class="lead">Browse all registered users and their ratings</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Rating</th>
                            <th scope="col">Rank</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($persons as $user)
                            @php
                                $r = (int) ($user['rating'] ?? 0);

                                // Codeforces-like color mapping
                                if ($r >= 2400) {
                                    $color = 'danger';
                                    $label = 'Grandmaster';
                                } elseif ($r >= 2100) {
                                    $color = 'warning';
                                    $label = 'Master';
                                } elseif ($r >= 1900) {
                                    $color = 'purple';
                                    $label = 'Candidate Master';
                                } elseif ($r >= 1600) {
                                    $color = 'primary';
                                    $label = 'Expert';
                                } elseif ($r >= 1400) {
                                    $color = 'info';
                                    $label = 'Specialist';
                                } elseif ($r >= 1200) {
                                    $color = 'success';
                                    $label = 'Pupil';
                                } else {
                                    $color = 'secondary';
                                    $label = 'Newbie';
                                }
                            @endphp
                            <tr>
                                <th scope="row">{{ $user['id'] }}</th>
                                <td>
                                    <strong>{{ $user['name'] }}</strong>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $color }}">
                                        {{ $user['rating'] }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $label }}</small>
                                </td>
                                <td>
                                    <a href="/user/{{ $user['id'] }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-user"></i> View Profile
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <div class="alert alert-info" role="alert">
            <i class="fas fa-info-circle"></i> Total Users: <strong>{{ count($persons) }}</strong>
        </div>
    </div>
</x-layout>