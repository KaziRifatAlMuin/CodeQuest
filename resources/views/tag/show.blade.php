<x-layout>
    <x-slot:title>{{ $tag->tag_name }} - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-tag" style="color: var(--primary);"></i> 
                <x-tag-badge :tagName="$tag->tag_name" :tagId="$tag->tag_id" />
            </h1>
            <p class="lead">Browse all problems tagged with {{ $tag->tag_name }}</p>
        </div>
    </div>

    <!-- Tag Statistics -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-code" style="font-size: 2rem; color: var(--primary);"></i>
                    <h3 class="mt-2 mb-0">{{ $tag->problems()->count() }}</h3>
                    <p class="text-muted mb-0">Problems</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin/Moderator Actions -->
    @auth
        @if(in_array(auth()->user()->role, ['admin', 'moderator']))
            <div class="mb-4">
                <a href="{{ route('tag.edit', $tag) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit Tag
                </a>
                @if(auth()->user()->role === 'admin')
                    <form action="{{ route('tag.destroy', $tag) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this tag?');">
                            <i class="fas fa-trash"></i> Delete Tag
                        </button>
                    </form>
                @endif
            </div>
        @endif
    @endauth

    <!-- Problems with this tag -->
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-list"></i> Problems ({{ $problems->total() }})</h5>
        </div>
        <div class="card-body p-0">
            <x-table :headers="['Title', 'Rating', 'Tags', 'Solved', 'Stars', 'Link']" :paginator="$problems">
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
                                    @foreach($problem->tags as $ptag)
                                    <x-tag-badge :tagName="$ptag->tag_name" :tagId="$ptag->tag_id" />
                                @endforeach
                            @else
                                <span class="text-muted" style="font-size: 0.85rem;">No tags</span>
                            @endif
                        </td>
                        <td>{{ number_format($problem->solved_count ?? 0) }}</td>
                        <td>{{ number_format($problem->stars ?? 0) }}</td>
                        <td onclick="event.stopPropagation();">
                            <a href="{{ $problem->problem_link }}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="fas fa-external-link-alt"></i> Solve
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center p-4">
                            <i class="fas fa-inbox" style="font-size: 2rem; color: var(--text-light); margin-right: 10px;"></i>
                            <p class="text-muted mb-0">No problems found with this tag</p>
                        </td>
                    </tr>
                @endforelse
            </x-table>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('tag.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to All Tags
        </a>
    </div>
</x-layout>
