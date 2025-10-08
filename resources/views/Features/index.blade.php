<x-layout>
    <x-slot:title>Users - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-users" style="color: var(--success);"></i> Users Directory
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
                                $ratingClass = \App\Helpers\RatingHelper::getRatingClass($r);
                                $ratingTitle = \App\Helpers\RatingHelper::getRatingTitle($r);
                            @endphp
                            <tr>
                                <td>{{ $user['id'] }}</td>
                                <td><b>{{ $user['name'] }}</b></td>
                                <td>
                                    <span class="badge {{ $ratingClass }}">
                                        {{ $user['rating'] }}
                                    </span>
                                </td>
                                <td>{{ $ratingTitle }}</td>
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