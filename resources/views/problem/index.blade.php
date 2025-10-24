<x-layout>
    <x-slot:title>Problems - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-code" style="color: var(--primary);"></i> Problems
            </h1>
            <p class="lead">Browse and solve competitive programming problems</p>
        </div>
    </div>

    <!-- Success Message -->
    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filters -->
    <x-problem-filters :tags="$tags" :selectedTags="$selectedTags" :showStarred="$showStarred" />

    <!-- Search and Pagination Controls -->
    @include('components.search-pagination', ['paginator' => $problems])

    <!-- Sorting Controls -->
    <div class="card shadow-sm mb-3">
        <div class="card-body p-3">
            <form method="GET" class="d-flex align-items-center justify-content-between flex-wrap gap-2" id="sortForm">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="per_page" value="{{ request('per_page', 25) }}">
                @foreach(request('tags', []) as $tag)
                    <input type="hidden" name="tags[]" value="{{ $tag }}">
                @endforeach
                <input type="hidden" name="min_rating" value="{{ request('min_rating') }}">
                <input type="hidden" name="max_rating" value="{{ request('max_rating') }}">
                <input type="hidden" name="starred" value="{{ request('starred') }}">
                
                <div class="d-flex align-items-center gap-2">
                    <label class="mb-0 text-muted fw-bold">Sort by:</label>
                    <select name="sort" class="form-select form-select-sm" style="width: 160px;" onchange="document.getElementById('sortForm').submit();">
                        <option value="created" {{ ($sort ?? 'created') === 'created' ? 'selected' : '' }}>Date Added</option>
                        <option value="popularity" {{ ($sort ?? '') === 'popularity' ? 'selected' : '' }}>Popularity</option>
                        <option value="title" {{ ($sort ?? '') === 'title' ? 'selected' : '' }}>Title</option>
                        <option value="rating" {{ ($sort ?? '') === 'rating' ? 'selected' : '' }}>Rating</option>
                        <option value="solved" {{ ($sort ?? '') === 'solved' ? 'selected' : '' }}>Solved Count</option>
                        <option value="stars" {{ ($sort ?? '') === 'stars' ? 'selected' : '' }}>Stars</option>
                    </select>

                    <select name="direction" class="form-select form-select-sm" style="width: 130px;" onchange="document.getElementById('sortForm').submit();">
                        <option value="desc" {{ ($direction ?? 'desc') === 'desc' ? 'selected' : '' }}>Descending</option>
                        <option value="asc" {{ ($direction ?? 'desc') === 'asc' ? 'selected' : '' }}>Ascending</option>
                    </select>
                </div>
                
                <div>
                    <small class="text-muted">Showing {{ $problems->total() }} problems</small>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <x-table :headers="['⭐', 'Title', 'Rating', 'Tags', 'Solved', 'Stars', 'Popularity', 'Status', 'Link']" :paginator="$problems">
                @forelse($problems as $problem)
                    @php
                        $rating = (int) ($problem->rating ?? 0);
                        $ratingColor = \App\Helpers\RatingHelper::getRatingColor($rating);
                        $search = request('search', '');
                        
                        // Check user's status with this problem
                        $userProblem = null;
                        if (auth()->check()) {
                            $userProblemData = \DB::select('SELECT * FROM userproblems WHERE user_id = ? AND problem_id = ? LIMIT 1', [auth()->id(), $problem->problem_id]);
                            if (!empty($userProblemData)) {
                                $userProblem = $userProblemData[0];
                            }
                        }
                        $isStarred = $userProblem && $userProblem->is_starred;
                        $currentStatus = $userProblem ? $userProblem->status : 'unsolved';
                    @endphp
                    <tr>
                        <!-- Star Column -->
                        <td onclick="event.stopPropagation();" class="text-center" style="width: 60px;">
                            @auth
                                <form action="{{ route('problem.toggleStar', $problem) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                    <button type="submit" class="btn btn-sm p-0 border-0" style="background: transparent; font-size: 1.3rem;">
                                        @if($isStarred)
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star text-muted"></i>
                                        @endif
                                    </button>
                                </form>
                            @else
                                <i class="far fa-star text-muted" style="font-size: 1.3rem;"></i>
                            @endauth
                        </td>
                        
                        <!-- Title -->
                        <td onclick="window.location='{{ route('problem.show', $problem) }}'">
                            <a href="{{ route('problem.show', $problem) }}" style="text-decoration: none; color: var(--primary); font-weight: 600;">
                                {!! \App\Helpers\SearchHelper::highlight($problem->title, $search) !!}
                            </a>
                        </td>
                        <td onclick="window.location='{{ route('problem.show', $problem) }}'">
                            <span class="badge" style="background: {{ $ratingColor }}; color: white;">{{ $rating }}</span>
                        </td>
                        <td onclick="window.location='{{ route('problem.show', $problem) }}'">
                            @if($problem->tags->count() > 0)
                                @foreach($problem->tags as $tag)
                                    <x-tag-badge :tagName="$tag->tag_name" :tagId="$tag->tag_id" />
                                @endforeach
                            @else
                                <span class="text-muted" style="font-size: 0.85rem;">No tags</span>
                            @endif
                        </td>
                        <td onclick="window.location='{{ route('problem.show', $problem) }}'">{{ number_format($problem->solved_count ?? 0) }}</td>
                        <td onclick="window.location='{{ route('problem.show', $problem) }}'">{{ number_format($problem->stars ?? 0) }}</td>
                        <td onclick="window.location='{{ route('problem.show', $problem) }}'">{{ $problem->popularity_percentage }}%</td>
                        
                        <!-- Status Column: colored select (no duplicate badge) -->
                        <td onclick="event.stopPropagation();" style="width: 160px;">
                            @php
                                $statusClass = 'secondary';
                                if ($currentStatus === 'solved') $statusClass = 'success';
                                elseif ($currentStatus === 'attempting' || $currentStatus === 'trying') $statusClass = 'warning';
                                elseif ($currentStatus === 'unsolved') $statusClass = 'secondary';
                                // Map to Bootstrap background classes for select
                                $selectClass = 'bg-' . $statusClass . ' text-white';
                            @endphp
                            @auth
                                <form action="{{ route('problem.updateStatus', $problem) }}" method="POST" style="display:inline; margin:0;">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                    <select name="status" class="form-select form-select-sm {{ $selectClass }}" onchange="this.form.submit();" 
                                            style="font-size: 0.85rem; padding: 0.25rem 0.5rem; width: 140px;">
                                        <option value="unsolved" {{ $currentStatus === 'unsolved' ? 'selected' : '' }}>Unsolved</option>
                                        <option value="attempting" {{ $currentStatus === 'attempting' || $currentStatus === 'trying' ? 'selected' : '' }}>Trying</option>
                                        <option value="solved" {{ $currentStatus === 'solved' ? 'selected' : '' }}>Solved</option>
                                    </select>
                                </form>
                            @else
                                <span class="badge bg-secondary">—</span>
                            @endauth
                        </td>
                        
                        <td onclick="event.stopPropagation();">
                            <a href="{{ $problem->problem_link }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fas fa-external-link-alt"></i> Solve
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center p-4">
                            <i class="fas fa-inbox" style="font-size: 2rem; color: var(--text-light); margin-right: 10px;"></i>
                            <p class="text-muted mb-0">No problems found{{ request('search') ? ' for "' . request('search') . '"' : '' }}</p>
                        </td>
                    </tr>
                @endforelse
            </x-table>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <div>
            <a href="{{ route('problem.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Problem
            </a>
        </div>
    </div>
</x-layout>
