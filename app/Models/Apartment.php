<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'landlord_id',
        'title',
        'location',
        'rent',
        'image',
        'description'
    ];
    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
