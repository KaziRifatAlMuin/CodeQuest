@php
    $tags = $tags ?? [];
@endphp

@component('components.layout')
    @slot('title') Manage Tags - Admin @endslot

    <div class="row">
        <div class="col-12 d-flex justify-content-between align-items-center mb-3">
            <h3>Manage Tags</h3>
            <a href="{{ url('admin/tags/create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Tag
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
                                <th>Name</th>
                                <th>Description</th>
                                <th>Problems Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tags as $tag)
                                <tr>
                                    <td>{{ $tag->tag_id }}</td>
                                    <td>
                                        <span class="badge">{{ $tag->tag_name ?? 'Unnamed' }}</span>
                                    </td>
                                    <td>{{ Str::limit($tag->description ?? '-', 50) }}</td>
                                    <td>{{ $tag->problems_count ?? 0 }}</td>
                                    <td>
                                        <a href="{{ url('tags/' . $tag->tag_id) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ url('admin/tags/' . $tag->tag_id . '/edit') }}" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ url('admin/tags/' . $tag->tag_id) }}" method="POST" style="display:inline;">
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
                                    <td colspan="5" class="text-center p-4">No tags found. <a href="{{ url('admin/tags/create') }}">Add one now</a>.</td>
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
