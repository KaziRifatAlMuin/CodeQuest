@php
    $problems = $problems ?? [];
@endphp

@component('components.layout')
    @slot('title') Manage Problems - Admin @endslot

    <div class="row">
        <div class="col-12 d-flex justify-content-between align-items-center mb-3">
            <h3>Manage Problems</h3>
            <a href="{{ url('admin/problems/create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Problem
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Rating</th>
                                <th>Solved Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($problems as $problem)
                                <tr>
                                    <td>{{ $problem->problem_id }}</td>
                                    <td>{{ $problem->title ?? 'Untitled' }}</td>
                                    <td><span class="badge">{{ $problem->rating ?? '-' }}</span></td>
                                    <td>{{ $problem->solved_count ?? 0 }}</td>
                                    <td>
                                        <a href="{{ url('problems/' . $problem->problem_id) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ url('admin/problems/' . $problem->problem_id . '/edit') }}" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ url('admin/problems/' . $problem->problem_id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center p-4">No problems found. <a href="{{ url('admin/problems/create') }}">Add one now</a>.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <a href="{{ url('admin/dashboard') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

@endcomponent
