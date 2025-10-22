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
                    <x-table :headers="['Name', 'Email', 'CF Handle', 'Total Solved', 'CF Max Rating', 'Role', 'Actions']">
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->name ?? 'Unknown' }}</td>
                                <td>{{ $user->email ?? '-' }}</td>
                                <td>
                                    @if($user->cf_handle)
                                        <a href="https://codeforces.com/profile/{{ $user->cf_handle }}" target="_blank" style="text-decoration: none; color: {{ \App\Helpers\RatingHelper::getRatingColor((int)($user->cf_max_rating ?? 0)) }}; font-weight: 600;">
                                            {{ $user->cf_handle }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ number_format($user->solved_problems_count ?? 0) }}</td>
                                <td>
                                    @php
                                        $rating = (int) ($user->cf_max_rating ?? 0);
                                        $ratingColor = \App\Helpers\RatingHelper::getRatingColor($rating);
                                    @endphp
                                    <span class="badge" style="background: {{ $ratingColor }}; color: white;">{{ $rating }}</span>
                                </td>
                                <td>
                                    <span class="badge {{ ($user->role ?? '') == 'admin' ? 'bg-danger' : 'bg-secondary' }}">
                                        {{ ucfirst($user->role ?? 'user') }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('users.show', $user->user_id) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('users.edit', $user->user_id) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user->user_id) }}" method="POST" style="display:inline;">
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
                    </x-table>
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
