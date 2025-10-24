<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Friend;
use App\Models\User;

class FriendController extends Controller
{
    /**
     * Display followers of a user
     */
    public function followers(User $user)
    {
        // Get followers using raw SQL with pagination
        $perPage = 20;
        $page = request()->get('page', 1);
        $offset = ($page - 1) * $perPage;
        
        $followersData = \DB::select("
            SELECT u.* FROM users u
            INNER JOIN friends f ON u.user_id = f.user_id
            WHERE f.friend_id = ?
            LIMIT ? OFFSET ?
        ", [$user->user_id, $perPage, $offset]);
        
        $totalFollowers = \DB::select('
            SELECT COUNT(*) as total FROM friends
            WHERE friend_id = ?
        ', [$user->user_id])[0]->total;
        
        $followers = User::hydrate($followersData);
        
        // Create pagination manually
        $followers = new \Illuminate\Pagination\LengthAwarePaginator(
            $followers,
            $totalFollowers,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        return view('friend.followers', [
            'user' => $user,
            'followers' => $followers,
        ]);
    }

    /**
     * Display following list of a user
     */
    public function followings(User $user)
    {
        // Get following using raw SQL with pagination
        $perPage = 20;
        $page = request()->get('page', 1);
        $offset = ($page - 1) * $perPage;
        
        $followingData = \DB::select("
            SELECT u.* FROM users u
            INNER JOIN friends f ON u.user_id = f.friend_id
            WHERE f.user_id = ?
            LIMIT ? OFFSET ?
        ", [$user->user_id, $perPage, $offset]);
        
        $totalFollowing = \DB::select('
            SELECT COUNT(*) as total FROM friends
            WHERE user_id = ?
        ', [$user->user_id])[0]->total;
        
        $following = User::hydrate($followingData);
        
        // Create pagination manually
        $following = new \Illuminate\Pagination\LengthAwarePaginator(
            $following,
            $totalFollowing,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        
        return view('friend.followings', [
            'user' => $user,
            'following' => $following,
        ]);
    }

    /**
     * Follow a user
     */
    public function follow(User $user)
    {
        $authUser = auth()->user();
        
        // Prevent user from following themselves
        if ($authUser->user_id === $user->user_id) {
            return back()->with('error', 'You cannot follow yourself.');
        }

        // Check if already following
        $existing = \DB::select('SELECT * FROM friends WHERE user_id = ? AND friend_id = ? LIMIT 1', [
            $authUser->user_id,
            $user->user_id
        ]);
        
        if (!empty($existing)) {
            return back()->with('info', 'You are already following this user.');
        }

        // Create follow relationship using raw SQL
        \DB::insert('INSERT INTO friends (user_id, friend_id, is_friend) VALUES (?, ?, 1)', [
            $authUser->user_id,
            $user->user_id
        ]);

        // Update follower count
        \DB::update('UPDATE users SET followers_count = followers_count + 1 WHERE user_id = ?', [$user->user_id]);

        return back()->with('success', 'You are now following ' . $user->name . '.');
    }

    /**
     * Unfollow a user
     */
    public function unfollow(User $user)
    {
        $authUser = auth()->user();

        // Remove follow relationship using raw SQL
        \DB::delete('DELETE FROM friends WHERE user_id = ? AND friend_id = ?', [
            $authUser->user_id,
            $user->user_id
        ]);

        // Update follower count
        \DB::update('UPDATE users SET followers_count = GREATEST(followers_count - 1, 0) WHERE user_id = ?', [$user->user_id]);

        return back()->with('success', 'You have unfollowed ' . $user->name . '.');
    }
}
