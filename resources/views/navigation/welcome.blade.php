<x-layout>
    <            <ul class="list-unstyled">
                <li class="mb-3"><b>🔮 Problem Recommendation</b> – Personalized recommendations based on user ratings and topic preferences.</li>
                <li class="mb-3"><b>➕ Add New Problems</b> – Users can contribute by adding new problems to the system.</li>
                <li class="mb-3"><b>✅ Track Solved Problems</b> – Users can mark problems as solved and maintain a history of progress.</li>
                <li class="mb-3"><b>🎯 Filtering Options</b> – Problems can be filtered by tags or ratings for easy discovery.</li>
                <li class="mb-3"><b>🏆 Leaderboard & Rating System</b> – Tracks user performance using a hybrid CodeQuest rating.</li>
                <li class="mb-3"><b>📝 Editorials & Voting</b> – Community-driven editorials with upvotes/downvotes for ranking best solutions.</li>
            </ul>itle>Welcome to CodeQuest</x-slot:title>

    <h1 class="display-4">Welcome to CodeQuest</h1>
    <p class="lead">Your journey to mastering coding starts here.</p>
    
    <div class="mb-4">
        <a href="{{ route('about') }}" class="btn btn-primary mr-2">About</a>
        <a href="{{ route('contact') }}" class="btn btn-secondary mr-2">Contact</a>
        <a href="{{ route('practice') }}" class="btn btn-success mr-2">Practice</a>
        <a href="{{ route('home') }}" class="btn btn-info">Home</a>
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