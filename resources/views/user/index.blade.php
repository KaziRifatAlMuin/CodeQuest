<!DOCTYPE html>
<html>
<head>
    <title>Users List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Users List</h2>
        <a href="{{route('users.create')}}" class="btn btn-primary mb-3">Add New User</a>
        
        <!-- Success Message -->
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>CF Handle</th>
                    <th>CF Max Rating</th>
                    <th>Country</th>
                    <th>University</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{$user->user_id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->cf_handle}}</td>
                    <td>{{$user->cf_max_rating}}</td>
                    <td>{{$user->country ?? 'N/A'}}</td>
                    <td>{{$user->university ?? 'N/A'}}</td>
                    <td>
                        <a href="{{route('users.show', $user)}}" class="btn btn-info btn-sm">View</a>
                        <a href="{{route('users.edit', $user)}}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{route('users.destroy', $user)}}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                        </form>
                    </td>
                </tr>
             @endforeach  
            </tbody>
        </table>
    </div>