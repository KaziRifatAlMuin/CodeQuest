<x-layout>
    <x-slot:title>Edit User - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-user-edit" style="color: var(--primary);"></i> Edit User
            </h1>
            <p class="lead">Update information for <strong>{{ $user->name }}</strong></p>
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
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('user.update', $user->user_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Profile Picture Section -->
                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                @if($user->profile_picture)
                                    <img src="{{ asset('images/profile/' . $user->profile_picture) }}" 
                                         alt="{{ $user->name }}" 
                                         id="profilePreview"
                                         class="rounded-circle" 
                                         style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #667eea;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center rounded-circle" 
                                         id="profilePreview"
                                         style="width: 120px; height: 120px; border: 4px solid #667eea; background: #f0f4ff;">
                                        <i class="fas fa-user-circle" style="font-size: 4rem; color: #667eea;"></i>
                                    </div>
                                @endif
                                
                                <label for="profile_picture" class="position-absolute" style="bottom: 0; right: 0; cursor: pointer;">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 35px; height: 35px; border: 3px solid white;">
                                        <i class="fas fa-camera"></i>
                                    </div>
                                </label>
                            </div>
                            <input type="file" 
                                   id="profile_picture" 
                                   name="profile_picture" 
                                   accept="image/*" 
                                   style="display: none;"
                                   onchange="previewImage(event)">
                            <p class="text-muted small mt-2">Click the camera icon to change profile picture</p>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password</label>
                                <small class="d-block text-muted mb-2">Leave blank to keep current password. Minimum 8 characters if changing.</small>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="cf_handle" class="form-label">Codeforces Handle <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('cf_handle') is-invalid @enderror" id="cf_handle" name="cf_handle" value="{{ old('cf_handle', $user->cf_handle) }}" required>
                                @error('cf_handle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $user->country) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="university" class="form-label">University</label>
                                <input type="text" class="form-control" id="university" name="university" value="{{ old('university', $user->university) }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea class="form-control" id="bio" name="bio" rows="4" maxlength="200">{{ old('bio', $user->bio) }}</textarea>
                            <small class="form-text text-muted">Max 200 characters</small>
                        </div>

                        <hr>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Update User
                            </button>
                            <a href="{{ route('user.show', $user->user_id) }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Preview image before upload
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('profilePreview');
                    preview.innerHTML = '<img src="' + e.target.result + '" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #667eea;">';
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-layout>
