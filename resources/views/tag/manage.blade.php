<x-layout>
    <x-slot:title>Manage Tag - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-tools" style="color: var(--primary);"></i>
                Manage Tag
            </h1>
            <p class="lead">Update or remove the tag and review associated problems for <strong>{{ $tag->tag_name }}</strong></p>
        </div>
    </div>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h6 class="alert-heading"><i class="fas fa-exclamation-circle"></i> Please fix the following errors:</h6>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form action="{{ route('tag.update', $tag) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="tag_name" class="form-label">Tag Name <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                class="form-control @error('tag_name') is-invalid @enderror" 
                                id="tag_name" 
                                name="tag_name" 
                                value="{{ old('tag_name', $tag->tag_name) }}" 
                                required
                            >
                            @error('tag_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="card mb-3 bg-light">
                            <div class="card-body">
                                <h6 class="card-title"><i class="fas fa-info-circle"></i> Tag Preview & Info</h6>
                                <div class="mb-2">
                                    <x-tag-badge :tagName="$tag->tag_name" :tagId="$tag->tag_id" />
                                </div>
                                <p class="mb-0 text-muted">
                                    <i class="fas fa-code"></i> This tag is currently used in <strong>{{ $tag->problems()->count() }}</strong> problems.
                                </p>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Tag
                            </button>
                            <a href="{{ route('tag.show', $tag) }}" class="btn btn-secondary">
                                <i class="fas fa-eye"></i> View Tag Page
                            </a>
                            <a href="{{ route('tag.index') }}" class="btn btn-light ms-auto">
                                <i class="fas fa-arrow-left"></i> Back to Tags
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            @auth
                @if(auth()->user()->role === 'admin')
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-danger"><i class="fas fa-trash"></i> Delete Tag</h5>
                            <p class="text-muted">Deleting this tag will remove it from all associated problems but will not delete the problems themselves.</p>
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash-alt"></i> Delete Tag
                            </button>
                        </div>
                    </div>
                @endif
            @endauth
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Problems with this Tag</h5>
                </div>
                <div class="card-body p-0">
                    @php
                        // Fetch problems for this tag; paginate to keep UI reasonable
                        $problems = $tag->problems()->with('tags')->orderByDesc('solved_count')->paginate(15);
                    @endphp

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
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @if(auth()->user()->role === 'admin')
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deleteModalLabel"><i class="fas fa-exclamation-triangle"></i> Confirm Delete</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete the tag <strong>{{ $tag->tag_name }}</strong>?</p>
                        <p class="text-warning mb-0">
                            <i class="fas fa-info-circle"></i> <strong>Note:</strong> This will remove the tag from all associated problems, but the problems themselves will not be deleted.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="{{ route('tag.destroy', $tag) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete Tag
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-layout>
