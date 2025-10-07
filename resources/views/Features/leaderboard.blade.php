<x-layout>
    <x-slot:title>Leaderboard - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-trophy text-warning"></i> Leaderboard
            </h1>
            <p class="lead">Check out the top performers on CodeQuest!</p>
        </div>
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
