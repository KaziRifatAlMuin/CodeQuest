<x-layout>
    <x-slot:title>Tags - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-tags" style="color: var(--warning);"></i> Problem Tags
            </h1>
            <p class="lead">Browse problems by topic and algorithm type</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Filter by Category</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tag Name</th>
                            <th>Problems</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tags as $tag)
                            <tr>
                                <td>{{ $tag['id'] }}</td>
                                <td>
                                    <span class="badge rating-bg-specialist">
                                        {{ $tag['name'] }}
                                    </span>
                                </td>
                                <td>{{ $tag['problem_count'] }} problems</td>
                                <td>
                                    <button class="btn btn-sm btn-primary">
                                        View Problems
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
                <h5 class="card-title">Popular Tag Categories</h5>
                <div class="mt-3">
                    @foreach($tags as $tag)
                        <a href="#" class="badge rating-bg-specialist m-1" style="font-size: 0.85rem; padding: 0.5rem 0.85rem; text-decoration: none;">
                            {{ $tag['name'] }} <span style="opacity: 0.8; margin-left: 0.3rem;">({{ $tag['problem_count'] }})</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layout>
