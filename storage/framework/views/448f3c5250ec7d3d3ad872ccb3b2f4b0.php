<?php if (isset($component)) { $__componentOriginal23a33f287873b564aaf305a1526eada4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23a33f287873b564aaf305a1526eada4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> SQL Quest - Query Builder <?php $__env->endSlot(); ?>

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
                                <?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table => $alias): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-3 col-6 mb-2">
                                        <strong><?php echo e($alias); ?></strong> = <?php echo e($table); ?>

                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <hr>
                            <p class="mb-0 small">
                                <i class="fas fa-link"></i> All tables are automatically LEFT JOINed. You can use any combination of columns.
                            </p>
                        </div>

                        <!-- Error Display -->
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <h6><i class="fas fa-exclamation-triangle"></i> Query Error:</h6>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <p class="mb-0"><?php echo e($error); ?></p>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Query Builder Form -->
                        <form action="<?php echo e(route('quest.execute')); ?>" method="POST" id="queryForm">
                            <?php echo csrf_field(); ?>
                            
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
                                            <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($col['full']); ?>" 
                                                    data-table="<?php echo e($col['table']); ?>"
                                                    <?php echo e((isset($selectedColumns) && in_array($col['full'], $selectedColumns)) ? 'selected' : ''); ?>>
                                                    <?php echo e($col['display']); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                              placeholder="Example: u.cf_max_rating > 1500 AND p.rating >= 1800"><?php echo e(old('where_clause')); ?></textarea>
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
                                           value="<?php echo e(old('group_by')); ?>">
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
                                              placeholder="Example: COUNT(*) > 5 AND AVG(p.rating) > 1600"><?php echo e(old('having_clause')); ?></textarea>
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
                                           value="<?php echo e(old('order_by')); ?>">
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
                                           value="<?php echo e(old('limit', 100)); ?>"
                                           style="max-width: 200px;">
                                    <small class="form-text text-muted">
                                        Maximum number of rows to return (1-1000). Default: 100
                                    </small>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5" id="executeBtn">
                                    <i class="fas fa-play"></i> Execute Query
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <?php if(isset($results)): ?>
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-success">
                        <div class="card-header bg-success text-white">
                            <h4 class="mb-0">
                                <i class="fas fa-check-circle"></i> Query Results 
                                <span class="badge bg-light text-dark"><?php echo e(count($results)); ?> rows</span>
                            </h4>
                        </div>
                        <div class="card-body">
                            <!-- Executed Query -->
                            <div class="alert alert-secondary mb-3">
                                <h6 class="alert-heading"><i class="fas fa-code"></i> Executed SQL:</h6>
                                <pre class="mb-0 p-3 bg-dark text-light rounded"><code><?php echo e($query); ?></code></pre>
                            </div>

                            <!-- Results Table -->
                            <?php if(count($results) > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th style="width: 50px;">#</th>
                                                <?php $__currentLoopData = $selectedColumns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <th><?php echo e($col); ?></th>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($index + 1); ?></td>
                                                    <?php $__currentLoopData = get_object_vars($row); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <td><?php echo e($value ?? 'NULL'); ?></td>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Query executed successfully but returned no rows.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $attributes = $__attributesOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__attributesOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $component = $__componentOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__componentOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\CodeQuest\resources\views/navigation/quest.blade.php ENDPATH**/ ?>