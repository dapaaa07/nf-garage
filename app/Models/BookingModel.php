<?php

namespace App\Models; // <-- Periksa ini

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // <-- Periksa ini

class BookingModel extends Model // <-- Periksa ini
{
    use HasFactory;
    protected $table = 'bookings';

    // Pastikan properti $fillable juga sudah ada
    protected $fillable = [
        'user_id',
        'booking_code',
        'booking_date',
        'status',
        'vehicle_description',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
