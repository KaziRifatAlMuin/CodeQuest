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
            <a class="btn btn-primary btn-lg mr-2 mb-2 cta-btn" href="{{ url('/problems') }}" role="button">
                <i class="fas fa-play"></i> Get Started
            </a>
            <a class="btn btn-success btn-lg mb-2 cta-btn" href="{{ url('/leaderboard') }}" role="button">
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
</x-layout>