<x-layout>
    <x-slot:title>Add New Problem - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-plus-circle" style="color: var(--primary);"></i> Add New Problem
            </h1>
            <p class="lead">Create a new competitive programming problem</p>
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
                    <form action="{{ route('problem.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="form-label">Problem Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="problem_link" class="form-label">Problem Link <span class="text-danger">*</span></label>
                            <input type="url" class="form-control @error('problem_link') is-invalid @enderror" id="problem_link" name="problem_link" value="{{ old('problem_link') }}" placeholder="https://codeforces.com/problemset/problem/..." required>
                            @error('problem_link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('rating') is-invalid @enderror" id="rating" name="rating" value="{{ old('rating', 0) }}" min="0" max="3500" required>
                            @error('rating') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Problem difficulty rating (0-3500)</small>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> <strong>Note:</strong> Solved count, stars, and popularity will be calculated automatically based on user interactions.
                        </div>

                        <hr>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Create Problem
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
