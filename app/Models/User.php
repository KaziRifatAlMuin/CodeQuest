<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'cf_handle',
        'cf_max_rating',
        'solved_problems_count',
        'average_problem_rating',
        'profile_picture',
        'bio',
        'country',
        'university',
        'followers_count',
        'handle_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should have default values.
     *
     * @var array
     */
    protected $attributes = [
        'role' => 'user',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'handle_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the role attribute with default value.
     */
    public function getRoleAttribute($value)
    {
        return $value ?? 'user';
    }

    /**
     * Relationship: User has many Editorials (as author)
     */
    public function editorials()
    {
        return $this->hasMany(Editorial::class, 'author_id', 'user_id');
    }

    /**
     * Relationship: User has many UserProblems (tracks progress on problems)
     */
    public function userProblems()
    {
        return $this->hasMany(UserProblem::class, 'user_id', 'user_id');
    }

    /**
     * Get user's solved problems
     */
    public function solvedProblems()
    {
        return $this->hasMany(UserProblem::class, 'user_id', 'user_id')
                    ->where('status', 'solved');
    }

    /**
     * Get user's starred problems
     */
    public function starredProblems()
    {
        return $this->hasMany(UserProblem::class, 'user_id', 'user_id')
                    ->where('is_starred', true);
    }

    /**
     * Relationship: Get users that this user is following
     */
    public function following()
    {
        return $this->belongsToMany(
            User::class,
            'friends',
            'user_id',
            'friend_id',
            'user_id',
            'user_id'
        );
    }

    /**
     * Relationship: Get users who are following this user (followers)
     */
    public function followers()
    {
        return $this->belongsToMany(
            User::class,
            'friends',
            'friend_id',
            'user_id',
            'user_id',
            'user_id'
        );
    }

    /**
     * Check if this user is following another user
     */
    public function isFollowing($userId)
    {
        $result = \DB::select('SELECT COUNT(*) as total FROM friends WHERE user_id = ? AND friend_id = ?', [$this->user_id, $userId]);
        return $result[0]->total > 0;
    }

    /**
     * Check if this user is followed by another user
     */
    public function isFollowedBy($userId)
    {
        $result = \DB::select('SELECT COUNT(*) as total FROM friends WHERE user_id = ? AND friend_id = ?', [$userId, $this->user_id]);
        return $result[0]->total > 0;
    }
}
