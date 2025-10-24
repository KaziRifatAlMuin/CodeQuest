<x-layout>
    <x-slot:title>SQL Quest - Query Builder</x-slot:title>

    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-primary">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">
                            <i class="fas fa-database"></i> SQL Quest - Interactive Query Builder
                        </h3>
                        <p class="mb-0 mt-2 small">Build and execute SELECT queries on the CodeQuest database</p>
                    </div>
                    <div class="card-body">
                        <!-- Table Information -->
                        <div class="alert alert-info mb-4">
                            <h6 class="alert-heading"><i class="fas fa-info-circle"></i> Available Tables & Aliases:</h6>
                            <div class="row">
                                @foreach($tables as $table => $alias)
                                    <div class="col-md-3 col-6 mb-2">
                                        <strong>{{ $alias }}</strong> = {{ $table }}
                                    </div>
                                @endforeach
                            </div>
                            <hr>
                            <p class="mb-0 small">
                                <i class="fas fa-link"></i> All tables are automatically LEFT JOINed. You can use any combination of columns.
                            </p>
                        </div>

                        <!-- Error Display -->
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <h6><i class="fas fa-exclamation-triangle"></i> Query Error:</h6>
                                @foreach($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <!-- Query Builder Form -->
                        <form action="{{ route('quest.execute') }}" method="POST" id="queryForm">
                            @csrf
                            
                            <!-- Column Selection -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        <i class="fas fa-columns"></i> SELECT Columns 
                                        <span class="badge bg-primary" id="columnCount">0</span> / 6 selected
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="columns" class="form-label fw-bold">Choose up to 6 columns:</label>
                                        <select class="form-select" id="columns" name="columns[]" multiple size="10" required>
                                            @foreach($columns as $col)
                                                <option value="{{ $col['full'] }}" 
                                                    data-table="{{ $col['table'] }}"
                                                    {{ (isset($selectedColumns) && in_array($col['full'], $selectedColumns)) ? 'selected' : '' }}>
                                                    {{ $col['display'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted mt-2">
                                            <i class="fas fa-hand-pointer"></i> Hold Ctrl (Windows) or Cmd (Mac) to select multiple columns. Max 6 columns allowed.
                                        </small>
                                        <div class="alert alert-warning mt-2 d-none" id="columnWarning">
                                            <i class="fas fa-exclamation-triangle"></i> You can only select up to 6 columns!
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- WHERE Clause -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fas fa-filter"></i> WHERE Clause (Optional)</h5>
                                </div>
                                <div class="card-body">
                                    <textarea class="form-control font-monospace" 
                                              id="where_clause" 
                                              name="where_clause" 
                                              rows="3" 
                                              placeholder="Example: u.cf_max_rating > 1500 AND p.rating >= 1800">{{ old('where_clause') }}</textarea>
                                    <small class="form-text text-muted">
                                        Filter rows using conditions. Use table aliases (u, p, t, etc.)
                                    </small>
                                </div>
                            </div>

                            <!-- GROUP BY Clause -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fas fa-object-group"></i> GROUP BY (Optional)</h5>
                                </div>
                                <div class="card-body">
                                    <input type="text" 
                                           class="form-control font-monospace" 
                                           id="group_by" 
                                           name="group_by" 
                                           placeholder="Example: u.user_id, p.rating"
                                           value="{{ old('group_by') }}">
                                    <small class="form-text text-muted">
                                        Group results by columns. Separate multiple columns with commas.
                                    </small>
                                </div>
                            </div>

                            <!-- HAVING Clause -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fas fa-filter"></i> HAVING Clause (Optional)</h5>
                                </div>
                                <div class="card-body">
                                    <textarea class="form-control font-monospace" 
                                              id="having_clause" 
                                              name="having_clause" 
                                              rows="2" 
                                              placeholder="Example: COUNT(*) > 5 AND AVG(p.rating) > 1600">{{ old('having_clause') }}</textarea>
                                    <small class="form-text text-muted">
                                        Filter grouped results. Use aggregate functions like COUNT(), AVG(), SUM(), etc.
                                    </small>
                                </div>
                            </div>

                            <!-- ORDER BY Clause -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fas fa-sort"></i> ORDER BY (Optional)</h5>
                                </div>
                                <div class="card-body">
                                    <input type="text" 
                                           class="form-control font-monospace" 
                                           id="order_by" 
                                           name="order_by" 
                                           placeholder="Example: u.cf_max_rating DESC, u.name ASC"
                                           value="{{ old('order_by') }}">
                                    <small class="form-text text-muted">
                                        Sort results. Use ASC (ascending) or DESC (descending). Separate multiple columns with commas.
                                    </small>
                                </div>
                            </div>

                            <!-- LIMIT -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fas fa-list-ol"></i> LIMIT</h5>
                                </div>
                                <div class="card-body">
                                    <input type="number" 
                                           class="form-control" 
                                           id="limit" 
                                           name="limit" 
                                           min="1" 
                                           max="1000" 
                                           value="{{ old('limit', 100) }}"
                                           style="max-width: 200px;">
                                    <small class="form-text text-muted">
                                        Maximum number of rows to return (1-1000). Default: 100
                                    </small>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <!-- Distinct toggle and Submit Button -->
                            <div class="d-flex justify-content-center align-items-center gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="distinct" name="distinct" {{ (isset($distinctFlag) && $distinctFlag) || old('distinct') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="distinct">Distinct results</label>
                                </div>

                                <div>
                                    <button type="submit" class="btn btn-primary btn-lg px-5" id="executeBtn">
                                        <i class="fas fa-play"></i> Execute Query
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        @if(isset($results))
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-success">
                        <div class="card-header bg-success text-white">
                            <h4 class="mb-0">
                                <i class="fas fa-check-circle"></i> Query Results 
                                <span class="badge bg-light text-dark">{{ count($results) }} rows</span>
                            </h4>
                        </div>
                        <div class="card-body">
                            <!-- Executed Query -->
                            <div class="alert alert-secondary mb-3">
                                <h6 class="alert-heading"><i class="fas fa-code"></i> Executed SQL:</h6>
                                <pre class="mb-0 p-3 bg-dark text-light rounded"><code>{{ $query }}</code></pre>
                            </div>

                            <!-- Results Table -->
                            @if(count($results) > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th style="width: 50px;">#</th>
                                                @if(isset($selectedColumnLabels))
                                                    @foreach($selectedColumnLabels as $label)
                                                        <th>{{ $label }}</th>
                                                    @endforeach
                                                @else
                                                    @foreach($selectedColumns as $col)
                                                        <th>{{ $col }}</th>
                                                    @endforeach
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($results as $index => $row)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    @if(isset($selectedAliases))
                                                        @foreach($selectedAliases as $alias)
                                                            <td>{{ $row->{$alias} ?? 'NULL' }}</td>
                                                        @endforeach
                                                    @else
                                                        @foreach(get_object_vars($row) as $value)
                                                            <td>{{ $value ?? 'NULL' }}</td>
                                                        @endforeach
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Query executed successfully but returned no rows.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- JavaScript for real-time validation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const columnsSelect = document.getElementById('columns');
            const columnCount = document.getElementById('columnCount');
            const columnWarning = document.getElementById('columnWarning');
            const executeBtn = document.getElementById('executeBtn');
            const maxColumns = 6;

            function updateColumnCount() {
                const selected = Array.from(columnsSelect.selectedOptions);
                const count = selected.length;
                
                columnCount.textContent = count;
                
                if (count > maxColumns) {
                    columnWarning.classList.remove('d-none');
                    executeBtn.disabled = true;
                    columnCount.classList.remove('bg-primary');
                    columnCount.classList.add('bg-danger');
                } else if (count === 0) {
                    columnWarning.classList.add('d-none');
                    executeBtn.disabled = true;
                    columnCount.classList.remove('bg-danger');
                    columnCount.classList.add('bg-primary');
                } else {
                    columnWarning.classList.add('d-none');
                    executeBtn.disabled = false;
                    columnCount.classList.remove('bg-danger');
                    columnCount.classList.add('bg-primary');
                }
            }

            // Update count on selection change
            columnsSelect.addEventListener('change', updateColumnCount);
            
            // Initial count
            updateColumnCount();

            // Prevent form submission if more than 6 columns
            document.getElementById('queryForm').addEventListener('submit', function(e) {
                const selected = Array.from(columnsSelect.selectedOptions);
                if (selected.length > maxColumns) {
                    e.preventDefault();
                    alert('Please select no more than ' + maxColumns + ' columns.');
                    return false;
                }
                if (selected.length === 0) {
                    e.preventDefault();
                    alert('Please select at least one column.');
                    return false;
                }
            });
        });
    </script>

    <style>
        .font-monospace {
            font-family: 'Courier New', Courier, monospace;
            font-size: 0.9rem;
        }
        
        #columns {
            font-family: 'Courier New', Courier, monospace;
            font-size: 0.85rem;
        }
        
        #columns option {
            padding: 5px;
        }
        
        #columns option:hover {
            background-color: #e9ecef;
        }
        
        pre code {
            font-size: 0.85rem;
            line-height: 1.5;
        }
        
        .table-responsive {
            max-height: 600px;
            overflow-y: auto;
        }
        
        .table thead {
            position: sticky;
            top: 0;
            z-index: 10;
        }
    </style>
</x-layout>
