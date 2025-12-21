<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    use HasFactory;

    protected $fillable = ['roommate_post_id', 'name', 'description'];

    public function roommatePost()
    {
        return $this->belongsTo(RoommatePost::class);
    }
}
