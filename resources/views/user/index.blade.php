<x-layout>
    <x-slot:title>Users - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-users" style="color: var(--primary);"></i> Users
            </h1>
            <p class="lead">Browse and manage all registered users</p>
        </div>
    </div>

    <!-- Success Message -->
    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <x-table :headers="['Name', 'Email', 'CF Handle', 'Total Solved', 'CF Max Rating', 'University']" :paginator="$users">
                @forelse($users as $user)
                <tr onclick="window.location='{{ route('users.show', $user) }}'">
                    <td>
                        <a href="{{ route('users.show', $user) }}" style="text-decoration: none; color: var(--primary); font-weight: 600;">
                            {{ $user->name }}
                        </a>
                    </td>
                    <td>{{ $user->email }}</td>
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
                    <td>{{ $user->university ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center p-4">
                        <i class="fas fa-inbox" style="font-size: 2rem; color: var(--text-light); margin-right: 10px;"></i>
                        <p class="text-muted mb-0">No users found</p>
                    </td>
                </tr>
                @endforelse
            </x-table>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <div>
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New User
            </a>
        </div>
    </div>
</x-layout>