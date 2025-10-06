<x-layout>
    <x-slot:title>Leaderboard - CodeQuest</x-slot:title>

    <h1 class="display-4">Leaderboard</h1>
    <p class="lead">Check out the top performers on CodeQuest!</p>

    <div class="mb-4">
        <a href="{{ url('welcome') }}" class="btn btn-primary mr-2">Welcome</a>
        <a href="{{ url('about') }}" class="btn btn-secondary mr-2">About</a>
        <a href="{{ url('contact') }}" class="btn btn-info mr-2">Contact</a>
        <a href="{{ url('practice') }}" class="btn btn-success mr-2">Practice</a>
        <a href="{{ url('/') }}" class="btn btn-dark">Home</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="card-title">🏆 Top Coders</h2>

            <ul class="list-group mt-3">
                @foreach($persons as $person)
                    @php
                        $r = (int) ($person['rating'] ?? 0);

                        // Codeforces-like color mapping (approximate)
                        if ($r >= 2400) {
                            $color = '#ff3b30';   // red
                            $label = 'Grandmaster+';
                        } elseif ($r >= 2100) {
                            $color = '#ff8c00';   // orange
                            $label = 'Master';
                        } elseif ($r >= 1900) {
                            $color = '#9b59b6';   // violet
                            $label = 'Candidate Master';
                        } elseif ($r >= 1600) {
                            $color = '#3498db';   // blue
                            $label = 'Expert';
                        } elseif ($r >= 1400) {
                            $color = '#1abc9c';   // cyan
                            $label = 'Specialist';
                        } elseif ($r >= 1200) {
                            $color = '#2ecc71';   // green
                            $label = 'Pupil';
                        } else {
                            $color = '#95a5a6';   // gray
                            $label = 'Newbie';
                        }
                    @endphp

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <span style="width:12px;height:12px;border-radius:50%;background:{{ $color }};display:inline-block;margin-right:12px;"></span>
                            <div>
                                <strong>{{ $person['name'] }}</strong>
                                <div class="text-muted small">{{ $label }} · id: {{ $person['id'] ?? '—' }}</div>
                            </div>
                        </div>

                        <span class="badge badge-pill" style="background:{{ $color }};color:#fff;">
                            {{ $person['rating'] }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-layout>
