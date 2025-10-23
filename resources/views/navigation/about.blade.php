<x-layout>
    <x-slot:title>About - CodeQuest</x-slot:title>

    <div class="row mb-3">
        <div class="col-md-12">
            <h1 style="font-size: 1.8rem; font-weight: 700;">
                <i class="fas fa-info-circle" style="color: var(--info);"></i> About CodeQuest
            </h1>
            <p style="font-size: 0.95rem;">Learn more about our mission and what we offer.</p>
        </div>
    </div>
    
    <div class="card shadow-sm mb-3">
        <div class="card-body py-3">
            <h2 class="card-title" style="font-size: 1.3rem;">Our Mission</h2>
            <p class="mb-0" style="font-size: 0.9rem;">CodeQuest is dedicated to helping developers of all skill levels improve their coding abilities through curated problems, personalized recommendations, and community-driven learning.</p>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card shadow-sm h-100">
                <div class="card-body py-3">
                    <h4 style="font-size: 1rem;"><i class="fas fa-book-open text-primary"></i> Curated Library</h4>
                    <p class="mb-0" style="font-size: 0.85rem;">Hand-picked problems across topics and difficulty levels.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card shadow-sm h-100">
                <div class="card-body py-3">
                    <h4 style="font-size: 1rem;"><i class="fas fa-brain text-info"></i> Smart Recommendations</h4>
                    <p class="mb-0" style="font-size: 0.85rem;">Adaptive suggestions tailored to your progress and preferences.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card shadow-sm h-100">
                <div class="card-body py-3">
                    <h4 style="font-size: 1rem;"><i class="fas fa-users text-success"></i> Community & Editorials</h4>
                    <p class="mb-0" style="font-size: 0.85rem;">Learn from detailed editorials and peer solutions.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6 mb-3 mb-md-0">
            <div class="card shadow-sm h-100">
                <div class="card-body py-3">
                    <h3 class="card-title" style="font-size: 1.2rem;">Why CodeQuest?</h3>
                    <ul class="mb-0" style="font-size: 0.85rem; padding-left: 1.2rem;">
                        <li>Personalized learning paths.</li>
                        <li>Practical problem solving at scale.</li>
                        <li>Active community and editorials.</li>
                        <li>Real-world contest problems and learning tracks.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3 mb-md-0">
            <div class="card shadow-sm h-100">
                <div class="card-body py-3">
                    <h3 class="card-title" style="font-size: 1.2rem;">How it Works</h3>
                    <p class="mb-0" style="font-size: 0.85rem;">Practice, track progress, and discuss solutions with others. Earn badges and climb the leaderboards as you improve.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <h3 style="font-size: 1.3rem;">Featured Problems</h3>
            <div class="row">
                @forelse($featuredProblems ?? [] as $p)
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body py-3 d-flex flex-column">
                            <h5 class="card-title text-truncate" style="font-size: 0.95rem;">{{ $p->title }}</h5>
                            <p class="card-text small text-muted mb-2" style="font-size: 0.75rem;">Solved: {{ $p->solved_count ?? 0 }} • Popularity: {{ $p->popularity_percentage }}%</p>
                            @if($p->problem_link)
                            <a href="{{ $p->problem_link }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-primary mt-auto py-1" style="font-size: 0.8rem;">Open Problem</a>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <p class="text-muted">No featured problems.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <h3 style="font-size: 1.3rem;">Featured Users</h3>
            <div class="row">
                @forelse($featuredUsers ?? [] as $u)
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body py-3 d-flex flex-column">
                            <h5 class="card-title text-truncate" style="font-size: 0.95rem;">{{ $u->name }}</h5>
                            <p class="card-text small text-muted mb-2" style="font-size: 0.75rem;">Rating: {{ $u->cf_max_rating ?? 'N/A' }}</p>
                            @if(!empty($u->cf_handle))
                            <a href="https://codeforces.com/profile/{{ $u->cf_handle }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-primary mt-auto py-1" style="font-size: 0.8rem;">View Profile</a>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <p class="text-muted">No featured users.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layout>