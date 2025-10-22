@php
    $rating = (int) ($user->cf_max_rating ?? 0);
    $themeColor = \App\Helpers\RatingHelper::getRatingColor($rating);
    $themeBg = \App\Helpers\RatingHelper::getRatingBgColor($rating);
    $themeName = \App\Helpers\RatingHelper::getRatingTitle($rating);
@endphp

<x-layout>
    <x-slot:title>{{ $user->name }} - CodeQuest</x-slot:title>

    <!-- Profile Header with Coder Icon -->
    <div class="card shadow-sm mb-4" style="border-left: 4px solid {{ $themeColor }};">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    @if($user->profile_picture)
                        <img src="{{ asset('images/profile/' . $user->profile_picture) }}" 
                             alt="{{ $user->name }}" 
                             class="rounded-circle" 
                             style="width: 120px; height: 120px; object-fit: cover; border: 3px solid {{ $themeColor }}; margin: 0 auto;">
                    @else
                        <div style="width: 120px; height: 120px; border-radius: 50%; background: {{ $themeBg }}; display: flex; align-items: center; justify-content: center; margin: 0 auto; border: 3px solid {{ $themeColor }};">
                            <i class="fas fa-user-circle" style="font-size: 3rem; color: {{ $themeColor }};"></i>
                        </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <h1 class="display-5 mb-2" style="color: {{ $themeColor }}; font-weight: 700;">
                        {{ $user->name }}
                    </h1>
                    <p class="lead mb-2">
                        @if($user->cf_handle)
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" style="vertical-align: middle; margin-right: 8px; display: inline-block;">
                                <path fill="{{ $themeColor }}" d="M4.5 7.5C5.328 7.5 6 8.172 6 9v10.5c0 .828-.672 1.5-1.5 1.5h-3C.672 21 0 20.328 0 19.5V9c0-.828.672-1.5 1.5-1.5h3zm9-4.5c.828 0 1.5.672 1.5 1.5v15c0 .828-.672 1.5-1.5 1.5h-3c-.828 0-1.5-.672-1.5-1.5v-15c0-.828.672-1.5 1.5-1.5h3zm9 7.5c.828 0 1.5.672 1.5 1.5v7.5c0 .828-.672 1.5-1.5 1.5h-3c-.828 0-1.5-.672-1.5-1.5V12c0-.828.672-1.5 1.5-1.5h3z"/>
                            </svg>
                            <a href="https://codeforces.com/profile/{{ $user->cf_handle }}" target="_blank" style="color: {{ $themeColor }}; text-decoration: none; font-weight: 600;">
                                {{ $user->cf_handle }}
                            </a>
                        @else
                            <i class="fas fa-code" style="color: {{ $themeColor }};"></i> 
                            <strong>N/A</strong>
                        @endif
                    </p>
                    <span class="badge" style="background: {{ $themeColor }}; font-size: 1rem; padding: 8px 16px;">
                        {{ $themeName }} ({{ $rating }})
                    </span>
                    <span class="badge bg-secondary" style="font-size: 1rem; padding: 8px 16px; margin-left: 8px;">
                        <i class="fas fa-user-tag"></i> {{ ucfirst($user->role ?? 'user') }}
                    </span>
                </div>
                <div class="col-md-2 text-end">
                    @auth
                        @if(in_array(auth()->user()->role, ['moderator', 'admin']))
                            <a href="{{ route('user.edit', $user->user_id) }}" class="btn btn-primary mb-2" style="width: 100%;">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        @endif
                        
                        @if(auth()->user()->role === 'admin' && auth()->user()->user_id !== $user->user_id)
                            <form action="{{ route('user.destroy', $user->user_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="width: 100%;">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-lg-12">
            <!-- Statistics Dashboard -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card h-100 shadow-sm" style="border-top: 4px solid #212529;">
                        <div class="card-body text-center">
                            <i class="fas fa-check-circle" style="font-size: 2.5rem; color: #212529; margin-bottom: 10px;"></i>
                            <h2 class="mb-0" style="color: #212529; font-weight: 700;">{{ $user->solved_problems_count ?? 0 }}</h2>
                            <small class="text-muted">Problems Solved</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card h-100 shadow-sm" style="border-top: 4px solid #212529;">
                        <div class="card-body text-center">
                            <i class="fas fa-star" style="font-size: 2.5rem; color: #212529; margin-bottom: 10px;"></i>
                            <h2 class="mb-0" style="color: #212529; font-weight: 700;">{{ $user->average_problem_rating ?? 0 }}</h2>
                            <small class="text-muted">Avg Problem Rating</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card h-100 shadow-sm" style="border-top: 4px solid #212529;">
                        <div class="card-body text-center">
                            <i class="fas fa-users" style="font-size: 2.5rem; color: #212529; margin-bottom: 10px;"></i>
                            <h2 class="mb-0" style="color: #212529; font-weight: 700;">{{ number_format($user->followers_count ?? 0) }}</h2>
                            <small class="text-muted">Followers</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card h-100 shadow-sm" style="border-top: 4px solid {{ $themeColor }};">
                        <div class="card-body text-center">
                            <i class="fas fa-trophy" style="font-size: 2.5rem; color: {{ $themeColor }}; margin-bottom: 10px;"></i>
                            <h2 class="mb-0" style="color: {{ $themeColor }}; font-weight: 700;">{{ $rating }}</h2>
                            <small class="text-muted">Max CF Rating</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header" style="background: {{ $themeBg }}; border-bottom: 2px solid {{ $themeColor }};">
                    <h5 class="mb-0" style="color: {{ $themeColor }};">
                        <i class="fas fa-info-circle"></i> Profile Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="mb-1"><strong style="color: {{ $themeColor }};">CF Max Rating:</strong></p>
                            <p class="text-muted">{{ $rating }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="mb-1"><strong style="color: {{ $themeColor }};">Email:</strong></p>
                            <p class="text-muted">{{ $user->email }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="mb-1"><strong style="color: {{ $themeColor }};">Registered:</strong></p>
                            <p class="text-muted">
                                @if(!empty($user->created_at))
                                    @php
                                        $created = \Carbon\Carbon::parse($user->created_at);
                                        $totalDays = $created->diffInDays(now());
                                        // Convert using 1 year = 365 days, 1 month = 30 days
                                        $years = intdiv($totalDays, 365);
                                        $rem = $totalDays % 365;
                                        $months = intdiv($rem, 30);
                                        $days = $rem % 30;
                                        $parts = [];
                                        if ($years > 0) {
                                            $parts[] = $years . ' year' . ($years > 1 ? 's' : '');
                                        }
                                        if ($months > 0) {
                                            $parts[] = $months . ' month' . ($months > 1 ? 's' : '');
                                        }
                                        // Always show days if nothing else or if days > 0
                                        if ($days > 0 || empty($parts)) {
                                            $parts[] = $days . ' day' . ($days > 1 ? 's' : '');
                                        }
                                    @endphp
                                    @if($totalDays === 0)
                                        Today
                                    @else
                                        {{ implode(' ', $parts) }} ago
                                    @endif
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                        @if($user->cf_handle)
                        <div class="col-md-6 mb-3">
                            <p class="mb-1"><strong style="color: {{ $themeColor }};">Codeforces Handle:</strong></p>
                            <p>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" style="vertical-align: middle; margin-right: 6px; display: inline-block;">
                                    <path fill="{{ $themeColor }}" d="M4.5 7.5C5.328 7.5 6 8.172 6 9v10.5c0 .828-.672 1.5-1.5 1.5h-3C.672 21 0 20.328 0 19.5V9c0-.828.672-1.5 1.5-1.5h3zm9-4.5c.828 0 1.5.672 1.5 1.5v15c0 .828-.672 1.5-1.5 1.5h-3c-.828 0-1.5-.672-1.5-1.5v-15c0-.828.672-1.5 1.5-1.5h3zm9 7.5c.828 0 1.5.672 1.5 1.5v7.5c0 .828-.672 1.5-1.5 1.5h-3c-.828 0-1.5-.672-1.5-1.5V12c0-.828.672-1.5 1.5-1.5h3z"/>
                                </svg>
                                <a href="https://codeforces.com/profile/{{ $user->cf_handle }}" target="_blank" style="color: {{ $themeColor }}; text-decoration: none; font-weight: 600;">
                                    {{ $user->cf_handle }}
                                </a>
                            </p>
                        </div>
                        @endif
                        @if($user->country)
                        <div class="col-md-6 mb-3">
                            <p class="mb-1"><strong style="color: {{ $themeColor }};">Country:</strong></p>
                            <p class="text-muted"><i class="fas fa-globe"></i> {{ $user->country }}</p>
                        </div>
                        @endif
                        @if($user->university)
                        <div class="col-md-6 mb-3">
                            <p class="mb-1"><strong style="color: {{ $themeColor }};">University:</strong></p>
                            <p class="text-muted"><i class="fas fa-graduation-cap"></i> {{ $user->university }}</p>
                        </div>
                        @endif
                    </div>
                    @if($user->bio)
                    <div class="mt-3">
                        <p class="mb-2"><strong style="color: {{ $themeColor }};">Bio:</strong></p>
                        <div style="padding: 15px; background: {{ $themeBg }}; border-radius: 8px; border-left: 4px solid {{ $themeColor }};">
                            <p class="mb-0">{{ $user->bio }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons at Bottom (Left Aligned) -->
    <div class="row mt-4 pt-4" style="border-top: 2px solid #dee2e6;">
        <div class="col-12">
            <div class="d-flex gap-2">
                <a href="{{ route('user.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Users
                </a>
                <a href="{{ route('user.edit', $user) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit User
                </a>
                <form action="{{ route('user.destroy', $user) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                        <i class="fas fa-trash"></i> Delete User
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layout>
