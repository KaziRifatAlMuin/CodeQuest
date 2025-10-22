<x-layout>
    <x-slot:title>Edit Profile - CodeQuest</x-slot:title>
    
    <div class="auth-container" style="max-width: 700px;">
        <div class="auth-header">
            <div class="auth-icon">
                <i class="fas fa-user-edit"></i>
            </div>
            <h2>Edit Your Profile</h2>
            <p>Update your personal information</p>
        </div>

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
            
            @if($user->profile_picture)
                <form action="{{ route('account.deleteProfilePicture') }}" method="POST" class="mt-2" id="deletePhotoForm">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete()">
                        <i class="fas fa-trash"></i> Remove Photo
                    </button>
                </form>
            @endif
        </div>

        <form method="POST" action="{{ route('account.updateProfile') }}" enctype="multipart/form-data">
            @csrf

            <input type="file" 
                   id="profile_picture" 
                   name="profile_picture" 
                   accept="image/*" 
                   style="display: none;"
                   onchange="previewImage(event)">

            <div class="form-group">
                <label for="name"><i class="fas fa-user"></i> Full Name</label>
                <input type="text"
                       class="form-control @error('name') is-invalid @enderror"
                       id="name" 
                       name="name"
                       value="{{ old('name', $user->name) }}" 
                       required
                       placeholder="Enter your full name">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                <input type="email"
                       class="form-control"
                       id="email" 
                       value="{{ $user->email }}" 
                       readonly
                       disabled>
                <small class="form-text text-muted">Email cannot be changed</small>
            </div>

            <div class="form-group">
                <label for="cf_handle"><i class="fas fa-trophy"></i> Codeforces Handle</label>
                <input type="text"
                       class="form-control"
                       id="cf_handle" 
                       value="{{ $user->cf_handle }}" 
                       readonly
                       disabled>
                <small class="form-text text-muted">Codeforces handle cannot be changed</small>
            </div>

            <div class="form-group">
                <label for="bio"><i class="fas fa-align-left"></i> Bio</label>
                <textarea class="form-control @error('bio') is-invalid @enderror"
                          id="bio" 
                          name="bio"
                          rows="3"
                          maxlength="200"
                          placeholder="Tell us about yourself (max 200 characters)">{{ old('bio', $user->bio) }}</textarea>
                @error('bio')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted"><span id="bioCount">0</span>/200 characters</small>
            </div>

            <div class="form-group">
                <label for="country"><i class="fas fa-globe"></i> Country</label>
                <input type="text"
                       class="form-control @error('country') is-invalid @enderror"
                       id="country" 
                       name="country"
                       value="{{ old('country', $user->country) }}"
                       placeholder="Enter your country">
                @error('country')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="university"><i class="fas fa-university"></i> University</label>
                <input type="text"
                       class="form-control @error('university') is-invalid @enderror"
                       id="university" 
                       name="university"
                       value="{{ old('university', $user->university) }}"
                       placeholder="Enter your university">
                @error('university')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-auth flex-fill">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="{{ route('account.profile') }}" class="btn btn-outline-secondary flex-fill">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
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

        // Bio character count
        const bioTextarea = document.getElementById('bio');
        const bioCount = document.getElementById('bioCount');
        
        function updateCount() {
            bioCount.textContent = bioTextarea.value.length;
        }
        
        bioTextarea.addEventListener('input', updateCount);
        updateCount();

        // Confirm delete
        function confirmDelete() {
            if (confirm('Are you sure you want to remove your profile picture?')) {
                document.getElementById('deletePhotoForm').submit();
            }
        }
    </script>
</x-layout>
