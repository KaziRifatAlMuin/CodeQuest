<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit User</h2>
        
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

        <form action="{{route('users.update', $user->user_id)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" value='{{old("name", $user->name)}}' name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email: <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" value='{{old("email", $user->email)}}' name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password">
                <small class="form-text text-muted">Leave blank to keep current password. Minimum 8 characters if changing.</small>
            </div>
            <div class="form-group">
                <label for="cf_handle">Codeforces Handle: <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="cf_handle" value='{{old("cf_handle", $user->cf_handle)}}' name="cf_handle" required>
            </div>
            <div class="form-group">
                <label for="country">Country:</label>
                <input type="text" class="form-control" id="country" value='{{old("country", $user->country)}}' name="country">
            </div>
            <div class="form-group">
                <label for="university">University:</label>
                <input type="text" class="form-control" id="university" value='{{old("university", $user->university)}}' name="university">
            </div>
            <div class="form-group">
                <label for="bio">Bio:</label>
                <textarea class="form-control" id="bio" name="bio" rows="3">{{old("bio", $user->bio)}}</textarea>
            </div>
            <div class="form-group">
                <label for="profile_picture">Profile Picture URL:</label>
                <input type="text" class="form-control" id="profile_picture" value='{{old("profile_picture", $user->profile_picture)}}' name="profile_picture">
            </div>
            <button type="submit" class="btn btn-primary">Update User</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
        </form>
    </div>
</body>
</html>