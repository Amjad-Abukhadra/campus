<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = ['std_id', 'apartment_id', 'status', 'payment_status', 'payment_id', 'payment_amount', 'paid_at', 'cancellation_deadline'];

    protected $casts = [
        'paid_at' => 'datetime',
        'cancellation_deadline' => 'datetime',
    ];

    public function canCancel()
    {
        return $this->payment_status === 'paid'
            && $this->cancellation_deadline
            && now()->isBefore($this->cancellation_deadline);
    }

    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'std_id');
    }

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}
