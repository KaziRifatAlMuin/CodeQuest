<x-layout>
    <x-slot:title>Tag Masters - CodeQuest</x-slot:title>

    <div class="container py-5">
        <h1 class="mb-4">🏷️ Tag Masters</h1>
        <p class="text-muted mb-4">Progress data powered by the tag master controller. Values refresh whenever the underlying SQL view is recalculated.</p>

        <div class="row g-4">
            @forelse($tagMasters as $tag)
                @php
                    $problemTotal = max((int) ($tag->problem_count ?? 0), 1);
                    $solvedCount = (int) ($tag->solved_count ?? 0);
                    $progress = min(100, round(($solvedCount / $problemTotal) * 100));
                @endphp
                <div class="col-md-6 col-xl-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="mb-1">{{ $tag->tag_name }}</h5>
                                <span class="badge bg-primary">{{ $progress }}%</span>
                            </div>
                            <p class="text-muted small mb-3">{{ number_format($solvedCount) }} solved of {{ number_format($tag->problem_count ?? 0) }} problems.</p>
                            <div class="progress mb-3" style="height: 8px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="mt-auto text-muted small d-flex justify-content-between">
                                <span>Remaining: {{ number_format(max(($tag->problem_count ?? 0) - $solvedCount, 0)) }}</span>
                                <span>Completed: {{ number_format($solvedCount) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border">No tag mastery data available.</div>
                </div>
            @endforelse
        </div>
    </div>
</x-layout>
