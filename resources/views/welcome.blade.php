<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>CodeQuest</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body { background:#f8f9fa; color:#212529; }
        .hero { padding: 36px 0; }
        .card + .card { margin-top: 16px; }
        .muted { color:#6c757d; }
        .brand-highlight {
            display:inline-block;
            padding:6px 12px;
            border-radius:999px;
            background: linear-gradient(90deg,#4f46e5,#7c3aed);
            color: #fff;
            font-weight:700;
            box-shadow: 0 6px 18px rgba(124,58,237,0.16);
            margin-right:8px;
            font-size:1rem;
            vertical-align:middle;
        }
        .hero-card { background: #ffffffcc; border: 0; box-shadow: 0 8px 30px rgba(18,23,38,0.06); border-radius:14px; padding:24px; }
        .feature-card { border:0; border-radius:10px; box-shadow: 0 6px 18px rgba(17,24,39,0.06); transition: transform .12s ease, box-shadow .12s ease; }
        .feature-card:hover { transform: translateY(-4px); box-shadow: 0 10px 28px rgba(17,24,39,0.10); }
        .feature-icon { font-size:1.35rem; width:44px; height:44px; display:flex; align-items:center; justify-content:center; border-radius:8px; background:#f1f5f9; margin-right:12px; }
        .feature-title { margin-bottom:0; font-weight:600; }
        .feature-desc { margin-bottom:0; color:#6b7280; font-size:.92rem; }
    </style>
</head>
<body>
<nav class="navbar navbar-light bg-white border-bottom">
    <div class="container">
        <div class="d-flex align-items-center">
            <span class="brand-highlight">CodeQuest</span>
            <div>
                <div class="h5 mb-0">Problem Recommendation System</div>
                <div class="muted small">discover • solve • contribute</div>
            </div>
        </div>

        <div>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-sm btn-outline-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary mr-2">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-sm btn-primary">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</nav>

<main class="container hero">
    <div class="row mb-4">
        <div class="col-12">
            <div class="hero-card">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="display-5 mb-1">
                            <span class="brand-highlight">CodeQuest</span>
                            <small class="text-muted" style="font-size:0.6em; vertical-align:middle;">— Problem Recommendation System</small>
                        </h1>
                        <p class="lead muted mb-0">Personalized recommendations, progress tracking, leaderboards and community editorials. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left column: description + features grid -->
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">What is CodeQuest?</h5>
                    <p class="card-text">CodeQuest helps users discover, solve, and contribute programming problems. It provides personalized recommendations, progress tracking, leaderboards, and community editorials.</p>
                </div>
            </div>

            <div class="mb-3">
                <h5 class="mb-3">Key Features</h5>

                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <div class="card feature-card p-3 h-100">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon">🔮</div>
                                <div>
                                    <p class="feature-title">Personalized Recommendations</p>
                                    <p class="feature-desc">Receive problems tailored to your skill and history.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="card feature-card p-3 h-100">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon">➕</div>
                                <div>
                                    <p class="feature-title">Add & Curate Problems</p>
                                    <p class="feature-desc">Contribute problems and improve the dataset for everyone.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="card feature-card p-3 h-100">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon">✅</div>
                                <div>
                                    <p class="feature-title">Progress Tracking</p>
                                    <p class="feature-desc">Track solved problems, streaks and progress over time.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="card feature-card p-3 h-100">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon">🏷️</div>
                                <div>
                                    <p class="feature-title">Tags & Filtering</p>
                                    <p class="feature-desc">Filter problems by tags, difficulty and topics.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="card feature-card p-3 h-100">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon">🏆</div>
                                <div>
                                    <p class="feature-title">Leaderboards</p>
                                    <p class="feature-desc">Compete with others and earn rankings and badges.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="card feature-card p-3 h-100">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon">📝</div>
                                <div>
                                    <p class="feature-title">Editorials & Voting</p>
                                    <p class="feature-desc">Publish editorials for problems and allow community upvotes.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- Right column: next steps only -->
        <aside class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">View Website</h5>
                    <a href="{{ url('/') }}"> Home </a><br>
                    <a href="{{ url('about') }}"> About </a> <br>
                    <a href="{{ url('contact') }}"> Contact </a> <br>
                </div>
            </div>
        </aside>
    </div>

    <footer class="mt-4 text-muted small text-center">
        CodeQuest — Problem Recommendation System.
    </footer>

</main>

</body>
</html>