<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home - CodeQuest</title>
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
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('welcome') }}">Welcome</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('practice') }}">Practice</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="jumbotron text-center">
            <h1 class="display-3">CodeQuest</h1>
            <p class="lead">Master coding through intelligent practice and community-driven learning</p>
            <hr class="my-4">
            <p>Start your journey today and level up your programming skills.</p>
            <a class="btn btn-primary btn-lg mr-2" href="{{ url('welcome') }}" role="button">Get Started</a>
            <a class="btn btn-success btn-lg" href="{{ url('practice') }}" role="button">Start Practicing</a>
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