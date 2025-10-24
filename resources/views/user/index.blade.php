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
            <button type="button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Search and Pagination Controls -->
    @include('components.search-pagination', ['paginator' => $users])

    <div class="card shadow-sm">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <!-- Sorting form -->
                    <form method="GET" class="d-flex align-items-center" id="sortForm">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="per_page" value="{{ request('per_page', 25) }}">
                        <label class="me-2 mb-0 text-muted">Sort by</label>
                        <select name="sort" class="form-select form-select-sm me-2" style="width: 180px;" onchange="document.getElementById('sortForm').submit();">
                            <option value="created" {{ (isset($sort) && $sort === 'created') ? 'selected' : '' }}>Registration Date</option>
                            <option value="name" {{ (isset($sort) && $sort === 'name') ? 'selected' : '' }}>Name</option>
                            <option value="rating" {{ (isset($sort) && $sort === 'rating') ? 'selected' : '' }}>CF Max Rating</option>
                            <option value="solved" {{ (isset($sort) && $sort === 'solved') ? 'selected' : '' }}>Total Solved</option>
                        </select>

                        <select name="direction" class="form-select form-select-sm" style="width: 140px;" onchange="document.getElementById('sortForm').submit();">
                            <option value="desc" {{ (isset($direction) && $direction === 'desc') ? 'selected' : '' }}>Descending</option>
                            <option value="asc" {{ (isset($direction) && $direction === 'asc') ? 'selected' : '' }}>Ascending</option>
                        </select>
                    </form>
                </div>
                <div>
                    <small class="text-muted">Showing {{ $users->total() }} users</small>
                </div>
            </div>
            <x-table :headers="['Name', 'Email', 'CF Handle', 'Total Solved', 'CF Max Rating', 'University']" :paginator="$users">
                @forelse($users as $user)
                @php
                    $search = request('search', '');
                @endphp
                <tr onclick="window.location='{{ route('user.show', $user) }}'">
                    <td>
                        <a href="{{ route('user.show', $user) }}" style="text-decoration: none; color: var(--primary); font-weight: 600;">
                            {!! \App\Helpers\SearchHelper::highlight($user->name, $search) !!}
                        </a>
                    </td>
                    <td>{!! \App\Helpers\SearchHelper::highlight($user->email, $search) !!}</td>
                    <td>
                        @if($user->cf_handle)
                            <a href="https://codeforces.com/profile/{{ $user->cf_handle }}" target="_blank" style="text-decoration: none; color: {{ \App\Helpers\RatingHelper::getRatingColor((int)($user->cf_max_rating ?? 0)) }}; font-weight: 600;">
                                {!! \App\Helpers\SearchHelper::highlight($user->cf_handle, $search) !!}
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
                        <p class="text-muted mb-0">No users found{{ request('search') ? ' for "' . request('search') . '"' : '' }}</p>
                    </td>
                </tr>
                @endforelse
            </x-table>
        </div>
    </div>

    @auth
        @if(in_array(auth()->user()->role, ['moderator', 'admin']))
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <a href="{{ route('user.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New User
                    </a>
                </div>
            </div>
        @endif
    @endauth
</x-layout>
