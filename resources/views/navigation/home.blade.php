<x-layout>
    <x-slot:title>Home - CodeQuest</x-slot:title>

    <div class="card mb-4" style="background: linear-gradient(135deg, rgba(102,126,234,0.05) 0%, rgba(118,75,162,0.05) 100%); border: none;">
        <div class="card-body text-center py-5">
            <h1 class="display-3 mb-3" style="font-weight: 700;">
                <i class="fas fa-code" style="color: var(--primary);"></i> CodeQuest
            </h1>
            <p class="lead mb-4">Master coding through intelligent practice and community-driven learning</p>
            <hr class="my-4" style="border-color: var(--border); max-width: 600px; margin: 2rem auto;">
            <p class="mb-4">Start your journey today and level up your programming skills.</p>
            <a class="btn btn-primary btn-lg mr-2 mb-2 cta-btn" href="{{ route('account.register') }}" role="button">
                <i class="fas fa-play"></i> Get Started
            </a>
            <a class="btn btn-success btn-lg mb-2 cta-btn" href="{{ route('leaderboard') }}" role="button">
                <i class="fas fa-trophy"></i> View Leaderboard
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h3 class="card-title">🎯 Smart Recommendations</h3>
                    <p class="card-text">Get personalized problem recommendations based on your skill level and interests.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h3 class="card-title">📊 Track Progress</h3>
                    <p class="card-text">Monitor your improvement with detailed statistics and achievement tracking.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h3 class="card-title">🏆 Compete & Learn</h3>
                    <p class="card-text">Join our community, share solutions, and climb the leaderboard.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Top sections: Problems, Rated Users, Solvers -->
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-3">Top Community Picks</h2>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-fire text-danger"></i> Most Popular Problems</h5>
                    <p class="text-muted small">Top 10 problems by community popularity.</p>
                    <ul class="list-group list-group-flush mt-3">
                        @forelse($topProblems ?? [] as $problem)
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">{{ $problem->title }}</div>
                                <small class="text-muted">Solved: {{ $problem->solved_count ?? 0 }} • Popularity: {{ $problem->popularity_percentage }}%</small>
                            </div>
                            @if($problem->problem_link)
                            <a href="{{ $problem->problem_link }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary">Open</a>
                            @endif
                        </li>
                        @empty
                        <li class="list-group-item">No problems to show.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-star text-warning"></i> Top Rated Users</h5>
                    <p class="text-muted small">Most highly rated problem solvers.</p>
                    <ul class="list-group list-group-flush mt-3">
                        @forelse($topRatedUsers ?? [] as $user)
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-bold">{{ $user->name }}</div>
                                <small class="text-muted">Rating: {{ $user->cf_max_rating ?? 'N/A' }}</small>
                            </div>
                            @if(!empty($user->cf_handle))
                            <a href="https://codeforces.com/profile/{{ $user->cf_handle }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary">Profile</a>
                            @endif
                        </li>
                        @empty
                        <li class="list-group-item">No users to show.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-user-check text-success"></i> Top Solvers</h5>
                    <p class="text-muted small">Users with the most solved problems.</p>
                    <ul class="list-group list-group-flush mt-3">
                        @forelse($topSolvers ?? [] as $user)
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-bold">{{ $user->name }}</div>
                                <small class="text-muted">Solved: {{ $user->solved_problems_count ?? 0 }}</small>
                            </div>
                            @if(!empty($user->cf_handle))
                            <a href="https://codeforces.com/profile/{{ $user->cf_handle }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary">Profile</a>
                            @endif
                        </li>
                        @empty
                        <li class="list-group-item">No solvers to show.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layout>
