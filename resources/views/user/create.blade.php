<!DOCTYPE html>
<html>
<head>
    <title>Create User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Create User</h2>
        
        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{route('users.store')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email: <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label for="password">Password: <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="password" name="password" required>
                <small class="form-text text-muted">Minimum 8 characters</small>
            </div>

            <div class="form-group">
                <label for="cf_handle">Codeforces Handle: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="cf_handle" name="cf_handle" value="{{ old('cf_handle') }}" required>
            </div>

            <div class="form-group">
                <label for="country">Country:</label>
                <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}">
            </div>
            <div class="form-group">
                <label for="university">University:</label>
                <input type="text" class="form-control" id="university" name="university" value="{{ old('university') }}">
            </div>
            <div class="form-group">
                <label for="bio">Bio:</label>
                <textarea class="form-control" id="bio" name="bio" rows="3">{{ old('bio') }}</textarea>
            </div>

            <div class="form-group">
                <label for="profile_picture">Profile Picture URL:</label>
                <input type="text" class="form-control" id="profile_picture" name="profile_picture" value="{{ old('profile_picture') }}">
            </div>

            <button type="submit" class="btn btn-primary">Create User</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
        </form>
    </div>
</body>
</html>