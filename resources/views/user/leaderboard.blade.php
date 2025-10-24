<x-layout>
    <x-slot:title>Leaderboard - CodeQuest</x-slot:title>

    <div class="container-fluid py-5" style="max-width: 1200px;">
        <!-- Page Header -->
        <div class="mb-5">
            <h1 class="display-5 fw-bold mb-2">
                <i class="fas fa-trophy text-warning me-3"></i>Leaderboard
            </h1>
            <p class="text-muted mb-0">Rankings based on Codeforces maximum rating</p>
        </div>

        <!-- Search and Pagination Controls -->
        @include('components.search-pagination', ['paginator' => $users])

        <!-- Leaderboard Table using component -->
        <x-table :headers="['Rank', 'Name', 'CF Handle', 'MAX CF Rating', 'Total Solved', 'Avg Rating']" :paginator="$users">
            @forelse($users as $index => $user)
                @php
                    $rating = (int) ($user->cf_max_rating ?? 0);
                    $themeColor = \App\Helpers\RatingHelper::getRatingColor($rating);
                    $themeName = \App\Helpers\RatingHelper::getRatingTitle($rating);
                    $search = request('search', '');
                    // Use actual_rank if available, otherwise calculate from firstItem
                    $displayRank = $user->actual_rank ?? ($users->firstItem() + $index);
                @endphp
                <tr style="border-bottom: 1px solid #f0f0f0;">
                    <td class="fw-bold text-center" style="color: {{ $themeColor }}; font-size: 1rem; width: 8%;">
                        #{!! \App\Helpers\SearchHelper::highlight($displayRank, $search) !!}
                    </td>
                    <td style="width: 25%;">
                        <div class="d-flex align-items-center">
                            @if($user->profile_picture)
                                <img src="{{ asset('images/profile/' . $user->profile_picture) }}" 
                                     alt="{{ $user->name }}" 
                                     class="rounded-circle me-3" 
                                     style="width: 40px; height: 40px; object-fit: cover; border: 2px solid {{ $themeColor }};">
                            @else
                                <div class="rounded-circle me-3 d-flex align-items-center justify-content-center" 
                                     style="width: 40px; height: 40px; background: #f0f0f0; border: 2px solid {{ $themeColor }};">
                                    <i class="fas fa-user text-secondary"></i>
                                </div>
                            @endif
                            <span class="fw-500">{!! \App\Helpers\SearchHelper::highlight($user->name, $search) !!}</span>
                        </div>
                    </td>
                    <td style="width: 20%;">
                        <span style="color: {{ $themeColor }}; font-weight: 600;">
                            @if($user->cf_handle)
                                {!! \App\Helpers\SearchHelper::highlight($user->cf_handle, $search) !!}
                            @else
                                —
                            @endif
                        </span>
                        @if($user->cf_handle && $user->handle_verified_at)
                            <i class="fas fa-check-circle text-success ms-2" style="font-size: 0.85rem;" title="Verified"></i>
                        @endif
                    </td>
                    <td class="text-center" style="width: 15%;">
                        <span class="badge" style="background: {{ $themeColor }}; font-size: 0.8rem; padding: 0.5rem 0.8rem;">
                            {{ number_format($rating) }}
                        </span>
                        <br>
                        <small class="text-muted d-block mt-1" style="font-size: 0.8rem;">{{ $themeName }}</small>
                    </td>
                    <td class="text-center" style="width: 16%;">
                        <span style="font-size: 0.8rem; padding: 0.5rem 0.8rem;">
                            {{ $user->solved_problems_count ?? 0 }}
                        </span>
                    </td>
                    <td class="text-center" style="width: 16%;">
                        <span style="font-size: 0.8rem; padding: 0.5rem 0.8rem;">
                            {{ number_format($user->average_problem_rating ?? 0, 0) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <i class="fas fa-inbox text-muted" style="font-size: 2.5rem; display: block; margin-bottom: 1rem;"></i>
                        <p class="text-muted mb-0">No users found{{ request('search') ? ' for "' . request('search') . '"' : '' }}</p>
                    </td>
                </tr>
            @endforelse
        </x-table>
    </div>

    <style>
        /* Modern minimalistic styling override */
        .table {
            font-size: 0.95rem;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead {
            background-color: #f8f9fa;
            border-bottom: 2px solid #e9ecef;
        }

        .table thead th {
            font-weight: 600;
            color: #495057;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 1rem;
            border: none;
        }

        .table tbody tr {
            transition: background-color 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa !important;
            box-shadow: none !important;
            transform: none !important;
        }

        .badge {
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        .fw-500 {
            font-weight: 500;
        }
    </style>
</x-layout>
