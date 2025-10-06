<x-layout>
    <x-slot:title>About - CodeQuest</x-slot:title>

    <h1 class="display-4">About CodeQuest</h1>
    <p class="lead">Learn more about our mission and what we offer.</p>
    
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h2 class="card-title">Our Mission</h2>
            <p>CodeQuest is dedicated to helping developers of all skill levels improve their coding abilities through curated problems, personalized recommendations, and community-driven learning.</p>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h2 class="card-title">What We Offer</h2>
            <ul class="list-unstyled">
                <li class="mb-2">✅ Comprehensive problem library</li>
                <li class="mb-2">✅ Smart recommendation system</li>
                <li class="mb-2">✅ Progress tracking</li>
                <li class="mb-2">✅ Community editorials</li>
                <li class="mb-2">✅ Competitive leaderboards</li>
            </ul>
        </div>
    </div>

    <div class="mb-4">
        <a href="{{ url('welcome') }}" class="btn btn-primary mr-2">Welcome</a>
        <a href="{{ url('contact') }}" class="btn btn-secondary mr-2">Contact</a>
        <a href="{{ url('practice') }}" class="btn btn-success mr-2">Practice</a>
        <a href="{{ url('/') }}" class="btn btn-info">Home</a>
    </div>
</x-layout>