<x-layout>
    <x-slot:title>Statistics - CodeQuest</x-slot:title>

    <div class="container py-5">
        <h1 class="mb-4">📊 Platform Statistics</h1>
        <p class="text-muted mb-4">Numbers surfaced from the database views consumed by the statistics controller.</p>

        @php
            $ratingBadge = function ($rating) {
                if (is_null($rating)) {
                    return 'bg-secondary';
                }
                if ($rating < 1200) {
                    return 'bg-secondary';
                }
                if ($rating < 1400) {
                    return 'bg-success';
                }
                if ($rating < 1700) {
                    return 'bg-info text-dark';
                }
                if ($rating < 2000) {
                    return 'bg-primary';
                }
                if ($rating < 2300) {
                    return 'bg-warning text-dark';
                }
                return 'bg-danger';
            };
        @endphp

        <div class="row g-3 mb-5">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <span class="text-muted text-uppercase small">Users</span>
                        <h3 class="mt-2 text-primary">{{ number_format($platformStats->total_users ?? 0) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <span class="text-muted text-uppercase small">Problems</span>
                        <h3 class="mt-2 text-success">{{ number_format($platformStats->total_problems ?? 0) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <span class="text-muted text-uppercase small">Solutions</span>
                        <h3 class="mt-2 text-info">{{ number_format($platformStats->total_solutions ?? 0) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <span class="text-muted text-uppercase small">Editorials</span>
                        <h3 class="mt-2 text-warning">{{ number_format($platformStats->total_editorials ?? 0) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-primary text-white">Difficulty Distribution</div>
                    <div class="card-body">
                        <table class="table table-sm align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Difficulty</th>
                                    <th class="text-end">Problems</th>
                                    <th class="text-end">Avg Solved</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($difficultyStats as $stat)
                                    <tr>
                                        <td><span class="badge bg-primary">{{ $stat->difficulty }}</span></td>
                                        <td class="text-end">{{ number_format($stat->count ?? 0) }}</td>
                                        <td class="text-end">{{ number_format($stat->avg_solved ?? 0, 1) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No difficulty data available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-success text-white">Most Popular Tags</div>
                    <div class="card-body">
                        <table class="table table-sm align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Tag</th>
                                    <th class="text-end">Problems</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($popularTags as $tag)
                                    <tr>
                                        <td>{{ $tag->tag_name }}</td>
                                        <td class="text-end"><span class="badge bg-success">{{ number_format($tag->problem_count ?? 0) }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">No tag data available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-5">
            <div class="card-header bg-info text-white">Top Users</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Handle</th>
                                <th class="text-end">Rating</th>
                                <th class="text-end">Solved</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topUsers as $user)
                                <tr>
                                    <td>{{ $user->rating_rank ?? '-' }}</td>
                                    <td>{{ $user->name ?? $user->user_name ?? 'Unknown' }}</td>
                                    <td>{{ $user->cf_handle ?? '—' }}</td>
                                    @php $userRating = $user->cf_max_rating ?? $user->max_rating ?? null; @endphp
                                    <td class="text-end"><span class="badge {{ $ratingBadge($userRating) }}">{{ $userRating ?? '—' }}</span></td>
                                    <td class="text-end">{{ number_format($user->solved_count ?? $user->solved_problems_count ?? 0) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No user statistics available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-secondary text-white">Top Problems</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Problem</th>
                                <th class="text-end">Rating</th>
                                <th class="text-end">Solved</th>
                                <th class="text-end">Popularity %</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProblems as $problem)
                                <tr>
                                    <td>{{ $problem->problem_name ?? $problem->title ?? 'Unknown Problem' }}</td>
                                    @php $problemRating = $problem->rating ?? $problem->cf_rating ?? null; @endphp
                                    <td class="text-end"><span class="badge {{ $ratingBadge($problemRating) }}">{{ $problemRating ?? '—' }}</span></td>
                                    <td class="text-end">{{ number_format($problem->solved_count ?? 0) }}</td>
                                    <td class="text-end">{{ number_format($problem->popularity ?? 0, 1) }}%</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No problem statistics available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout>
