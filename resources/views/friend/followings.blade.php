@php
    $rating = (int) ($user->cf_max_rating ?? 0);
    $themeColor = \App\Helpers\RatingHelper::getRatingColor($rating);
    $themeBg = \App\Helpers\RatingHelper::getRatingBgColor($rating);
    $themeName = \App\Helpers\RatingHelper::getRatingTitle($rating);
@endphp

<x-layout>
    <x-slot:title>Following of {{ $user->name }} - CodeQuest</x-slot:title>

    <div class="card shadow-sm mb-4" style="border-left: 4px solid {{ $themeColor }};">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="display-6 mb-2" style="color: {{ $themeColor }}; font-weight: 700;">
                        <i class="fas fa-user-friends"></i> Following of {{ $user->name }}
                    </h1>
                    <p class="text-muted mb-0">
                        Total Following: <strong>{{ number_format($following->count()) }}</strong>
                    </p>
                </div>
                <a href="{{ route('user.show', $user->user_id) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Profile
                </a>
            </div>
        </div>
    </div>

    @if($following->count() > 0)
        <div class="row">
            @foreach($following as $followedUser)
                @php
                    $followedRating = (int) ($followedUser->cf_max_rating ?? 0);
                    $followedColor = \App\Helpers\RatingHelper::getRatingColor($followedRating);
                @endphp
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100 shadow-sm" style="border-left: 3px solid {{ $followedColor }};">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-auto">
                                    @if($followedUser->profile_picture)
                                        <img src="{{ asset('images/profile/' . $followedUser->profile_picture) }}" 
                                             alt="{{ $followedUser->name }}" 
                                             class="rounded-circle" 
                                             style="width: 50px; height: 50px; object-fit: cover; border: 2px solid {{ $followedColor }};">
                                    @else
                                        <div style="width: 50px; height: 50px; border-radius: 50%; background: {{ \App\Helpers\RatingHelper::getRatingBgColor($followedRating) }}; display: flex; align-items: center; justify-content: center; border: 2px solid {{ $followedColor }};">
                                            <i class="fas fa-user" style="font-size: 1.5rem; color: {{ $followedColor }};"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col">
                                    <h6 class="mb-0">
                                        <a href="{{ route('user.show', $followedUser->user_id) }}" style="color: {{ $followedColor }}; text-decoration: none; font-weight: 700;">
                                            {{ $followedUser->name }}
                                        </a>
                                    </h6>
                                    <small class="text-muted">{{ ucfirst($followedUser->role ?? 'user') }}</small>
                                </div>
                            </div>

                            @if($followedUser->cf_handle)
                                <p class="mb-2">
                                    <small>
                                        <i class="fas fa-chart-line"></i>
                                        <span class="badge" style="background: {{ $followedColor }}; color: white;">
                                            {{ \App\Helpers\RatingHelper::getRatingTitle($followedRating) }} ({{ $followedRating }})
                                        </span>
                                    </small>
                                </p>
                            @endif

                            <p class="mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-check-circle"></i> {{ $followedUser->solved_problems_count ?? 0 }} problems solved
                                </small>
                            </p>

                            <div class="d-flex gap-2 mt-3">
                                <a href="{{ route('user.show', $followedUser->user_id) }}" class="btn btn-sm btn-outline-primary flex-grow-1">
                                    <i class="fas fa-eye"></i> View Profile
                                </a>
                                @auth
                                    @if(auth()->user()->user_id !== $followedUser->user_id)
                                        @php
                                            $isFollowingThis = auth()->user()->isFollowing($followedUser->user_id);
                                        @endphp
                                        @if($isFollowingThis)
                                            <form action="{{ route('friend.unfollow', $followedUser->user_id) }}" method="POST" class="flex-grow-1">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-secondary w-100">
                                                    <i class="fas fa-user-check"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('friend.follow', $followedUser->user_id) }}" method="POST" class="flex-grow-1">
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
            {{ $following->links() }}
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-user-friends" style="font-size: 3rem; color: #ccc; margin-bottom: 15px; display: block;"></i>
                <h5 class="text-muted">Not following anyone</h5>
                <p class="text-muted mb-0">{{ $user->name }} is not following anyone yet.</p>
            </div>
        </div>
    @endif
</x-layout>
