<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoommatePost extends Model
{
    use HasFactory;

    protected $fillable = [
        'std_id',
        'apartment_id',
        'title',
        'description',
        'cleanliness_level',
        'smoking',
    ];

    
}
