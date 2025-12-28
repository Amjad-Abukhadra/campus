<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Favorite; // Added this use statement

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'landlord_id',
        'title',
        'location',
        'latitude',
        'longitude',
        'rent',
        'status',
        'image',
        'description'
    ];

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
