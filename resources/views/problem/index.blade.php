<x-layout>
    <x-slot:title>Problems - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-code" style="color: var(--primary);"></i> Problems
            </h1>
            <p class="lead">Browse and solve competitive programming problems</p>
        </div>
    </div>

    <!-- Success Message -->
    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filters -->
    <x-problem-filters :tags="$tags" :selectedTags="$selectedTags" :showStarred="$showStarred" />

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <x-table :headers="['Title', 'Rating', 'Tags', 'Solved', 'Stars', 'Popularity', 'Link']" :paginator="$problems">
                @forelse($problems as $problem)
                    @php
                        $rating = (int) ($problem->rating ?? 0);
                        $ratingColor = \App\Helpers\RatingHelper::getRatingColor($rating);
                    @endphp
                    <tr onclick="window.location='{{ route('problem.show', $problem) }}'">
                        <td>
                            <a href="{{ route('problem.show', $problem) }}" style="text-decoration: none; color: var(--primary); font-weight: 600;">
                                {{ $problem->title }}
                            </a>
                        </td>
                        <td>
                            <span class="badge" style="background: {{ $ratingColor }}; color: white;">{{ $rating }}</span>
                        </td>
                        <td>
                            @if($problem->tags->count() > 0)
                                @foreach($problem->tags as $tag)
                                    <x-tag-badge :tagName="$tag->tag_name" :tagId="$tag->tag_id" />
                                @endforeach
                            @else
                                <span class="text-muted" style="font-size: 0.85rem;">No tags</span>
                            @endif
                        </td>
                        <td>{{ number_format($problem->solved_count ?? 0) }}</td>
                        <td>{{ number_format($problem->stars ?? 0) }}</td>
                                                <td>{{ $problem->popularity_percentage }}%</td>
                        <td>
                        <td onclick="event.stopPropagation();">
                            <a href="{{ $problem->problem_link }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fas fa-external-link-alt"></i> Solve
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center p-4">
                            <i class="fas fa-inbox" style="font-size: 2rem; color: var(--text-light); margin-right: 10px;"></i>
                            <p class="text-muted mb-0">No problems found</p>
                        </td>
                    </tr>
                @endforelse
            </x-table>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <div>
            <a href="{{ route('problem.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Problem
            </a>
        </div>
    </div>
</x-layout>
