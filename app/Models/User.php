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
}
