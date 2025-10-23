<x-layout>
    <x-slot:title>Edit Problem - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-edit" style="color: var(--primary);"></i> Edit Problem
            </h1>
            <p class="lead">Update problem information for <strong>{{ $problem->title }}</strong></p>
        </div>
    </div>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h6 class="alert-heading"><i class="fas fa-exclamation-circle"></i> Please fix the following errors:</h6>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('problem.update', $problem) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="form-label">Problem Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $problem->title) }}" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="problem_link" class="form-label">Problem Link <span class="text-danger">*</span></label>
                            <input type="url" class="form-control @error('problem_link') is-invalid @enderror" id="problem_link" name="problem_link" value="{{ old('problem_link', $problem->problem_link) }}" required>
                            @error('problem_link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('rating') is-invalid @enderror" id="rating" name="rating" value="{{ old('rating', $problem->rating) }}" min="0" max="3500" required>
                            @error('rating') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Problem difficulty rating (0-3500)</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Tags (Optional)</label>
                            <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                @if($tags->count() > 0)
                                    <div class="row">
                                        @foreach($tags as $tag)
                                            <div class="col-md-6 mb-2">
                                                <div class="form-check">
                                                    <input 
                                                        class="form-check-input" 
                                                        type="checkbox" 
                                                        name="tags[]" 
                                                        value="{{ $tag->tag_id }}" 
                                                        id="tag_{{ $tag->tag_id }}"
                                                        {{ in_array($tag->tag_id, old('tags', $problem->tags->pluck('tag_id')->toArray())) ? 'checked' : '' }}
                                                    >
                                                    <label class="form-check-label" for="tag_{{ $tag->tag_id }}">
                                                        <x-tag-badge :tagName="$tag->tag_name" :tagId="$tag->tag_id" />
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted mb-0">No tags available. <a href="{{ route('tag.create') }}">Create one</a></p>
                                @endif
                            </div>
                            <small class="text-muted">Select one or more tags that describe this problem</small>
                        </div>

                        <div class="card mb-4 bg-light">
                            <div class="card-body">
                                <h6 class="card-title"><i class="fas fa-chart-line"></i> Current Statistics (Auto-calculated)</h6>
                                <div class="row text-center mt-3">
                                    <div class="col-md-4">
                                        <div class="mb-2"><strong>Solved Count</strong></div>
                                        <div class="text-primary h4">{{ $problem->solved_count ?? 0 }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-2"><strong>Stars</strong></div>
                                        <div class="text-warning h4">{{ $problem->stars ?? 0 }}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-2"><strong>Popularity</strong></div>
                                        <div class="text-success h4">{{ $problem->popularity_percentage }}%</div>
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle"></i> These values are automatically calculated based on user interactions and cannot be edited manually.
                                </small>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Update Problem
                            </button>
                            <a href="{{ route('problem.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
