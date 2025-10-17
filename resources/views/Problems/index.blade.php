<x-layout>
    <x-slot name="title">
        Problem Set
    </x-slot>

    <x-slot name="header">
        Problem Set
    </x-slot>


    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">All Problems</h5>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Rating</th>
                                        <th>Solved</th>
                                        <th>Stars</th>
                                        <th>Popularity</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($problems as $problem)
                                        @php
                                            $rating = (int) ($problem->rating ?? 0);
                                            $ratingBgClass = \App\Helpers\RatingHelper::getRatingBgClass($rating);
                                        @endphp
                                        <tr style="cursor: pointer;" onclick="window.location='{{ route('problems.details', $problem->problem_id) }}'">
                                            <td>{{ $problem->problem_id }}</td>
                                            <td><b>{{ $problem->title }}</b></td>
                                            <td>
                                                <span class="badge {{ $ratingBgClass }}">
                                                    {{ $problem->rating }}
                                                </span>
                                            </td>
                                            <td>{{ number_format($problem->solved_count) }}</td>
                                            <td>{{ $problem->stars }}</td>
                                            <td>{{ $problem->popularity }}</td>
                                            <td onclick="event.stopPropagation();">
                                                <a href="{{ $problem->problem_link }}" target="_blank" class="btn btn-sm btn-primary">
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
            </div>
        </div>
    </div>
</x-layout>