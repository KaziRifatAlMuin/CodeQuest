<x-layout>
    <x-slot:title>All Editorials - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-book-open" style="color: #212529;"></i> All Editorials
            </h1>
            <p class="lead">Browse problem editorials written by the community (sorted by last updated)</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search and Pagination Controls -->
    @include('components.search-pagination', ['paginator' => $editorials])

    <!-- Sorting Controls -->
    <div class="card shadow-sm mb-3">
        <div class="card-body p-3">
            <form method="GET" class="d-flex align-items-center justify-content-between flex-wrap gap-2" id="sortForm">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="per_page" value="{{ request('per_page', 25) }}">
                
                <div class="d-flex align-items-center gap-2">
                    <label class="mb-0 text-muted fw-bold">Sort by:</label>
                    <select name="sort" class="form-select form-select-sm" style="width: 160px;" onchange="document.getElementById('sortForm').submit();">
                        <option value="updated" {{ ($sort ?? 'updated') === 'updated' ? 'selected' : '' }}>Last Updated</option>
                        <option value="created" {{ ($sort ?? '') === 'created' ? 'selected' : '' }}>Date Created</option>
                        <option value="upvotes" {{ ($sort ?? '') === 'upvotes' ? 'selected' : '' }}>Upvotes</option>
                        <option value="author" {{ ($sort ?? '') === 'author' ? 'selected' : '' }}>Author Name</option>
                        <option value="problem" {{ ($sort ?? '') === 'problem' ? 'selected' : '' }}>Problem Title</option>
                        <option value="rating" {{ ($sort ?? '') === 'rating' ? 'selected' : '' }}>Problem Rating</option>
                    </select>

                    <select name="direction" class="form-select form-select-sm" style="width: 130px;" onchange="document.getElementById('sortForm').submit();">
                        <option value="desc" {{ ($direction ?? 'desc') === 'desc' ? 'selected' : '' }}>Descending</option>
                        <option value="asc" {{ ($direction ?? 'desc') === 'asc' ? 'selected' : '' }}>Ascending</option>
                    </select>
                </div>
                
                <div>
                    <small class="text-muted">Showing {{ $editorials->total() }} editorials</small>
                </div>
            </form>
        </div>
    </div>

    @if($editorials->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> No editorials found{{ request('search') ? ' for "' . request('search') . '"' : '' }}. Be the first to write one!
        </div>
    @else
        <div class="row">
            @foreach($editorials as $editorial)
                @php
                    $rating = (int) ($editorial->problem->rating ?? 0);
                    $themeColor = \App\Helpers\RatingHelper::getRatingColor($rating);
                    $themeBg = \App\Helpers\RatingHelper::getRatingBgColor($rating);
                    $themeName = \App\Helpers\RatingHelper::getRatingTitle($rating);
                    $search = request('search', '');
                @endphp
                
                <div class="col-lg-6 mb-4">
                    <div class="card h-100 shadow-sm" style="border-left: 4px solid {{ $themeColor }};">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">
                                    <a href="{{ route('problem.show', $editorial->problem->problem_id) }}" 
                                       style="color: {{ $themeColor }}; text-decoration: none; font-weight: 700;">
                                        {!! \App\Helpers\SearchHelper::highlight($editorial->problem->title, $search) !!}
                                    </a>
                                </h5>
                                <span class="badge" style="background: {{ $themeColor }};">
                                    {{ $rating }}
                                </span>
                            </div>
                            
                            <p class="text-muted mb-2">
                                <small>
                                    <i class="fas fa-user"></i> By 
                                    <a href="{{ route('user.show', $editorial->author->user_id) }}" class="text-decoration-none">
                                        {!! \App\Helpers\SearchHelper::highlight($editorial->author->name, $search) !!}
                                    </a>
                                </small>
                            </p>
                            
                            <p class="card-text text-muted">
                                {!! \App\Helpers\SearchHelper::highlight(Str::limit(strip_tags($editorial->solution), 150), $search) !!}
                            </p>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-success">
                                        <i class="fas fa-thumbs-up"></i> {{ $editorial->upvotes }}
                                    </span>
                                    <span class="badge bg-danger">
                                        <i class="fas fa-thumbs-down"></i> {{ $editorial->downvotes }}
                                    </span>
                                </div>
                                <small class="text-muted">
                                    <i class="far fa-clock"></i> Updated {{ $editorial->updated_at->diffForHumans() }}
                                </small>
                            </div>
                            
                            <div class="mt-3">
                                <a href="{{ route('editorial.show', $editorial->editorial_id) }}" 
                                   class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Read Editorial
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $editorials->links() }}
        </div>
    @endif
</x-layout>
