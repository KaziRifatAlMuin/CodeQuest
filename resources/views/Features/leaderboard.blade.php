<x-layout>
    <x-slot:title>Leaderboard - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-trophy" style="color: var(--warning);"></i> Leaderboard
            </h1>
            <p class="lead">Check out the top performers on CodeQuest!</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Top Coders</h3>
            <ul class="list-group mt-3">
                @foreach($persons as $index => $person)
                    @php
                        $r = (int) ($person['rating'] ?? 0);
                        $ratingColor = \App\Helpers\RatingHelper::getRatingColor($r);
                        $ratingTitle = \App\Helpers\RatingHelper::getRatingTitle($r);
                        $ratingDotClass = \App\Helpers\RatingHelper::getRatingDotClass($r);
                    @endphp

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <span class="rating-dot {{ $ratingDotClass }}"></span>
                            <div>
                                <b>{{ $person['name'] }}</b>
                                <div class="text-muted small">{{ $ratingTitle }} · ID: {{ $person['id'] ?? '—' }}</div>
                            </div>
                        </div>
                        <span class="badge badge-pill" style="background:{{ $ratingColor }};color:#fff;">
                            {{ $person['rating'] }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-layout>
