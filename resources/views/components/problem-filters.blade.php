<!-- Problem Filters -->
<div class="card shadow-sm mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-filter"></i> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('problem.index') }}" id="filterForm">
            <!-- Rating Range Filter -->
            <div class="mb-3">
                <label class="form-label"><strong>Filter by Rating Range:</strong></label>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="min_rating" class="form-label small">Minimum Rating</label>
                        <input type="number" class="form-control" id="min_rating" name="min_rating" 
                            value="{{ request('min_rating') }}" 
                            min="0" max="3500" step="100"
                            placeholder="e.g., 800">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="max_rating" class="form-label small">Maximum Rating</label>
                        <input type="number" class="form-control" id="max_rating" name="max_rating" 
                            value="{{ request('max_rating') }}" 
                            min="0" max="3500" step="100"
                            placeholder="e.g., 1600">
                    </div>
                </div>
                <small class="text-muted">Leave empty for no limit</small>
            </div>

            <!-- Tags Filter -->
            <div class="mb-3">
                <label class="form-label"><strong>Filter by Tags:</strong></label>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="tags[]" 
                                value="{{ $tag->tag_id }}" id="tag_{{ $tag->tag_id }}"
                                {{ in_array($tag->tag_id, $selectedTags) ? 'checked' : '' }}>
                            <label class="form-check-label" for="tag_{{ $tag->tag_id }}">
                                <x-tag-badge :tagName="$tag->tag_name" :tagId="$tag->tag_id" />
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Starred Filter -->
            @auth
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="starred" id="starred"
                            value="1" {{ $showStarred ? 'checked' : '' }}>
                        <label class="form-check-label" for="starred">
                            <i class="fas fa-star text-warning"></i> Show only my starred problems
                        </label>
                    </div>
                </div>
            @endauth

            <!-- Action Buttons -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Apply Filters
                </button>
                <a href="{{ route('problem.index') }}" class="btn btn-secondary">
                    <i class="fas fa-redo"></i> Reset Filters
                </a>
            </div>
        </form>
    </div>
</div>
