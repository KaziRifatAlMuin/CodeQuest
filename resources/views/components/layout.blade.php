<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'CodeQuest' }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand font-weight-bold" href="{{ url('/') }}">
            <span class="text-primary">Code</span><span class="text-warning">Quest</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item {{ request()->is('/') || request()->is('home') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/') }}">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="nav-item {{ request()->is('about') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('about') }}">
                        <i class="fas fa-info-circle"></i> About
                    </a>
                </li>
                <li class="nav-item {{ request()->is('contact') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('contact') }}">
                        <i class="fas fa-envelope"></i> Contact
                    </a>
                </li>
                <li class="nav-item {{ request()->is('problems*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('problems') }}">
                        <i class="fas fa-code"></i> Problems
                    </a>
                </li>
                <li class="nav-item {{ request()->is('leaderboard') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('leaderboard') }}">
                        <i class="fas fa-trophy"></i> Leaderboard
                    </a>
                </li>
                <li class="nav-item {{ request()->is('users*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('users') }}">
                        <i class="fas fa-users"></i> Users
                    </a>
                </li>
                <li class="nav-item {{ request()->is('tags*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('tags') }}">
                        <i class="fas fa-tags"></i> Tags
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        {{ $slot }}
    </div>

    <footer class="bg-dark text-white text-center text-lg-start mt-auto">
        <div class="text-center p-3">
            Copyright &copy; 2025 CodeQuest | Developed by Kazi Rifat Al Muin. All rights reserved.
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>