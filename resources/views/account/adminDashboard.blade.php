<x-layout>
    <x-slot:title>Admin Dashboard - CodeQuest</x-slot:title>
    
    <div class="container mt-5 mb-5">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="display-4 text-center mb-2">
                    <i class="fas fa-tachometer-alt text-primary"></i> Admin Dashboard
                </h1>
                <p class="text-center text-muted">Manage users and problems from your central control panel</p>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-primary shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Manage Users</h5>
                        <p class="text-muted small mb-3">View, create, edit, and delete users</p>
                        <a href="{{ route('user.index') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-arrow-right"></i> Go to Users
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-secondary shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-tags fa-3x text-secondary mb-3"></i>
                        <h5 class="card-title">Manage Tags</h5>
                        <p class="text-muted small mb-3">Create, update, or delete tags used across the site</p>
                        <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-right"></i> Go to Tags
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-dark shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-newspaper fa-3x text-dark mb-3"></i>
                        <h5 class="card-title">Manage Editorials</h5>
                        <p class="text-muted small mb-3">Review and moderate editorials</p>
                        <a href="{{ route('editorial.index') }}" class="btn btn-dark btn-sm text-white">
                            <i class="fas fa-arrow-right"></i> Go to Editorials
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-success shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-code fa-3x text-success mb-3"></i>
                        <h5 class="card-title">Manage Problems</h5>
                        <p class="text-muted small mb-3">View, create, edit, and delete problems</p>
                        <a href="{{ route('problem.index') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-arrow-right"></i> Go to Problems
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-warning shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-user-plus fa-3x text-warning mb-3"></i>
                        <h5 class="card-title">Create User</h5>
                        <p class="text-muted small mb-3">Add a new user to the system</p>
                        <a href="{{ route('user.create') }}" class="btn btn-warning btn-sm text-white">
                            <i class="fas fa-plus"></i> Create User
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-info shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-plus-circle fa-3x text-info mb-3"></i>
                        <h5 class="card-title">Create Problem</h5>
                        <p class="text-muted small mb-3">Add a new problem to the system</p>
                        <a href="{{ route('problem.create') }}" class="btn btn-info btn-sm text-white">
                            <i class="fas fa-plus"></i> Create Problem
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-success shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-tag fa-3x text-success mb-3"></i>
                        <h5 class="card-title">Create Tag</h5>
                        <p class="text-muted small mb-3">Add a new tag to the system</p>
                        <a href="{{ route('tag.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Create Tag
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card border-success shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-pen-fancy fa-3x text-success mb-3"></i>
                        <h5 class="card-title">Create Editorial</h5>
                        <p class="text-muted small mb-3">Write a new editorial for a problem</p>
                        <a href="{{ route('editorial.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Create Editorial
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-gradient text-white py-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h4 class="mb-0">
                    <i class="fas fa-table"></i> All Users
                    <span class="badge bg-light text-dark ms-2">{{ $users->total() }} Total</span>
                </h4>
                <small>Sorted by Role (Admin → Moderator → User) then by Rating (High to Low)</small>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" class="text-center" style="width: 5%;">#</th>
                                <th scope="col" style="width: 18%;">Name</th>
                                <th scope="col" style="width: 13%;">CF Handle</th>
                                <th scope="col" class="text-center" style="width: 12%;">Role</th>
                                <th scope="col" class="text-center" style="width: 10%;">Max Rating</th>
                                <th scope="col" class="text-center" style="width: 8%;">Solved</th>
                                <th scope="col" style="width: 18%;">Email</th>
                                <th scope="col" class="text-center" style="width: 16%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $user)
                                <tr>
                                    <td class="text-center">{{ $users->firstItem() + $index }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($user->profile_picture)
                                                <img src="{{ asset('images/profile/' . $user->profile_picture) }}" 
                                                     alt="{{ $user->name }}" 
                                                     class="rounded-circle me-2" 
                                                     style="width: 30px; height: 30px; object-fit: cover;">
                                            @else
                                                <i class="fas fa-user-circle fa-2x text-secondary me-2"></i>
                                            @endif
                                            <span>{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $user->cf_handle }}
                                        @if($user->handle_verified_at)
                                            <i class="fas fa-check-circle text-success" title="Verified"></i>
                                        @else
                                            <i class="fas fa-times-circle text-danger" title="Not Verified"></i>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <select class="form-select form-select-sm role-dropdown" 
                                                data-user-id="{{ $user->user_id }}" 
                                                style="font-size: 0.85rem; padding: 0.25rem 0.5rem; text-transform: uppercase; font-weight: 600;
                                                       background-color: {{ $user->role === 'admin' ? '#dc3545' : ($user->role === 'moderator' ? '#ffc107' : '#6c757d') }}; 
                                                       color: white; border: none;">
                                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>USER</option>
                                            <option value="moderator" {{ $user->role === 'moderator' ? 'selected' : '' }}>MODERATOR</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>ADMIN</option>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">{{ $user->cf_max_rating }}</span>
                                    </td>
                                    <td class="text-center">
                                        {{ $user->solved_problems_count }}
                                    </td>
                                    <td style="font-size: 0.8rem;">
                                        <div class="text-truncate" style="max-width: 180px;" title="{{ $user->email }}">
                                            {{ $user->email }}
                                        </div>
                                        @if($user->email_verified_at)
                                            <i class="fas fa-check-circle text-success" title="Verified"></i>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('user.show', $user->user_id) }}" 
                                               class="btn btn-outline-info" 
                                               title="View User">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('user.edit', $user->user_id) }}" 
                                               class="btn btn-outline-warning" 
                                               title="Edit User">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-outline-danger" 
                                                    title="Delete User"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal{{ $user->user_id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Delete Confirmation Modal -->
                                        <div class="modal fade" id="deleteModal{{ $user->user_id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $user->user_id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $user->user_id }}">
                                                            <i class="fas fa-exclamation-triangle"></i> Confirm Delete
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete user <strong>{{ $user->name }}</strong>?</p>
                                                        <p class="text-danger mb-0">
                                                            <i class="fas fa-exclamation-circle"></i> This action cannot be undone!
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            <i class="fas fa-times"></i> Cancel
                                                        </button>
                                                        <form action="{{ route('user.destroy', $user->user_id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">
                                                                <i class="fas fa-trash"></i> Delete User
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="fas fa-users fa-3x text-muted mb-3 d-block"></i>
                                        <p class="text-muted">No users found in the system.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Pagination -->
            @if($users->hasPages())
                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} users
                            </small>
                        </div>
                        <div>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Back to Profile Button -->
        <div class="text-center mt-4">
            <a href="{{ route('account.profile') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Profile
            </a>
        </div>
    </div>

    <!-- JavaScript for Role Update -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleDropdowns = document.querySelectorAll('.role-dropdown');
            
            roleDropdowns.forEach(dropdown => {
                dropdown.addEventListener('change', function() {
                    const userId = this.dataset.userId;
                    const newRole = this.value;
                    const selectElement = this;
                    
                    // Disable dropdown during update
                    selectElement.disabled = true;
                    
                    // Send AJAX request
                    fetch(`/admin/users/${userId}/update-role`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            role: newRole
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update dropdown color based on role
                            if (newRole === 'admin') {
                                selectElement.style.backgroundColor = '#dc3545';
                            } else if (newRole === 'moderator') {
                                selectElement.style.backgroundColor = '#ffc107';
                            } else {
                                selectElement.style.backgroundColor = '#6c757d';
                            }
                            
                            // Show success message
                            showAlert('Role updated successfully!', 'success');
                        } else {
                            showAlert('Failed to update role. Please try again.', 'danger');
                            // Reload page to reset dropdown
                            setTimeout(() => location.reload(), 1500);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('An error occurred. Please try again.', 'danger');
                        // Reload page to reset dropdown
                        setTimeout(() => location.reload(), 1500);
                    })
                    .finally(() => {
                        // Re-enable dropdown
                        selectElement.disabled = false;
                    });
                });
            });
            
            function showAlert(message, type) {
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
                alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                alertDiv.innerHTML = `
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i> ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(alertDiv);
                
                // Auto-dismiss after 3 seconds
                setTimeout(() => {
                    alertDiv.remove();
                }, 3000);
            }
        });
    </script>
</x-layout>
