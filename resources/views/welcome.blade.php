<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to CodeQuest</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ url('/') }}">CodeQuest</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('about') }}">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('contact') }}">Contact</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ url('welcome') }}">Welcome <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('practice') }}">Practice</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
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
    </div>

    <footer class="bg-light text-center text-lg-start mt-auto">
        <div class="text-center p-3">
            &copy; 2024 CodeQuest. All rights reserved.
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>