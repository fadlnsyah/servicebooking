<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingActivity extends Model
{
    /** @use HasFactory<\Database\Factories\BookingActivityFactory> */
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'user_id',
        'action',
        'description',
        'old_status',
        'new_status',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
