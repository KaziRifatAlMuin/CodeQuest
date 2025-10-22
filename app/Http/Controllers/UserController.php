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

        // Eager-load or compute solved_problems_count if needed
        $query = User::query();

        // If sorting by solved, ensure the column exists or use withCount
        if ($orderBy === 'solved_problems_count') {
            // If the raw column exists, order by it; otherwise use a subquery count
            if (!
                in_array('solved_problems_count', (new User)->getFillable())
            ) {
                $query->withCount(['solvedProblems as solved_problems_count']);
            }
        }

        $users = $query->orderBy($orderBy, $direction)->paginate(25)->appends(request()->query());

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

        // Hash the password
        $data['password'] = bcrypt($data['password']);

        // Create new user
        User::create($data);
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
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        // Update user
        $user->update($data);
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

        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Display leaderboard - accessible to everyone (guests and authenticated users)
     */
    public function leaderboard()
    {
        // Fetch users sorted by cf_max_rating (descending)
        $users = User::orderBy('cf_max_rating', 'desc')
            ->paginate(50);
        
        return view('user.leaderboard', compact('users'));
    }
}
