<x-layout>
    <x-slot:title>Home - CodeQuest</x-slot:title>

    <div class="card mb-3" style="background: linear-gradient(135deg, rgba(102,126,234,0.05) 0%, rgba(118,75,162,0.05) 100%); border: none;">
        <div class="card-body text-center py-3 py-md-4">
            <h1 class="mb-2" style="font-weight: 700; font-size: 1.8rem;">
                <i class="fas fa-code" style="color: var(--primary);"></i> CodeQuest
            </h1>
            <p class="mb-2" style="font-size: 0.95rem;">Master coding through intelligent practice and community-driven learning</p>
            <hr class="my-3" style="border-color: var(--border); max-width: 600px; margin: 1rem auto;">
            
            <!-- Search Box -->
            <form method="GET" action="{{ route('home') }}" class="mb-3">
                <div class="input-group mx-auto" style="max-width: 500px;">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search popular problems...">
                    @if(request('search'))
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
            
            <p class="mb-3" style="font-size: 0.9rem;">Start your journey today and level up your programming skills.</p>
            <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
                <a class="btn btn-primary mr-sm-2 cta-btn" href="{{ route('account.register') }}" role="button">
                    <i class="fas fa-play"></i> Get Started
                </a>
                <a class="btn btn-success cta-btn" href="{{ route('leaderboard') }}" role="button">
                    <i class="fas fa-trophy"></i> View Leaderboard
                </a>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card shadow-sm h-100">
                <div class="card-body py-3">
                    <h3 class="card-title" style="font-size: 1.1rem;">🎯 Smart Recommendations</h3>
                    <p class="card-text" style="font-size: 0.85rem;">Get personalized problem recommendations based on your skill level and interests.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card shadow-sm h-100">
                <div class="card-body py-3">
                    <h3 class="card-title" style="font-size: 1.1rem;">📊 Track Progress</h3>
                    <p class="card-text" style="font-size: 0.85rem;">Monitor your improvement with detailed statistics and achievement tracking.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card shadow-sm h-100">
                <div class="card-body py-3">
                    <h3 class="card-title" style="font-size: 1.1rem;">🏆 Compete & Learn</h3>
                    <p class="card-text" style="font-size: 0.85rem;">Join our community, share solutions, and climb the leaderboard.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Top sections: Problems, Rated Users, Solvers -->
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-3" style="font-size: 1.4rem;">Top Community Picks</h2>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body py-3">
                    <h5 class="card-title" style="font-size: 1rem;"><i class="fas fa-fire text-danger"></i> Most Popular Problems</h5>
                    <p class="text-muted small mb-2">Top 10 problems by community popularity{{ request('search') ? ' matching "' . request('search') . '"' : '' }}.</p>
                    <ul class="list-group list-group-flush mt-2">
                        @forelse($topProblems ?? [] as $problem)
                        @php
                            $search = request('search', '');
                        @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-start py-2 px-2">
                            <div class="ms-1 me-auto" style="min-width: 0;">
                                <div class="fw-bold text-truncate" style="font-size: 0.85rem;">
                                    {!! \App\Helpers\SearchHelper::highlight($problem->title, $search) !!}
                                </div>
                                <small class="text-muted" style="font-size: 0.75rem;">Solved: {{ $problem->solved_count ?? 0 }} • Pop: {{ $problem->popularity_percentage }}%</small>
                            </div>
                            @if($problem->problem_link)
                            <a href="{{ $problem->problem_link }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary py-1 px-2" style="font-size: 0.75rem;">Open</a>
                            @endif
                        </li>
                        @empty
                        <li class="list-group-item py-2">No problems found{{ request('search') ? ' for "' . request('search') . '"' : '' }}.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body py-3">
                    <h5 class="card-title" style="font-size: 1rem;"><i class="fas fa-star text-warning"></i> Top Rated Users</h5>
                    <p class="text-muted small mb-2">Most highly rated problem solvers.</p>
                    <ul class="list-group list-group-flush mt-2">
                        @forelse($topRatedUsers ?? [] as $user)
                        <li class="list-group-item d-flex justify-content-between align-items-start py-2 px-2">
                            <div style="min-width: 0;">
                                <div class="fw-bold text-truncate" style="font-size: 0.85rem;">{{ $user->name }}</div>
                                <small class="text-muted" style="font-size: 0.75rem;">Rating: {{ $user->cf_max_rating ?? 'N/A' }}</small>
                            </div>
                            @if(!empty($user->cf_handle))
                            <a href="https://codeforces.com/profile/{{ $user->cf_handle }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary py-1 px-2" style="font-size: 0.75rem;">Profile</a>
                            @endif
                        </li>
                        @empty
                        <li class="list-group-item py-2">No users to show.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body py-3">
                    <h5 class="card-title" style="font-size: 1rem;"><i class="fas fa-user-check text-success"></i> Top Solvers</h5>
                    <p class="text-muted small mb-2">Users with the most solved problems.</p>
                    <ul class="list-group list-group-flush mt-2">
                        @forelse($topSolvers ?? [] as $user)
                        <li class="list-group-item d-flex justify-content-between align-items-start py-2 px-2">
                            <div style="min-width: 0;">
                                <div class="fw-bold text-truncate" style="font-size: 0.85rem;">{{ $user->name }}</div>
                                <small class="text-muted" style="font-size: 0.75rem;">Solved: {{ $user->solved_problems_count ?? 0 }}</small>
                            </div>
                            @if(!empty($user->cf_handle))
                            <a href="https://codeforces.com/profile/{{ $user->cf_handle }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary py-1 px-2" style="font-size: 0.75rem;">Profile</a>
                            @endif
                        </li>
                        @empty
                        <li class="list-group-item py-2">No solvers to show.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layout>
