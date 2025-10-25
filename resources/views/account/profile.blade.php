<x-layout>
    <x-slot:title>My Profile - CodeQuest</x-slot:title>
    
    <div class="container mt-5 mb-5" style="max-width: 900px;">
        <!-- Success/Error Messages -->
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Profile Header -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header text-white text-center py-5 position-relative" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px 15px 0 0;">
                <!-- Edit Profile Button -->
                <a href="{{ route('account.editProfile') }}" class="btn btn-light btn-sm position-absolute" style="top: 1rem; right: 1rem;">
                    <i class="fas fa-edit"></i> Edit Profile
                </a>

                <!-- Profile Picture -->
                <div class="position-relative d-inline-block mb-3">
                    @if($user->profile_picture)
                        <img src="{{ asset('images/profile/' . $user->profile_picture) }}" 
                             alt="{{ $user->name }}" 
                             class="rounded-circle" 
                             style="width: 120px; height: 120px; object-fit: cover; border: 5px solid white;">
                    @else
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 120px; height: 120px; border: 5px solid white; background: white;">
                            <i class="fas fa-user-circle" style="font-size: 3rem; color: #667eea;"></i>
                        </div>
                    @endif
                </div>

                <h2 class="mb-2 font-weight-bold">{{ $user->name }}</h2>
                <p class="mb-0">
                    <i class="fas fa-trophy"></i> {{ $user->cf_handle }}
                    @if($user->handle_verified_at)
                        <span class="badge badge-success ms-2">
                            <i class="fas fa-check-circle"></i> Verified
                        </span>
                    @else
                        <span class="badge badge-danger ms-2">
                            <i class="fas fa-times-circle"></i> Not Verified
                        </span>
                    @endif
                </p>
            </div>

            <div class="card-body p-4">
                <!-- Verification Alerts -->
                @if(!$user->email_verified_at)
                    <div class="alert alert-warning mb-3">
                        <i class="fas fa-exclamation-triangle"></i> Your email is not verified. 
                        <a href="{{ route('verification.notice') }}" class="alert-link font-weight-bold">Verify now</a>
                    </div>
                @endif

                @if(!$user->handle_verified_at)
                    <div class="alert alert-warning mb-4">
                        <i class="fas fa-exclamation-triangle"></i> Your Codeforces handle is not verified. 
                        <a href="{{ route('account.handleVerification') }}" class="alert-link font-weight-bold">Verify now</a>
                    </div>
                @endif

                <!-- Stats Grid -->
                <div class="row mb-4">
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card bg-light border text-center p-3">
                            <h3 class="text-primary font-weight-bold mb-0">{{ $user->cf_max_rating }}</h3>
                            <small class="text-muted">Max Rating</small>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card bg-light border text-center p-3">
                            <h3 class="text-primary font-weight-bold mb-0">{{ $user->solved_problems_count }}</h3>
                            <small class="text-muted">Problems Solved</small>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card bg-light border text-center p-3">
                            <h3 class="text-primary font-weight-bold mb-0">{{ number_format($user->average_problem_rating, 0) }}</h3>
                            <small class="text-muted">Avg. Problem Rating</small>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card bg-light border text-center p-3">
                            <h3 class="text-primary font-weight-bold mb-0">{{ $user->followers_count }}</h3>
                            <small class="text-muted">Followers</small>
                        </div>
                    </div>
                </div>

                <!-- Followers and Following Section -->
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <div class="card border">
                            <div class="card-header bg-primary text-white">
                                <i class="fas fa-users"></i> My Followers ({{ $user->followers()->count() }})
                            </div>
                            <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                                @php
                                    $followers = $user->followers()->take(10)->get();
                                @endphp
                                @if($followers->count() > 0)
                                    <div class="list-group list-group-flush">
                                        @foreach($followers as $follower)
                                            <a href="{{ route('user.show', $follower->user_id) }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                                @if($follower->profile_picture)
                                                    <img src="{{ asset('images/profile/' . $follower->profile_picture) }}" 
                                                         alt="{{ $follower->name }}" 
                                                         class="rounded-circle me-2" 
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                                        <i class="fas fa-user text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="font-weight-bold">{{ $follower->name }}</div>
                                                    <small class="text-muted">{{ $follower->cf_handle ?? 'No handle' }}</small>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                    @if($user->followers()->count() > 10)
                                        <div class="text-center mt-2">
                                            <a href="{{ route('friend.followers', $user->user_id) }}" class="btn btn-sm btn-outline-primary">
                                                View All Followers
                                            </a>
                                        </div>
                                    @endif
                                @else
                                    <p class="text-muted text-center mb-0">No followers yet</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card border">
                            <div class="card-header bg-success text-white">
                                <i class="fas fa-user-friends"></i> Following ({{ $user->following()->count() }})
                            </div>
                            <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                                @php
                                    $following = $user->following()->take(10)->get();
                                @endphp
                                @if($following->count() > 0)
                                    <div class="list-group list-group-flush">
                                        @foreach($following as $followedUser)
                                            <a href="{{ route('user.show', $followedUser->user_id) }}" class="list-group-item list-group-item-action d-flex align-items-center">
                                                @if($followedUser->profile_picture)
                                                    <img src="{{ asset('images/profile/' . $followedUser->profile_picture) }}" 
                                                         alt="{{ $followedUser->name }}" 
                                                         class="rounded-circle me-2" 
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">
                                                        <i class="fas fa-user text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="font-weight-bold">{{ $followedUser->name }}</div>
                                                    <small class="text-muted">{{ $followedUser->cf_handle ?? 'No handle' }}</small>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                    @if($user->following()->count() > 10)
                                        <div class="text-center mt-2">
                                            <a href="{{ route('friend.following', $user->user_id) }}" class="btn btn-sm btn-outline-success">
                                                View All Following
                                            </a>
                                        </div>
                                    @endif
                                @else
                                    <p class="text-muted text-center mb-0">Not following anyone</p>
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
                    
                    $solvedProblems = $allUserProblems->where('status', 'solved')->count();
                    $tryingProblems = $allUserProblems->where('status', 'trying')->count();
                    $starredProblems = $allUserProblems->where('is_starred', true)->count();
                @endphp
                
                @if($userProblems->count() > 0)
                    <div class="card border mb-4">
                        <div class="card-header bg-info text-white">
                            <i class="fas fa-history"></i> Problem History
                            <span class="badge bg-light text-dark ms-2">{{ $total }} total</span>
                        </div>
                        <div class="card-body">
                            <!-- Stats Overview -->
                            <div class="row mb-3">
                                <div class="col-md-4 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success me-2" style="font-size: 1.5rem;"></i>
                                        <div>
                                            <strong>{{ $solvedProblems }}</strong> Solved
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-spinner text-warning me-2" style="font-size: 1.5rem;"></i>
                                        <div>
                                            <strong>{{ $tryingProblems }}</strong> Trying
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-star text-warning me-2" style="font-size: 1.5rem;"></i>
                                        <div>
                                            <strong>{{ $starredProblems }}</strong> Starred
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Problem List -->
                            <div class="table-responsive">
                                <table class="table table-hover table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Problem</th>
                                            <th>Rating</th>
                                            <th>Status</th>
                                            <th>Solved Date</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($userProblems as $userProblem)
                                            @php
                                                $problem = $userProblem->problem;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <a href="{{ route('problem.show', $problem) }}" class="text-decoration-none">
                                                        {{ Str::limit($problem->title, 40) }}
                                                    </a>
                                                    @if($userProblem->is_starred)
                                                        <i class="fas fa-star text-warning ms-1" title="Starred"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-secondary">{{ $problem->rating }}</span>
                                                </td>
                                                <td>
                                                    @if($userProblem->status === 'solved')
                                                        <span class="badge bg-success">Solved</span>
                                                    @elseif($userProblem->status === 'trying')
                                                        <span class="badge bg-warning">Trying</span>
                                                    @else
                                                        <span class="badge bg-secondary">Unsolved</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($userProblem->solved_at)
                                                        <small>{{ $userProblem->solved_at->format('M d, Y') }}</small>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($userProblem->submission_link)
                                                            <a href="{{ $userProblem->submission_link }}" target="_blank" class="btn btn-sm btn-outline-primary me-2" title="View Submission">
                                                                <i class="fas fa-external-link-alt"></i>
                                                            </a>
                                                        @endif
                                                        @if($userProblem->notes)
                                                            <small class="text-muted">{{ Str::limit($userProblem->notes, 30) }}</small>
                                                        @else
                                                            <small class="text-muted">-</small>
                                                        @endif
                                                    </div>
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
                @endif

                <!-- Editorial History Section -->
                @php
                    $editorials = $user->editorials()->with('problem')->orderBy('upvotes', 'desc')->take(10)->get();
                @endphp
                
                @if($editorials->count() > 0)
                    <div class="card border mb-4">
                        <div class="card-header bg-warning text-dark">
                            <i class="fas fa-book-open"></i> Editorials Written
                            <span class="badge bg-dark ms-2">{{ $editorials->count() }}</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($editorials as $editorial)
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100 border-start border-3 border-warning">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h6 class="card-title mb-0">
                                                        <a href="{{ route('problem.show', $editorial->problem->problem_id) }}" class="text-decoration-none">
                                                            {{ Str::limit($editorial->problem->title, 40) }}
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
                                                <p class="card-text text-muted mb-2" style="font-size: 0.85rem;">
                                                    {{ Str::limit(strip_tags($editorial->solution), 80) }}
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted">
                                                        <i class="far fa-clock"></i> {{ $editorial->updated_at->diffForHumans() }}
                                                    </small>
                                                    <a href="{{ route('editorial.show', $editorial->editorial_id) }}" class="btn btn-sm btn-outline-warning">
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
                @endif

                <!-- Profile Information -->
                <div class="row mt-4">
                    <div class="col-md-6 mb-4">
                        <div class="pb-3 border-bottom">
                            <label class="text-muted small font-weight-bold text-uppercase mb-1">
                                <i class="fas fa-envelope"></i> Email
                            </label>
                            <div class="h6 mb-0">
                                {{ $user->email }}
                                @if($user->email_verified_at)
                                    <span class="badge badge-success badge-sm ml-2">
                                        <i class="fas fa-check"></i> Verified
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="pb-3 border-bottom">
                            <label class="text-muted small font-weight-bold text-uppercase mb-1">
                                <i class="fas fa-user-tag"></i> Role
                            </label>
                            <div class="h6 mb-0 text-capitalize">{{ $user->role }}</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="pb-3 border-bottom">
                            <label class="text-muted small font-weight-bold text-uppercase mb-1">
                                <i class="fas fa-globe"></i> Country
                            </label>
                            <div class="h6 mb-0">{{ $user->country ?? 'Not specified' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="pb-3 border-bottom">
                            <label class="text-muted small font-weight-bold text-uppercase mb-1">
                                <i class="fas fa-university"></i> University
                            </label>
                            <div class="h6 mb-0">{{ $user->university ?? 'Not specified' }}</div>
                        </div>
                    </div>
                </div>

                @if($user->bio)
                    <div class="mb-4">
                        <div class="pb-3 border-bottom">
                            <label class="text-muted small font-weight-bold text-uppercase mb-1">
                                <i class="fas fa-info-circle"></i> Bio
                            </label>
                            <div class="h6 mb-0">{{ $user->bio }}</div>
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="pb-3 border-bottom">
                            <label class="text-muted small font-weight-bold text-uppercase mb-1">
                                <i class="fas fa-calendar-alt"></i> Member Since
                            </label>
                            <div class="h6 mb-0">{{ $user->created_at->format('F d, Y') }}</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="pb-3 border-bottom">
                            <label class="text-muted small font-weight-bold text-uppercase mb-1">
                                <i class="fas fa-clock"></i> Last Updated
                            </label>
                            <div class="h6 mb-0">{{ $user->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="text-center mt-5 pt-4 border-top">
                    <form action="{{ route('account.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-lg px-5 shadow-sm">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
