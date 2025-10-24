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
                        // Determine user-specific data
                        $userProblem = null;
                        if (auth()->check()) {
                            $userProblemData = \DB::select('SELECT * FROM userproblems WHERE user_id = ? AND problem_id = ? LIMIT 1', [auth()->id(), $problem->problem_id]);
                            if (!empty($userProblemData)) $userProblem = $userProblemData[0];
                        }
                        $isStarred = $userProblem && ($userProblem->is_starred ?? false);
                        $currentStatus = $userProblem ? ($userProblem->status ?? 'unsolved') : 'unsolved';
                    @endphp
                    <tr>
                        <!-- Star Column -->
                        <td onclick="event.stopPropagation();" class="text-center" style="width: 60px;">
                            @auth
                                <form action="{{ route('problem.toggleStar', $problem) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                    <button type="submit" class="btn btn-sm p-0 border-0" style="background: transparent; font-size: 1.3rem;">
                                        @if($isStarred)
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star text-muted"></i>
                                        @endif
                                    </button>
                                </form>
                            @else
                                <i class="far fa-star text-muted" style="font-size: 1.3rem;"></i>
                            @endauth
                        </td>

                        <!-- Title -->
                        <td onclick="window.location='{{ route('problem.show', $problem) }}'">
                            <a href="{{ route('problem.show', $problem) }}" style="text-decoration: none; color: var(--primary); font-weight: 600;">
                                {{ $problem->title }}
                            </a>
                        </td>

                        <td onclick="window.location='{{ route('problem.show', $problem) }}'">
                            <span class="badge" style="background: {{ $ratingColor }}; color: white;">{{ $rating }}</span>
                        </td>

                        <td onclick="window.location='{{ route('problem.show', $problem) }}'">
                            @if($problem->tags->count() > 0)
                                @foreach($problem->tags as $ptag)
                                    <x-tag-badge :tagName="$ptag->tag_name" :tagId="$ptag->tag_id" />
                                @endforeach
                            @else
                                <span class="text-muted" style="font-size: 0.85rem;">No tags</span>
                            @endif
                        </td>

                        <td onclick="window.location='{{ route('problem.show', $problem) }}'">{{ number_format($problem->solved_count ?? 0) }}</td>
                        <td onclick="window.location='{{ route('problem.show', $problem) }}'">{{ number_format($problem->stars ?? 0) }}</td>

                        <!-- Status & Link -->
                        <td onclick="event.stopPropagation();" style="width: 200px;">
                            @php
                                $statusClass = 'secondary';
                                if ($currentStatus === 'solved') $statusClass = 'success';
                                elseif ($currentStatus === 'attempting' || $currentStatus === 'trying') $statusClass = 'warning';
                                $selectClass = 'bg-' . $statusClass . ' text-white';
                            @endphp
                            @auth
                                <div class="d-flex align-items-center gap-2 flex-nowrap" style="white-space: nowrap;">
                                    <form action="{{ route('problem.updateStatus', $problem) }}" method="POST" style="display:inline; margin:0;">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                        <select name="status" class="form-select form-select-sm {{ $selectClass }}" onchange="this.form.submit();" style="display: inline-block; font-size: 0.75rem; padding: 0.18rem 0.4rem; width: 110px; max-width: 110px;">
                                            <option value="unsolved" {{ $currentStatus === 'unsolved' ? 'selected' : '' }}>Unsolved</option>
                                            <option value="attempting" {{ $currentStatus === 'attempting' || $currentStatus === 'trying' ? 'selected' : '' }}>Trying</option>
                                            <option value="solved" {{ $currentStatus === 'solved' ? 'selected' : '' }}>Solved</option>
                                        </select>
                                    </form>

                                    <a href="{{ $problem->problem_link }}" target="_blank" class="btn btn-sm btn-primary" style="white-space: nowrap;">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </div>
                            @else
                                <a href="{{ $problem->problem_link }}" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="fas fa-external-link-alt"></i> Solve
                                </a>
                            @endauth
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
