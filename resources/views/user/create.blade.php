<x-layout>
    <x-slot:title>Create New User - CodeQuest</x-slot:title>

    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-4">
                <i class="fas fa-user-plus" style="color: var(--primary);"></i> Create New User
            </h1>
            <p class="lead">Add a new user to the system</p>
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
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <small class="d-block text-muted mb-2">Minimum 8 characters</small>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="cf_handle" class="form-label">Codeforces Handle <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('cf_handle') is-invalid @enderror" id="cf_handle" name="cf_handle" value="{{ old('cf_handle') }}" required>
                                @error('cf_handle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="university" class="form-label">University</label>
                                <input type="text" class="form-control" id="university" name="university" value="{{ old('university') }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea class="form-control" id="bio" name="bio" rows="4" placeholder="Tell us about yourself...">{{ old('bio') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="profile_picture" class="form-label">Profile Picture URL</label>
                            <input type="text" class="form-control" id="profile_picture" name="profile_picture" value="{{ old('profile_picture') }}" placeholder="https://example.com/image.jpg">
                        </div>

                        <hr>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Create User
                            </button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>