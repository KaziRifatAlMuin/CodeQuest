<x-layout>
    <x-slot:title>Create Tag - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-tag" style="color: var(--primary);"></i> Create New Tag
            </h1>
            <p class="lead">Add a new tag for categorizing problems</p>
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
                    <form action="{{ route('tag.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="tag_name" class="form-label">Tag Name <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                class="form-control @error('tag_name') is-invalid @enderror" 
                                id="tag_name" 
                                name="tag_name" 
                                value="{{ old('tag_name') }}" 
                                placeholder="e.g., Dynamic Programming, Graph Theory"
                                required
                            >
                            @error('tag_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Enter a unique name for this tag</small>
                        </div>

                        <hr>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Create Tag
                            </button>
                            <a href="{{ route('tag.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
