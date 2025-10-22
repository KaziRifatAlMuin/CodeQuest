<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Friend extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'relationship_id';
    
    protected $fillable = [
        'user_id',
        'friend_id',
        'is_friend',
    ];

    /**
     * Relationship: Get the user who is following (user_id)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Relationship: Get the user being followed (friend_id)
     */
    public function friend()
    {
        return $this->belongsTo(User::class, 'friend_id', 'user_id');
    }
}
