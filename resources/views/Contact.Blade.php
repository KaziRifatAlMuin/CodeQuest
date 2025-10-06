<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact - CodeQuest</title>
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
                <li class="nav-item active">
                    <a class="nav-link" href="{{ url('contact') }}">Contact <span class="sr-only">(current)</span></a>
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
        <h1 class="display-4">Contact Us</h1>
        <p class="lead">Get in touch with the CodeQuest team.</p>
        
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="card-title">Contact Information</h2>
                <ul class="list-unstyled mt-3">
                    <li class="mb-3"><strong>📧 Email:</strong> support@codequest.com</li>
                    <li class="mb-3"><strong>💬 Discord:</strong> discord.gg/codequest</li>
                    <li class="mb-3"><strong>🐦 Twitter:</strong> @codequestapp</li>
                    <li class="mb-3"><strong>💼 GitHub:</strong> github.com/codequest</li>
                </ul>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2 class="card-title">Send Us a Message</h2>
                <form>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Your name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="your.email@example.com">
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" id="message" rows="4" placeholder="Your message..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>

        <div class="mb-4">
            <a href="{{ url('about') }}" class="btn btn-secondary mr-2">About</a>
            <a href="{{ url('welcome') }}" class="btn btn-primary mr-2">Welcome</a>
            <a href="{{ url('practice') }}" class="btn btn-success mr-2">Practice</a>
            <a href="{{ url('/') }}" class="btn btn-info">Home</a>
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
<!DOCTYPE html>
