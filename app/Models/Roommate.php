<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roommate extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'std_id', 'status'];

    
}
