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
        $followers = $user->followers()->paginate(20);
        
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
        $following = $user->following()->paginate(20);
        
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
        if ($authUser->isFollowing($user->user_id)) {
            return back()->with('info', 'You are already following this user.');
        }

        // Create follow relationship
        Friend::create([
            'user_id' => $authUser->user_id,
            'friend_id' => $user->user_id,
            'is_friend' => true,
        ]);

        // Update follower count
        $user->increment('followers_count');

        return back()->with('success', 'You are now following ' . $user->name . '.');
    }

    /**
     * Unfollow a user
     */
    public function unfollow(User $user)
    {
        $authUser = auth()->user();

        // Remove follow relationship
        Friend::where('user_id', $authUser->user_id)
               ->where('friend_id', $user->user_id)
               ->delete();

        // Update follower count
        $user->decrement('followers_count');

        return back()->with('success', 'You have unfollowed ' . $user->name . '.');
    }
}
