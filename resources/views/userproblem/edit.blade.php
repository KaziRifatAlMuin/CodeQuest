<x-layout>
    <x-slot:title>Update Problem Status - CodeQuest</x-slot:title>

    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-12">
                <h2><i class="fas fa-pencil-alt text-primary"></i> Update Problem Status</h2>
                <p class="text-muted">Update your progress on <strong>{{ $problem->title }}</strong></p>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <h6 class="alert-heading"><i class="fas fa-exclamation-circle"></i> Errors:</h6>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('userProblem.update', [$problem, auth()->id()]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Problem Info -->
                            <div class="card mb-3 bg-light">
                                <div class="card-body">
                                    <h6 class="card-title"><i class="fas fa-code"></i> Problem</h6>
                                    <p class="mb-1"><strong>{{ $problem->title }}</strong></p>
                                    <p class="mb-0 text-muted">
                                        <span class="badge bg-primary">Rating: {{ $problem->rating }}</span>
                                        @if($problem->tags->count() > 0)
                                            @foreach($problem->tags as $tag)
                                                <x-tag-badge :tagName="$tag->tag_name" :tagId="$tag->tag_id" />
                                            @endforeach
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Status Selection -->
                            <div class="mb-4">
                                <label class="form-label"><strong>Your Status <span class="text-danger">*</span></strong></label>
                                <div class="btn-group-vertical w-100" role="group">
                                    <input type="radio" class="btn-check" name="status" id="status_unsolved" value="unsolved" 
                                        {{ old('status', $userProblem?->status ?? 'unsolved') === 'unsolved' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-secondary text-start" for="status_unsolved">
                                        <i class="fas fa-times-circle text-danger"></i> Unsolved
                                    </label>

                                    <input type="radio" class="btn-check" name="status" id="status_trying" value="trying" 
                                        {{ old('status', $userProblem?->status ?? 'unsolved') === 'trying' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-secondary text-start" for="status_trying">
                                        <i class="fas fa-spinner text-warning"></i> Trying
                                    </label>

                                    <input type="radio" class="btn-check" name="status" id="status_solved" value="solved" 
                                        {{ old('status', $userProblem?->status ?? 'unsolved') === 'solved' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-secondary text-start" for="status_solved">
                                        <i class="fas fa-check-circle text-success"></i> Solved
                                    </label>
                                </div>
                            </div>

                            <!-- Star Checkbox -->
                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_starred" id="is_starred" value="1"
                                        {{ old('is_starred', $userProblem?->is_starred ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_starred">
                                        <i class="fas fa-star text-warning"></i> <strong>Mark as Starred</strong>
                                    </label>
                                    <div class="form-text">Add this problem to your starred list for quick access</div>
                                </div>
                            </div>

                            <!-- Submission Link -->
                            <div class="mb-3">
                                <label for="submission_link" class="form-label">Submission Link (Optional)</label>
                                <input type="url" class="form-control @error('submission_link') is-invalid @enderror" 
                                    id="submission_link" name="submission_link" 
                                    value="{{ old('submission_link', $userProblem?->submission_link) }}"
                                    placeholder="https://codeforces.com/...">
                                @error('submission_link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Private Notes -->
                            <div class="mb-4">
                                <label for="notes" class="form-label">
                                    <i class="fas fa-lock text-success"></i> Private Notes (Only you can see this)
                                </label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                    id="notes" name="notes" rows="4" 
                                    placeholder="Add your personal notes about this problem...">{{ old('notes', $userProblem?->notes) }}</textarea>
                                <small class="text-muted">Max 1000 characters</small>
                                @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Current Status Display -->
                            @if($userProblem)
                                <div class="alert alert-info small mb-3">
                                    <strong>Last Updated:</strong> {{ $userProblem->updated_at ? $userProblem->updated_at->diffForHumans() : 'Never' }}
                                    @if($userProblem->solved_at)
                                        <br><strong>Solved On:</strong> {{ $userProblem->solved_at->format('M d, Y h:i A') }}
                                    @endif
                                </div>
                            @endif

                            <!-- Actions -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Changes
                                </button>
                                <a href="{{ route('problem.show', $problem) }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
