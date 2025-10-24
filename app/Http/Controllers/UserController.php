<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Sorting: allow certain columns and directions via query params
        $allowedSorts = [
            'name' => 'name',
            'created' => 'created_at',
            'rating' => 'cf_max_rating',
            'solved' => 'solved_problems_count',
        ];

        $sort = request()->get('sort', 'created');
        $direction = strtolower(request()->get('direction', 'desc')) === 'asc' ? 'asc' : 'desc';

        $orderBy = $allowedSorts[$sort] ?? $allowedSorts['created'];

        // Get paginated users using raw SQL
        $perPage = 25;
        $page = request()->get('page', 1);
        $offset = ($page - 1) * $perPage;
        
        $usersData = \DB::select("
            SELECT * FROM users
            ORDER BY $orderBy $direction
            LIMIT ? OFFSET ?
        ", [$perPage, $offset]);
        
        $totalUsers = \DB::select('SELECT COUNT(*) as total FROM users')[0]->total;
        $users = User::hydrate($usersData);
        
        // Create pagination manually
        $users = new \Illuminate\Pagination\LengthAwarePaginator(
            $users,
            $totalUsers,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('user.index', compact('users', 'sort', 'direction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'cf_handle' => 'required|string|max:255|unique:users,cf_handle',
            'profile_picture' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'country' => 'nullable|string|max:255',
            'university' => 'nullable|string|max:255',
        ]);

        // Insert user using raw SQL
        \DB::insert('INSERT INTO users (name, email, password, cf_handle, profile_picture, bio, country, university, role, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())', [
            $data['name'],
            $data['email'],
            bcrypt($data['password']),
            $data['cf_handle'],
            $data['profile_picture'] ?? null,
            $data['bio'] ?? null,
            $data['country'] ?? null,
            $data['university'] ?? null,
            'user'
        ]);
        
        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Middleware handles authorization
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Middleware handles authorization
        
        // Validate incoming request data
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->user_id . ',user_id',
            'password' => 'nullable|string|min:8',
            'cf_handle' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:200',
            'country' => 'nullable|string|max:255',
            'university' => 'nullable|string|max:255',
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture && file_exists(public_path('images/profile/' . $user->profile_picture))) {
                unlink(public_path('images/profile/' . $user->profile_picture));
            }

            $file = $request->file('profile_picture');
            $filename = time() . '_' . $user->user_id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/profile'), $filename);
            $data['profile_picture'] = $filename;
        }

        // Hash the password if provided
        $password = null;
        if (!empty($data['password'])) {
            $password = bcrypt($data['password']);
        }

        // Update user using raw SQL
        if ($password) {
            \DB::update('UPDATE users SET name = ?, email = ?, password = ?, cf_handle = ?, profile_picture = COALESCE(?, profile_picture), bio = ?, country = ?, university = ?, updated_at = NOW() WHERE user_id = ?', [
                $data['name'],
                $data['email'],
                $password,
                $data['cf_handle'],
                $data['profile_picture'] ?? null,
                $data['bio'] ?? null,
                $data['country'] ?? null,
                $data['university'] ?? null,
                $user->user_id
            ]);
        } else {
            \DB::update('UPDATE users SET name = ?, email = ?, cf_handle = ?, profile_picture = COALESCE(?, profile_picture), bio = ?, country = ?, university = ?, updated_at = NOW() WHERE user_id = ?', [
                $data['name'],
                $data['email'],
                $data['cf_handle'],
                $data['profile_picture'] ?? null,
                $data['bio'] ?? null,
                $data['country'] ?? null,
                $data['university'] ?? null,
                $user->user_id
            ]);
        }
        
        return redirect()->route('user.show', $user->user_id)->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Middleware handles authorization
        
        // Delete profile picture if exists
        if ($user->profile_picture && file_exists(public_path('images/profile/' . $user->profile_picture))) {
            unlink(public_path('images/profile/' . $user->profile_picture));
        }

        // Delete related records first
        \DB::delete('DELETE FROM userproblems WHERE user_id = ?', [$user->user_id]);
        \DB::delete('DELETE FROM editorials WHERE author_id = ?', [$user->user_id]);
        \DB::delete('DELETE FROM friends WHERE user_id = ? OR friend_id = ?', [$user->user_id, $user->user_id]);
        
        // Delete the user
        \DB::delete('DELETE FROM users WHERE user_id = ?', [$user->user_id]);
        
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Display leaderboard - accessible to everyone (guests and authenticated users)
     */
    public function leaderboard()
    {
        // Fetch users sorted by cf_max_rating (descending) using raw SQL
        $perPage = 50;
        $page = request()->get('page', 1);
        $offset = ($page - 1) * $perPage;
        
        $usersData = \DB::select("
            SELECT * FROM users
            ORDER BY cf_max_rating DESC
            LIMIT ? OFFSET ?
        ", [$perPage, $offset]);
        
        $totalUsers = \DB::select('SELECT COUNT(*) as total FROM users')[0]->total;
        $users = User::hydrate($usersData);
        
        // Create pagination manually
        $users = new \Illuminate\Pagination\LengthAwarePaginator(
            $users,
            $totalUsers,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        return view('user.leaderboard', compact('users'));
    }
}
