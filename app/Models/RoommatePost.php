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
        'max_roommates',
        'is_open',
    ];

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public function preferences()
    {
        return $this->hasMany(Preference::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'std_id');
    }

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    public function roommates()
    {
        return $this->hasMany(Roommate::class, 'post_id');
    }
    public function acceptedCount()
    {
        return $this->roommates()->where('status', 'accepted')->count();
    }

}
