<x-layout>
    <x-slot:title>Problem Details - CodeQuest</x-slot:title>

    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <h1 class="h3">Problem Details</h1>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">&larr; Back</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $problem->title ?? 'Untitled Problem' }}</h5>

                <div class="mb-3">
                    <b>Problem ID:</b>
                    <span class="ms-2">{{ $problem->problem_id ?? $problem->id ?? 'N/A' }}</span>
                </div>

                <div class="mb-3">
                    <b>Link:</b>
                    <span class="ms-2">
                        @if(!empty($problem->problem_link))
                            <a href="{{ $problem->problem_link }}" target="_blank">Open on external site</a>
                        @else
                            N/A
                        @endif
                    </span>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-2"><b>Rating</b></div>
                        <div>{{ $problem->rating ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-2"><b>Solved Count</b></div>
                        <div>{{ $problem->solved_count ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-2"><b>Stars</b></div>
                        <div>{{ $problem->stars ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-2"><b>Popularity</b></div>
                        <div>{{ $problem->popularity ?? 'N/A' }}</div>
                    </div>
                </div>

                <hr />

                <div class="d-flex gap-3 small text-muted">
                    <div>Created: {{ $problem->created_at ?? 'N/A' }}</div>
                    <div>Updated: {{ $problem->updated_at ?? 'N/A' }}</div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
