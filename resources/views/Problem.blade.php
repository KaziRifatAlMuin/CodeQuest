<x-layout>
    <x-slot:title>Problem - CodeQuest</x-slot:title>

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="display-4">
                    <i class="fas fa-code" style="color: var(--primary);"></i> Problem Details
                </h1>
                <a href="/" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="mb-4">
                <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.75rem; letter-spacing: 1px;">
                    <i class="fas fa-hashtag"></i> Problem Number
                </h6>
                <span class="badge badge-primary" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                    {{ $problem_no }}
                </span>
            </div>

            <div class="mb-4">
                <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.75rem; letter-spacing: 1px;">
                    <i class="fas fa-heading"></i> Title
                </h6>
                <h4 style="color: var(--dark); font-weight: 600;">{{ $problem }}</h4>
            </div>

                <div>
                <h6 class="text-muted text-uppercase mb-2" style="font-size: 0.75rem; letter-spacing: 1px;">
                    <i class="fas fa-tag"></i> Category
                </h6>
                <span class="badge rating-bg-specialist" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                    {{ $tag }}
                </span>
            </div>
        </div>
    </div>
</x-layout>