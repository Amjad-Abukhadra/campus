<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = ['std_id', 'apartment_id', 'status'];

    public function student()
    {
        return $this->belongsTo(User::class, 'std_id');
    }

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}
