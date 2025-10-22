<x-layout>
    <x-slot:title>Admin - Manage Tags</x-slot:title>

    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col-12">
                <h2><i class="fas fa-tags text-primary"></i> Manage Tags</h2>
                <p class="text-muted">View and manage all tags. Click Manage to update or delete a tag.</p>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Tag</th>
                                <th class="text-center">Problems</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tags as $index => $tag)
                                <tr>
                                    <td>{{ $tags->firstItem() + $index }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <x-tag-badge :tagName="$tag->tag_name" :tagId="$tag->tag_id" />
                                            <span>{{ $tag->tag_name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $tag->problems_count }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.tags.manage', $tag) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-tools"></i> Manage
                                        </a>
                                        <a href="{{ route('tag.show', $tag) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">No tags found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($tags->hasPages())
                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><small class="text-muted">Showing {{ $tags->firstItem() }} to {{ $tags->lastItem() }} of {{ $tags->total() }}</small></div>
                        <div>{{ $tags->links() }}</div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layout>
