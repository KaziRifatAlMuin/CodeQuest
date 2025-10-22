<x-layout>
    <x-slot:title>Edit Tag - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-edit" style="color: var(--primary);"></i> Edit Tag
            </h1>
            <p class="lead">Update tag information for <strong>{{ $tag->tag_name }}</strong></p>
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
        <div class="col-lg-6 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('tag.update', $tag) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="tag_name" class="form-label">Tag Name <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                class="form-control @error('tag_name') is-invalid @enderror" 
                                id="tag_name" 
                                name="tag_name" 
                                value="{{ old('tag_name', $tag->tag_name) }}" 
                                required
                            >
                            @error('tag_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="card mb-4 bg-light">
                            <div class="card-body">
                                <h6 class="card-title"><i class="fas fa-info-circle"></i> Tag Information</h6>
                                <p class="mb-1"><strong>Current Preview:</strong></p>
                                <div class="mb-2">
                                    <x-tag-badge :tagName="$tag->tag_name" :tagId="$tag->tag_id" />
                                </div>
                                <p class="mb-0 text-muted">
                                    <i class="fas fa-code"></i> This tag is currently used in <strong>{{ $tag->problems()->count() }}</strong> problems.
                                </p>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Update Tag
                            </button>
                            <a href="{{ route('tag.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            @if(auth()->user()->role === 'admin')
                                <button type="button" class="btn btn-danger btn-lg ms-auto" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="fas fa-trash"></i> Delete Tag
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @if(auth()->user()->role === 'admin')
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deleteModalLabel"><i class="fas fa-exclamation-triangle"></i> Confirm Delete</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete the tag <strong>{{ $tag->tag_name }}</strong>?</p>
                        <p class="text-warning mb-0">
                            <i class="fas fa-info-circle"></i> <strong>Note:</strong> This will remove the tag from all associated problems, but the problems themselves will not be deleted.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('tag.destroy', $tag) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete Tag
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-layout>
