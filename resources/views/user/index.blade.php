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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            @php
                                $r = (int) ($user->cf_max_rating ?? 0);
                                $ratingClass = \App\Helpers\RatingHelper::getRatingClass($r);
                                $ratingTitle = \App\Helpers\RatingHelper::getRatingTitle($r);
                            @endphp
                            <tr style="cursor: pointer;" onclick="window.location='{{ url('/users/' . ($user->id ?? $user->user_id) ) }}'">
                                <td>{{ $user->id ?? $user->user_id }}</td>
                                <td>
                                    <b>{{ $user->name }}</b>
                                    @if($user->cf_handle)
                                        <span class="text-muted small">(@{{ $user->cf_handle }})</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $ratingClass }}">
                                        {{ $user->cf_max_rating ?? 0 }}
                                    </span>
                                </td>
                                <td>{{ $ratingTitle }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>