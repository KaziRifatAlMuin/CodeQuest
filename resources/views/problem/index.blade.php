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
                        <x-table :headers="['ID', 'Title', 'Rating', 'Solved', 'Stars', 'Popularity', 'Actions']">
                            @foreach ($problems as $problem)
                                @php
                                    $rating = (int) ($problem->rating ?? 0);
                                    $ratingColor = \App\Helpers\RatingHelper::getRatingColor($rating);
                                @endphp
                                <tr onclick="window.location='{{ route('problems.details', $problem->problem_id) }}'">
                                    <td>{{ $problem->problem_id }}</td>
                                    <td><b>{{ $problem->title }}</b></td>
                                    <td>
                                        <span class="badge" style="background: {{ $ratingColor }}; color: white;">
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
                        </x-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>