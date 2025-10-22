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

    @if($editorials->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> No editorials found. Be the first to write one!
        </div>
    @else
        <div class="row">
            @foreach($editorials as $editorial)
                @php
                    $rating = (int) ($editorial->problem->rating ?? 0);
                    $themeColor = \App\Helpers\RatingHelper::getRatingColor($rating);
                    $themeBg = \App\Helpers\RatingHelper::getRatingBgColor($rating);
                    $themeName = \App\Helpers\RatingHelper::getRatingTitle($rating);
                @endphp
                
                <div class="col-lg-6 mb-4">
                    <div class="card h-100 shadow-sm" style="border-left: 4px solid {{ $themeColor }};">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">
                                    <a href="{{ route('problem.show', $editorial->problem->problem_id) }}" 
                                       style="color: {{ $themeColor }}; text-decoration: none; font-weight: 700;">
                                        {{ $editorial->problem->title }}
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
                                        {{ $editorial->author->name }}
                                    </a>
                                </small>
                            </p>
                            
                            <p class="card-text text-muted">
                                {{ Str::limit(strip_tags($editorial->solution), 150) }}
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
                                <a href="{{ route('editorials.show', $editorial->editorial_id) }}" 
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
