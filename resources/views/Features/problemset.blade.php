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
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($problems as $problem)
                                        @php
                                            $rating = (int) ($problem->rating ?? 0);
                                            $ratingBgClass = \App\Helpers\RatingHelper::getRatingBgClass($rating);
                                        @endphp
                                        <tr>
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
                                            <td>
                                                <a href="{{ $problem->problem_link }}" target="_blank" class="btn btn-sm btn-primary mr-1">
                                                    <i class="fas fa-external-link-alt"></i> Solve
                                                </a>
                                                <a href="{{ route('problem.details', $problem->problem_id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> View
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