@php
    $users = $users ?? [];
@endphp

@component('components.layout')
    @slot('title') Manage Users - Admin @endslot

    <div class="row">
        <div class="col-12 d-flex justify-content-between align-items-center mb-3">
            <h3>Manage Users</h3>
            <a href="{{ url('admin/users/create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New User
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
                                <th>Email</th>
                                <th>Rating</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->id ?? $user['id'] ?? '-' }}</td>
                                    <td>{{ $user->name ?? $user['name'] ?? 'Unknown' }}</td>
                                    <td>{{ $user->email ?? $user['email'] ?? '-' }}</td>
                                    <td>{{ $user->rating ?? $user['rating'] ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ ($user->role ?? $user['role'] ?? '') == 'admin' ? 'badge-danger' : 'badge-secondary' }}">
                                            {{ ucfirst($user->role ?? $user['role'] ?? 'user') }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ url('users/' . ($user->id ?? $user['id'] ?? '#')) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ url('admin/users/' . ($user->id ?? $user['id'] ?? '#') . '/edit') }}" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ url('admin/users/' . ($user->id ?? $user['id'] ?? '#')) }}" method="POST" style="display:inline;">
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
                                    <td colspan="6" class="text-center p-4">No users found.</td>
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
