@php
    $rating = (int) ($user->cf_max_rating ?? 0);
    $themeColor = \App\Helpers\RatingHelper::getRatingColor($rating);
    $themeBg = \App\Helpers\RatingHelper::getRatingBgColor($rating);
    $themeName = \App\Helpers\RatingHelper::getRatingTitle($rating);
@endphp

<x-layout>
    <x-slot:title>Followers of {{ $user->name }} - CodeQuest</x-slot:title>

    <div class="card shadow-sm mb-4" style="border-left: 4px solid {{ $themeColor }};">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="display-6 mb-2" style="color: {{ $themeColor }}; font-weight: 700;">
                        <i class="fas fa-users"></i> Followers of {{ $user->name }}
                    </h1>
                    <p class="text-muted mb-0">
                        Total Followers: <strong>{{ number_format($user->followers_count ?? 0) }}</strong>
                    </p>
                </div>
                <a href="{{ route('user.show', $user->user_id) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Profile
                </a>
            </div>
        </div>
    </div>

    @if($followers->count() > 0)
        <div class="row">
            @foreach($followers as $follower)
                @php
                    $followerRating = (int) ($follower->cf_max_rating ?? 0);
                    $followerColor = \App\Helpers\RatingHelper::getRatingColor($followerRating);
                @endphp
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100 shadow-sm" style="border-left: 3px solid {{ $followerColor }};">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-auto">
                                    @if($follower->profile_picture)
                                        <img src="{{ asset('images/profile/' . $follower->profile_picture) }}" 
                                             alt="{{ $follower->name }}" 
                                             class="rounded-circle" 
                                             style="width: 50px; height: 50px; object-fit: cover; border: 2px solid {{ $followerColor }};">
                                    @else
                                        <div style="width: 50px; height: 50px; border-radius: 50%; background: {{ \App\Helpers\RatingHelper::getRatingBgColor($followerRating) }}; display: flex; align-items: center; justify-content: center; border: 2px solid {{ $followerColor }};">
                                            <i class="fas fa-user" style="font-size: 1.5rem; color: {{ $followerColor }};"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col">
                                    <h6 class="mb-0">
                                        <a href="{{ route('user.show', $follower->user_id) }}" style="color: {{ $followerColor }}; text-decoration: none; font-weight: 700;">
                                            {{ $follower->name }}
                                        </a>
                                    </h6>
                                    <small class="text-muted">{{ ucfirst($follower->role ?? 'user') }}</small>
                                </div>
                            </div>

                            @if($follower->cf_handle)
                                <p class="mb-2">
                                    <small>
                                        <i class="fas fa-chart-line"></i>
                                        <span class="badge" style="background: {{ $followerColor }}; color: white;">
                                            {{ \App\Helpers\RatingHelper::getRatingTitle($followerRating) }} ({{ $followerRating }})
                                        </span>
                                    </small>
                                </p>
                            @endif

                            <p class="mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-check-circle"></i> {{ $follower->solved_problems_count ?? 0 }} problems solved
                                </small>
                            </p>

                            <div class="d-flex gap-2 mt-3">
                                <a href="{{ route('user.show', $follower->user_id) }}" class="btn btn-sm btn-outline-primary flex-grow-1">
                                    <i class="fas fa-eye"></i> View Profile
                                </a>
                                @auth
                                    @if(auth()->user()->user_id !== $follower->user_id)
                                        @php
                                            $isFollowingThis = auth()->user()->isFollowing($follower->user_id);
                                        @endphp
                                        @if($isFollowingThis)
                                            <form action="{{ route('friend.unfollow', $follower->user_id) }}" method="POST" class="flex-grow-1">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-secondary w-100">
                                                    <i class="fas fa-user-check"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('friend.follow', $follower->user_id) }}" method="POST" class="flex-grow-1">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success w-100">
                                                    <i class="fas fa-user-plus"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $followers->links() }}
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-users" style="font-size: 3rem; color: #ccc; margin-bottom: 15px; display: block;"></i>
                <h5 class="text-muted">No followers yet</h5>
                <p class="text-muted mb-0">{{ $user->name }} doesn't have any followers.</p>
            </div>
        </div>
    @endif
</x-layout>
