<x-layout>
    <x-slot:title>Tags - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-tags text-warning"></i> Problem Tags
            </h1>
            <p class="lead">Browse problems by topic and algorithm type</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-4">
                <i class="fas fa-filter"></i> Filter by Category
            </h5>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tag Name</th>
                            <th scope="col">Problems</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tags as $tag)
                            <tr>
                                <th scope="row">{{ $tag['id'] }}</th>
                                <td>
                                    <span class="badge badge-{{ $tag['color'] }} badge-lg" style="font-size: 1rem; padding: 0.5rem 1rem;">
                                        <i class="fas fa-tag"></i> {{ $tag['name'] }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted">
                                        <i class="fas fa-file-code"></i> {{ $tag['problem_count'] }} problems
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> View Problems
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-question-circle"></i> Popular Tag Categories
                </h5>
                <div class="mt-3">
                    @foreach($tags as $tag)
                        <a href="#" class="btn btn-{{ $tag['color'] }} btn-sm m-1">
                            {{ $tag['name'] }} <span class="badge badge-light">{{ $tag['problem_count'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <div class="alert alert-success" role="alert">
            <h5 class="alert-heading"><i class="fas fa-info-circle"></i> Tag Information:</h5>
            <ul class="mb-0">
                <li><strong>Math:</strong> Problems requiring mathematical reasoning and formulas</li>
                <li><strong>DP:</strong> Dynamic programming problems</li>
                <li><strong>Graphs:</strong> Graph theory and traversal problems</li>
                <li><strong>Data Structures:</strong> Problems using advanced data structures</li>
            </ul>
        </div>
    </div>
</x-layout>
