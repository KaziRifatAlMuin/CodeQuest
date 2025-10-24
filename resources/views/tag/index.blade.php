<x-layout>
    <x-slot:title>Tags - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-tags" style="color: var(--primary);"></i> Tags
            </h1>
            <p class="lead">Browse problems by tags and categories</p>
        </div>
    </div>

    <!-- Tag Sorting Controls -->
    <div class="card shadow-sm mb-3">
        <div class="card-body p-3">
            <form method="GET" class="d-flex align-items-center justify-content-between flex-wrap gap-2" id="tagSortForm">
                <input type="hidden" name="tags_per_page" value="{{ request('tags_per_page', 50) }}">
                <input type="hidden" name="per_page" value="{{ request('per_page', 25) }}">
                @foreach(request('tags', []) as $tag)
                    <input type="hidden" name="tags[]" value="{{ $tag }}">
                @endforeach
                <input type="hidden" name="mode" value="{{ request('mode', 'single') }}">
                <input type="hidden" name="logic" value="{{ request('logic', 'OR') }}">
                <input type="hidden" name="show_tags" value="{{ request('show_tags', 'yes') }}">
                
                <div class="d-flex align-items-center gap-2">
                    <label class="mb-0 text-muted fw-bold">Sort tags by:</label>
                    <select name="sort" class="form-select form-select-sm" style="width: 160px;" onchange="document.getElementById('tagSortForm').submit();">
                        <option value="name" {{ ($sort ?? 'name') === 'name' ? 'selected' : '' }}>Name</option>
                        <option value="problems" {{ ($sort ?? '') === 'problems' ? 'selected' : '' }}>Problem Count</option>
                    </select>

                    <select name="direction" class="form-select form-select-sm" style="width: 130px;" onchange="document.getElementById('tagSortForm').submit();">
                        <option value="asc" {{ ($direction ?? 'asc') === 'asc' ? 'selected' : '' }}>Ascending</option>
                        <option value="desc" {{ ($direction ?? 'asc') === 'desc' ? 'selected' : '' }}>Descending</option>
                    </select>
                </div>
                
                <div>
                    <small class="text-muted">{{ $tagsPaginator->total() }} tags</small>
                </div>
            </form>
        </div>
    </div>

    <!-- Tag Statistics Pie Chart -->
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Tag Usage Statistics</h5>
        </div>
        <div class="card-body">
            <canvas id="tagPieChart" style="max-height: 400px;"></canvas>
        </div>
    </div>

    <!-- Tag Filter Controls -->
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter"></i> Filter Problems by Tags</h5>
        </div>
        <div class="card-body">
            <form id="tagFilterForm" method="GET" action="{{ route('tag.index') }}">
                <!-- Preserve pagination parameters -->
                <input type="hidden" name="tags_per_page" value="{{ request('tags_per_page', 50) }}">
                <input type="hidden" name="per_page" value="{{ request('per_page', 25) }}">
                
                <!-- Filter Options -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label"><strong>Selection Mode:</strong></label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="mode" id="mode_single" value="single" {{ $filterMode === 'single' ? 'checked' : '' }}>
                            <label class="btn btn-outline-primary" for="mode_single">Single Select</label>
                            
                            <input type="radio" class="btn-check" name="mode" id="mode_multiple" value="multiple" {{ $filterMode === 'multiple' ? 'checked' : '' }}>
                            <label class="btn btn-outline-primary" for="mode_multiple">Multiple Select</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label"><strong>Filter Logic:</strong></label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="logic" id="logic_or" value="OR" {{ $filterLogic === 'OR' ? 'checked' : '' }}>
                            <label class="btn btn-outline-success" for="logic_or">OR (Any Tag)</label>
                            
                            <input type="radio" class="btn-check" name="logic" id="logic_and" value="AND" {{ $filterLogic === 'AND' ? 'checked' : '' }}>
                            <label class="btn btn-outline-success" for="logic_and">AND (All Tags)</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label"><strong>Show Tags:</strong></label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="show_tags" id="show_yes" value="yes" {{ $showTags === 'yes' ? 'checked' : '' }}>
                            <label class="btn btn-outline-info" for="show_yes">Yes</label>
                            
                            <input type="radio" class="btn-check" name="show_tags" id="show_no" value="no" {{ $showTags === 'no' ? 'checked' : '' }}>
                            <label class="btn btn-outline-info" for="show_no">No</label>
                        </div>
                    </div>
                </div>

                <!-- Tags Selection -->
                <div class="mb-3">
                    <label class="form-label"><strong>Select Tags:</strong></label>
                    <div class="tag-selection-container" style="display: flex; flex-wrap: wrap; gap: 8px;">
                        @foreach($tags as $tag)
                            <div class="form-check" style="margin: 0;">
                                <input 
                                    class="form-check-input tag-checkbox" 
                                    type="checkbox" 
                                    name="tags[]" 
                                    value="{{ $tag->tag_id }}" 
                                    id="tag_{{ $tag->tag_id }}"
                                    {{ in_array($tag->tag_id, $selectedTags) ? 'checked' : '' }}
                                >
                                <label class="form-check-label tag-label" for="tag_{{ $tag->tag_id }}" style="cursor: pointer;">
                                    <span class="badge rounded-pill" style="background-color: #e9ecef; color: #495057; padding: 6px 12px; font-size: 0.875rem;">
                                        {{ $tag->tag_name }}
                                        <span class="badge bg-primary ms-1">{{ $tag->problems_count }}</span>
                                    </span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Tags Pagination -->
                    @if($tagsPaginator->hasPages())
                        <div class="mt-3">
                            {{ $tagsPaginator->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Apply Filters
                    </button>
                    <a href="{{ route('tag.index') }}" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Filtered Problems List -->
    <!-- Per-page selector for problems (pagination only, no search) -->
    <div class="d-flex justify-content-end mb-2">
        <form method="GET" action="{{ route('tag.index') }}" class="d-flex align-items-center">
            {{-- Preserve filter and pagination state --}}
            @foreach(request()->except(['per_page', 'page']) as $k => $v)
                @if(is_array($v))
                    @foreach($v as $item)
                        <input type="hidden" name="{{ $k }}[]" value="{{ $item }}">
                    @endforeach
                @else
                    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                @endif
        @endforeach

    </div>

    <div class="container-fluid px-4">
    <div class="card shadow-sm" style="width: 100%;">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-code"></i> Problems 
                @if(!empty($selectedTags))
                    <span class="badge bg-primary">{{ $problems->total() }} filtered</span>
                @else
                    <span class="badge bg-secondary">All Problems</span>
                @endif
            </h5>
        </div>
        <div class="card-body p-0" style="overflow-x: auto;">
            <x-table :headers="$showTags === 'yes' ? ['⭐', 'Title', 'Rating', 'Tags', 'Solved', 'Stars', 'Status & Link'] : ['⭐', 'Title', 'Rating', 'Solved', 'Stars', 'Status & Link']" :paginator="$problems" style="width: 100%;">
                @forelse($problems as $problem)
                    @php
                        $rating = (int) ($problem->rating ?? 0);
                        $ratingColor = \App\Helpers\RatingHelper::getRatingColor($rating);
                        $userProblem = null;
                        if (auth()->check()) {
                            $userProblemData = \DB::select('SELECT * FROM userproblems WHERE user_id = ? AND problem_id = ? LIMIT 1', [auth()->id(), $problem->problem_id]);
                            if (!empty($userProblemData)) $userProblem = $userProblemData[0];
                        }
                        $isStarred = $userProblem && ($userProblem->is_starred ?? false);
                        $currentStatus = $userProblem ? ($userProblem->status ?? 'unsolved') : 'unsolved';
                    @endphp
                    <tr>
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

                        <td onclick="window.location='{{ route('problem.show', $problem) }}'">
                            <a href="{{ route('problem.show', $problem) }}" style="text-decoration: none; color: var(--primary); font-weight: 600;">
                                {{ $problem->title }}
                            </a>
                        </td>

                        <td onclick="window.location='{{ route('problem.show', $problem) }}'">
                            <span class="badge" style="background: {{ $ratingColor }}; color: white;">{{ $rating }}</span>
                        </td>

                        @if($showTags === 'yes')
                            <td onclick="window.location='{{ route('problem.show', $problem) }}'">
                                @if($problem->tags->count() > 0)
                                    @foreach($problem->tags as $tag)
                                        <x-tag-badge :tagName="$tag->tag_name" :tagId="$tag->tag_id" />
                                    @endforeach
                                @else
                                    <span class="text-muted">No tags</span>
                                @endif
                            </td>
                        @endif

                        <td onclick="window.location='{{ route('problem.show', $problem) }}'">{{ number_format($problem->solved_count ?? 0) }}</td>
                        <td onclick="window.location='{{ route('problem.show', $problem) }}'">{{ number_format($problem->stars ?? 0) }}</td>

                        <td onclick="event.stopPropagation();" style="white-space: nowrap;">
                            @php
                                $statusClass = 'secondary';
                                if ($currentStatus === 'solved') $statusClass = 'success';
                                elseif ($currentStatus === 'attempting' || $currentStatus === 'trying') $statusClass = 'warning';
                                $selectClass = 'bg-' . $statusClass . ' text-white';
                            @endphp
                            @auth
                                <div class="d-flex align-items-center gap-1 flex-nowrap">
                                    <form action="{{ route('problem.updateStatus', $problem) }}" method="POST" style="display:inline; margin:0;">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                        <select name="status" class="form-select form-select-sm {{ $selectClass }}" onchange="this.form.submit();" style="font-size: 0.75rem; padding: 0.18rem 0.4rem; width: 90px; display:inline-block;">
                                            <option value="unsolved" {{ $currentStatus === 'unsolved' ? 'selected' : '' }}>Unsolved</option>
                                            <option value="attempting" {{ $currentStatus === 'attempting' || $currentStatus === 'trying' ? 'selected' : '' }}>Trying</option>
                                            <option value="solved" {{ $currentStatus === 'solved' ? 'selected' : '' }}>Solved</option>
                                        </select>
                                    </form>
                                    <a href="{{ $problem->problem_link }}" target="_blank" class="btn btn-sm btn-primary">
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
                        <td colspan="{{ $showTags === 'yes' ? '7' : '6' }}" class="text-center p-4">
                            <i class="fas fa-inbox" style="font-size: 2rem; color: var(--text-light); margin-right: 10px;"></i>
                            <p class="text-muted mb-0">No problems found with selected filters</p>
                        </td>
                    </tr>
                @endforelse
            </x-table>
        </div>
    </div>
    </div>
    <div class="container mt-4">

    <!-- Chart.js for Pie Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Tag statistics data
        const tagStats = @json($tagStats);
        
        // Prepare data for pie chart
        const labels = tagStats.map(tag => tag.tag_name);
        const data = tagStats.map(tag => tag.problem_count);
        
        // Chart colors are generated server-side to match tag badge palette and rank pattern
        const backgroundColors = @json($chartColors);

        // Create pie chart
        const ctx = document.getElementById('tagPieChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: backgroundColors,
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed + ' problems';
                            }
                        }
                    }
                }
            }
        });

        // Handle single/multiple selection mode
        const modeInputs = document.querySelectorAll('input[name="mode"]');
        const tagCheckboxes = document.querySelectorAll('.tag-checkbox');

        modeInputs.forEach(input => {
            input.addEventListener('change', function() {
                if (this.value === 'single') {
                    // In single mode, uncheck all but keep the last checked
                    let lastChecked = null;
                    tagCheckboxes.forEach(checkbox => {
                        if (checkbox.checked) {
                            if (lastChecked) lastChecked.checked = false;
                            lastChecked = checkbox;
                        }
                    });
                }
            });
        });

        // Enforce single selection when in single mode
        tagCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const mode = document.querySelector('input[name="mode"]:checked').value;
                if (mode === 'single' && this.checked) {
                    tagCheckboxes.forEach(cb => {
                        if (cb !== this) cb.checked = false;
                    });
                }
            });
        });
    </script>

    <style>
        .tag-label:hover {
            opacity: 0.8;
        }
        
        .form-check-input:checked + .tag-label .tag-badge {
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25);
            transform: scale(1.05);
            transition: all 0.2s;
        }

        .tag-selection-container .form-check {
            display: inline-block;
        }
    </style>
</x-layout>
