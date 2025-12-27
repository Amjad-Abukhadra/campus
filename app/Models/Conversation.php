<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_one_id',
        'user_two_id',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    /**
     * Get the other user in the conversation.
     */
    public function getOtherUserAttribute()
    {
        return auth()->id() === $this->user_one_id ? $this->userTwo : $this->userOne;
    }

    /**
     * Scope to find conversation between two users.
     */
    public function scopeBetween($query, $user1, $user2)
    {
        return $query->where(function ($q) use ($user1, $user2) {
            $q->where('user_one_id', $user1)->where('user_two_id', $user2);
        })->orWhere(function ($q) use ($user1, $user2) {
            $q->where('user_one_id', $user2)->where('user_two_id', $user1);
        });
    }
}
