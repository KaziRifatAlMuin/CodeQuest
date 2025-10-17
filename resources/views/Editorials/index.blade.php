<x-layout>
    <x-slot:title>Editorials - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-book" style="color: var(--purple);"></i> Editorials
            </h1>
            <p class="lead">Browse community-contributed problem editorials and solutions</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Problem</th>
                            <th>Author</th>
                            <th>Language</th>
                            <th>Votes</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($editorials as $editorial)
                            <tr style="cursor: pointer;" onclick="window.location='{{ route('editorials.details', $editorial->editorial_id) }}'">
                                <td>{{ $editorial->editorial_id }}</td>
                                <td>
                                    <b>{{ $editorial->problem_title }}</b>
                                    <br>
                                    <small class="text-muted">Problem ID: {{ $editorial->problem_id }}</small>
                                </td>
                                <td>{{ $editorial->author_name }}</td>
                                <td>
                                    <span class="badge badge-secondary">{{ strtoupper($editorial->language ?? 'N/A') }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-success">
                                        <i class="fas fa-thumbs-up"></i> {{ $editorial->upvotes ?? 0 }}
                                    </span>
                                    <span class="badge badge-danger">
                                        <i class="fas fa-thumbs-down"></i> {{ $editorial->downvotes ?? 0 }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($editorial->created_at)->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    No editorials found. Be the first to contribute!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>
