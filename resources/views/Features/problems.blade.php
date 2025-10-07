<x-layout>
    <x-slot:title>Problems - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-code text-primary"></i> Problem Set
            </h1>
            <p class="lead">Practice and improve your competitive programming skills!</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Difficulty</th>
                            <th scope="col">Rating</th>
                            <th scope="col">Solved</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($problems as $problem)
                            @php
                                $difficultyClass = match($problem['difficulty']) {
                                    'Easy' => 'success',
                                    'Medium' => 'warning',
                                    'Hard' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <tr>
                                <th scope="row">{{ $problem['id'] }}</th>
                                <td>
                                    <strong>{{ $problem['title'] }}</strong>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $difficultyClass }}">
                                        {{ $problem['difficulty'] }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-info">
                                        {{ $problem['rating'] }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="fas fa-check-circle"></i> {{ number_format($problem['solved_count']) }}
                                    </small>
                                </td>
                                <td>
                                    <a href="{{ $problem['link'] }}" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="fas fa-external-link-alt"></i> Solve
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <div class="alert alert-info" role="alert">
            <h5 class="alert-heading"><i class="fas fa-lightbulb"></i> Tips:</h5>
            <ul class="mb-0">
                <li>Start with <strong>Easy</strong> problems to build fundamentals</li>
                <li>Higher ratings indicate more challenging problems</li>
                <li>Click "Solve" to attempt the problem on Codeforces</li>
            </ul>
        </div>
    </div>
</x-layout>
