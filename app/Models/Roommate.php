<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roommate extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'std_id', 'status'];
    public function post()
    {
        return $this->belongsTo(RoommatePost::class, 'post_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

}
