<x-layout>
    <x-slot:title>Welcome to CodeQuest</x-slot:title>

    <h1 class="display-4">Welcome to CodeQuest</h1>
    <p class="lead">Your journey to mastering coding starts here.</p>
    
    <div class="mb-4">
        <a href="{{ url('about') }}" class="btn btn-primary mr-2">About</a>
        <a href="{{ url('contact') }}" class="btn btn-secondary mr-2">Contact</a>
        <a href="{{ url('practice') }}" class="btn btn-success mr-2">Practice</a>
        <a href="{{ url('/') }}" class="btn btn-info">Home</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="card-title">📌 Our Features</h2>
            <ul class="list-unstyled mt-3">
                <li class="mb-3"><strong>🔮 Problem Recommendation</strong> – Personalized recommendations based on user ratings and topic preferences.</li>
                <li class="mb-3"><strong>➕ Add New Problems</strong> – Users can contribute by adding new problems to the system.</li>
                <li class="mb-3"><strong>✅ Track Solved Problems</strong> – Users can mark problems as solved and maintain a history of progress.</li>
                <li class="mb-3"><strong>🎯 Filtering Options</strong> – Problems can be filtered by tags or ratings for easy discovery.</li>
                <li class="mb-3"><strong>🏆 Leaderboard & Rating System</strong> – Tracks user performance using a hybrid CodeQuest rating.</li>
                <li class="mb-3"><strong>📝 Editorials & Voting</strong> – Community-driven editorials with upvotes/downvotes for ranking best solutions.</li>
            </ul>
        </div>
    </div>
</x-layout>