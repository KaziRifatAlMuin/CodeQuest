@php
    $editorials = $editorials ?? [];
@endphp

@component('components.layout')
    @slot('title') Manage Editorials - Admin @endslot

    <div class="row">
        <div class="col-12 d-flex justify-content-between align-items-center mb-3">
            <h3>Manage Editorials</h3>
            <a href="{{ url('admin/editorials/create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Editorial
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
                                <th>Problem ID</th>
                                <th>Author</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($editorials as $editorial)
                                <tr>
                                    <td>{{ $editorial->editorial_id }}</td>
                                    <td>{{ $editorial->title ?? 'Untitled' }}</td>
                                    <td>{{ $editorial->problem_id ?? '-' }}</td>
                                    <td>{{ $editorial->author_id ?? '-' }}</td>
                                    <td>
                                        <a href="{{ url('editorials/' . $editorial->editorial_id) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ url('admin/editorials/' . $editorial->editorial_id . '/edit') }}" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ url('admin/editorials/' . $editorial->editorial_id) }}" method="POST" style="display:inline;">
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
                                    <td colspan="5" class="text-center p-4">No editorials found. <a href="{{ url('admin/editorials/create') }}">Add one now</a>.</td>
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
