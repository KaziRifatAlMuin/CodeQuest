<x-layout>
    <x-slot:title>Problems - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-code" style="color: var(--primary);"></i> Problem Set
            </h1>
            <p class="lead">Practice and improve your competitive programming skills!</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Difficulty</th>
                            <th>Rating</th>
                            <th>Solved</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($problems as $problem)
                            @php
                                $difficultyClass = \App\Helpers\DifficultyHelper::getDifficultyClass($problem['difficulty']);
                                $rating = (int) ($problem['rating'] ?? 0);
                                $ratingBgClass = \App\Helpers\RatingHelper::getRatingBgClass($rating);
                            @endphp
                            <tr>
                                <td>{{ $problem['id'] }}</td>
                                <td><b>{{ $problem['title'] }}</b></td>
                                <td>
                                    <span class="badge {{ $difficultyClass }}">
                                        {{ $problem['difficulty'] }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $ratingBgClass }}">
                                        {{ $problem['rating'] }}
                                    </span>
                                </td>
                                <td>{{ number_format($problem['solved_count']) }}</td>
                                <td>
                                    <a href="{{ $problem['link'] }}" target="_blank" class="btn btn-sm btn-primary">
                                        Solve
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>
