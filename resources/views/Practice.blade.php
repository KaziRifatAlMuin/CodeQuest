<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Practice Page</title>
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
                <li class="nav-item active">
                    <a class="nav-link" href="{{ url('practice') }}">Practice <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
        <h1>This is Practice Page</h1>
        <p>Welcome to the practice section of CodeQuest. Here you can find various coding problems to solve and improve your skills.</p>
        <a href="{{ url('welcome') }}" class="btn btn-primary mr-2">Welcome</a>
        <a href="{{ url('about') }}" class="btn btn-secondary mr-2">About</a>
        <a href="{{ url('contact') }}" class="btn btn-info mr-2">Contact</a>
        <a href="{{ url('/') }}" class="btn btn-success">Home</a>
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
