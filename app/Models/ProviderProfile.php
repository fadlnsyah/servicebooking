<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProviderProfile extends Model
{
    /** @use HasFactory<\Database\Factories\ProviderProfileFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'phone',
        'status',
        'availability_notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
