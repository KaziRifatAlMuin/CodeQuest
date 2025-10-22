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

    <!-- Success Message -->
    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Add New Tag Button (Admin/Moderator Only) -->
    @auth
        @if(in_array(auth()->user()->role, ['admin', 'moderator']))
            <div class="mb-4">
                <a href="{{ route('tag.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create New Tag
                </a>
            </div>
        @endif
    @endauth

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
                                    <x-tag-badge :tagName="$tag->tag_name" :tagId="$tag->tag_id" />
                                </label>
                            </div>
                        @endforeach
                    </div>
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
    <div class="card shadow-sm">
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
        <div class="card-body p-0">
            <x-table :headers="$showTags === 'yes' ? ['Title', 'Rating', 'Tags', 'Solved', 'Stars', 'Link'] : ['Title', 'Rating', 'Solved', 'Stars', 'Link']" :paginator="$problems">
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
                        @if($showTags === 'yes')
                            <td>
                                @if($problem->tags->count() > 0)
                                    @foreach($problem->tags as $tag)
                                        <x-tag-badge :tagName="$tag->tag_name" :tagId="$tag->tag_id" />
                                    @endforeach
                                @else
                                    <span class="text-muted">No tags</span>
                                @endif
                            </td>
                        @endif
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
                        <td colspan="{{ $showTags === 'yes' ? '6' : '5' }}" class="text-center p-4">
                            <i class="fas fa-inbox" style="font-size: 2rem; color: var(--text-light); margin-right: 10px;"></i>
                            <p class="text-muted mb-0">No problems found with selected filters</p>
                        </td>
                    </tr>
                @endforelse
            </x-table>
        </div>
    </div>

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
