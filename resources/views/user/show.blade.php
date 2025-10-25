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
                        @if(auth()->user()->user_id !== $user->user_id)
                            @php
                                $isFollowing = auth()->user()->isFollowing($user->user_id);
                            @endphp
                            <form action="{{ $isFollowing ? route('friend.unfollow', $user->user_id) : route('friend.follow', $user->user_id) }}" method="POST" class="mb-2">
                                @csrf
                                @if($isFollowing)
                                    <button type="submit" class="btn btn-outline-secondary" style="width: 100%;">
                                        <i class="fas fa-user-minus"></i> Unfollow
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                                        <i class="fas fa-user-plus"></i> Follow
                                    </button>
                                @endif
                            </form>
                        @endif
                        
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
                            <h2 class="mb-0" style="color: #212529; font-weight: 700;">{{ number_format($user->average_problem_rating ?? 0, 1) }}</h2>
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

    <!-- Problem History Section -->
    @php
        // Get all user problems with pagination (10 per page)
        $userProblemsQuery = $user->userProblems()->with('problem.tags');
        $allUserProblems = $userProblemsQuery->get();
        
        // Sort by last modified (updated_at desc)
        $sortedProblems = $allUserProblems->sortByDesc('updated_at');
        
        // Manual pagination (10 per page)
        $perPage = 10;
        $currentPage = request('page', 1);
        $total = $sortedProblems->count();
        $userProblems = $sortedProblems->forPage($currentPage, $perPage);
        
        $solvedProblems = $allUserProblems->where('status', 'solved');
        $tryingProblems = $allUserProblems->where('status', 'trying');
        $starredProblems = $allUserProblems->where('is_starred', true);
    @endphp

    @if($userProblems->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header" style="background: {{ $themeBg }}; border-bottom: 2px solid {{ $themeColor }};">
                        <h4 class="mb-0" style="color: {{ $themeColor }};">
                            <i class="fas fa-history"></i> Problem History
                            <small class="text-muted ms-2">({{ $total }} total problems)</small>
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Stats Overview -->
                        <div class="row mb-4">
                            <div class="col-md-4 mb-2">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-2" style="font-size: 1.5rem;"></i>
                                    <div>
                                        <strong>{{ $solvedProblems->count() }}</strong> Solved
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-spinner text-warning me-2" style="font-size: 1.5rem;"></i>
                                    <div>
                                        <strong>{{ $tryingProblems->count() }}</strong> Trying
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-star text-warning me-2" style="font-size: 1.5rem;"></i>
                                    <div>
                                        <strong>{{ $starredProblems->count() }}</strong> Starred
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Problem List -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Problem</th>
                                        <th>Rating</th>
                                        <th>Tags</th>
                                        <th>Status</th>
                                        <th>Solved Date</th>
                                        <th>Submission</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($userProblems as $userProblem)
                                        @php
                                            $problem = $userProblem->problem;
                                            $problemRating = (int) ($problem->rating ?? 0);
                                            $problemColor = \App\Helpers\RatingHelper::getRatingColor($problemRating);
                                        @endphp
                                        <tr>
                                            <td>
                                                <a href="{{ route('problem.show', $problem) }}" class="text-decoration-none" style="color: {{ $problemColor }}; font-weight: 600;">
                                                    {{ $problem->title }}
                                                </a>
                                                @if($userProblem->is_starred)
                                                    <i class="fas fa-star text-warning ms-1" title="Starred"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge" style="background: {{ $problemColor }}; color: white;">
                                                    {{ $problemRating }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($problem->tags->count() > 0)
                                                    @foreach($problem->tags->take(2) as $tag)
                                                        <x-tag-badge :tagName="$tag->tag_name" :tagId="$tag->tag_id" />
                                                    @endforeach
                                                    @if($problem->tags->count() > 2)
                                                        <span class="text-muted small">+{{ $problem->tags->count() - 2 }}</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if($userProblem->status === 'solved')
                                                    <span class="badge bg-success"><i class="fas fa-check-circle"></i> Solved</span>
                                                @elseif($userProblem->status === 'trying')
                                                    <span class="badge bg-warning"><i class="fas fa-spinner"></i> Trying</span>
                                                @else
                                                    <span class="badge bg-secondary"><i class="fas fa-times-circle"></i> Unsolved</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($userProblem->solved_at)
                                                    <small class="text-muted">{{ $userProblem->solved_at->format('M d, Y') }}</small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($userProblem->submission_link)
                                                    <a href="{{ $userProblem->submission_link }}" target="_blank" class="btn btn-sm btn-outline-primary" title="View Submission">
                                                        <i class="fas fa-external-link-alt"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($total > $perPage)
                            <nav aria-label="Problem history pagination" class="mt-3">
                                <ul class="pagination justify-content-center">
                                    <!-- Previous Page -->
                                    @if($currentPage > 1)
                                        <li class="page-item">
                                            <a class="page-link" href="?page={{ $currentPage - 1 }}">Previous</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">Previous</span>
                                        </li>
                                    @endif
                                    
                                    <!-- Page Numbers -->
                                    @php
                                        $totalPages = ceil($total / $perPage);
                                        $startPage = max(1, $currentPage - 2);
                                        $endPage = min($totalPages, $currentPage + 2);
                                    @endphp
                                    
                                    @for($i = $startPage; $i <= $endPage; $i++)
                                        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                            <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                                        </li>
                                    @endfor
                                    
                                    <!-- Next Page -->
                                    @if($currentPage < $totalPages)
                                        <li class="page-item">
                                            <a class="page-link" href="?page={{ $currentPage + 1 }}">Next</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">Next</span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Editorials Section -->
    @php
        $editorials = $user->editorials()->with('problem')->orderBy('upvotes', 'desc')->get();
    @endphp
    
    @if($editorials->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header" style="background: {{ $themeBg }}; border-bottom: 2px solid {{ $themeColor }};">
                        <h4 class="mb-0" style="color: {{ $themeColor }};">
                            <i class="fas fa-book-open"></i> Editorials Written ({{ $editorials->count() }})
                        </h4>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-4">
                            <i class="fas fa-info-circle"></i> Editorials are sorted by upvotes
                        </p>
                        
                        <div class="row">
                            @foreach($editorials as $editorial)
                                @php
                                    $problemRating = (int) ($editorial->problem->rating ?? 0);
                                    $problemThemeColor = \App\Helpers\RatingHelper::getRatingColor($problemRating);
                                @endphp
                                
                                <div class="col-lg-6 mb-3">
                                    <div class="card h-100" style="border-left: 3px solid {{ $problemThemeColor }};">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="card-title mb-0">
                                                    <a href="{{ route('problem.show', $editorial->problem->problem_id) }}" 
                                                       style="color: {{ $problemThemeColor }}; text-decoration: none; font-weight: 700;">
                                                        {{ $editorial->problem->title }}
                                                    </a>
                                                </h6>
                                                <div>
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-thumbs-up"></i> {{ $editorial->upvotes }}
                                                    </span>
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-thumbs-down"></i> {{ $editorial->downvotes }}
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <p class="card-text text-muted mb-2" style="font-size: 0.9rem;">
                                                {{ Str::limit(strip_tags($editorial->solution), 100) }}
                                            </p>
                                            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    <i class="far fa-clock"></i> {{ $editorial->updated_at->diffForHumans() }}
                                                </small>
                                                <a href="{{ route('editorial.show', $editorial->editorial_id) }}" 
                                                   class="btn btn-sm" 
                                                   style="background: {{ $problemThemeColor }}; color: white;">
                                                    <i class="fas fa-eye"></i> Read
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Action Buttons at Bottom (Left Aligned) -->
    <div class="row mt-4 pt-4" style="border-top: 2px solid #dee2e6;">
        <div class="col-12">
            <div class="d-flex gap-2">
                <a href="{{ route('user.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Users
                </a>
                
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-tachometer-alt"></i> Go to Admin Dashboard
                        </a>
                    @endif
                @endauth
                
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
