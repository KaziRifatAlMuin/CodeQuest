<x-layout>
    <x-slot:title>About - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-info-circle" style="color: var(--info);"></i> About CodeQuest
            </h1>
            <p class="lead">Learn more about our mission and what we offer.</p>
        </div>
    </div>
    
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h2 class="card-title">Our Mission</h2>
            <p>CodeQuest is dedicated to helping developers of all skill levels improve their coding abilities through curated problems, personalized recommendations, and community-driven learning.</p>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h4><i class="fas fa-book-open text-primary"></i> Curated Library</h4>
                    <p class="mb-0">Hand-picked problems across topics and difficulty levels.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h4><i class="fas fa-brain text-info"></i> Smart Recommendations</h4>
                    <p class="mb-0">Adaptive suggestions tailored to your progress and preferences.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h4><i class="fas fa-users text-success"></i> Community & Editorials</h4>
                    <p class="mb-0">Learn from detailed editorials and peer solutions.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title">Why CodeQuest?</h3>
                    <ul>
                        <li>Personalized learning paths.</li>
                        <li>Practical problem solving at scale.</li>
                        <li>Active community and editorials.</li>
                        <li>Real-world contest problems and learning tracks.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title">How it Works</h3>
                    <p>Practice, track progress, and discuss solutions with others. Earn badges and climb the leaderboards as you improve.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <h3>Featured Problems</h3>
            <div class="row">
                @forelse($featuredProblems ?? [] as $p)
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $p->title }}</h5>
                                                        <p class="card-text small text-muted">Solved: {{ $p->solved_count ?? 0 }} • Popularity: {{ $p->popularity_percentage }}%</p>
                        </div>
                            @if($p->problem_link)
                            <a href="{{ $p->problem_link }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-primary">Open Problem</a>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">No featured problems.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <h3>Featured Users</h3>
            <div class="row">
                @forelse($featuredUsers ?? [] as $u)
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $u->name }}</h5>
                            <p class="card-text small text-muted">Rating: {{ $u->cf_max_rating ?? 'N/A' }}</p>
                            @if(!empty($u->cf_handle))
                            <a href="https://codeforces.com/profile/{{ $u->cf_handle }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-primary">View Profile</a>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">No featured users.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-layout>