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

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Rating</th>
                            <th>Rank</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($persons as $user)
                            @php
                                $r = (int) ($user['rating'] ?? 0);
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
                                <td>{{ $user['id'] }}</td>
                                <td><strong>{{ $user['name'] }}</strong></td>
                                <td>
                                    <span class="badge badge-{{ $color }}">
                                        {{ $user['rating'] }}
                                    </span>
                                </td>
                                <td>{{ $label }}</td>
                                <td>
                                    <a href="/user/{{ $user['id'] }}" class="btn btn-sm btn-primary">
                                        View Profile
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>