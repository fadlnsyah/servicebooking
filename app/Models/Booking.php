<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    /** @use HasFactory<\Database\Factories\BookingFactory> */
    use HasFactory;
    use SoftDeletes;

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_RESCHEDULED = 'rescheduled';

    public const PAYMENT_METHOD_PAY_LATER = 'pay_later';
    public const PAYMENT_METHOD_MANUAL_TRANSFER = 'manual_transfer';

    public const PAYMENT_STATUS_UNPAID = 'unpaid';
    public const PAYMENT_STATUS_PAID = 'paid';
    public const PAYMENT_STATUS_REFUNDED = 'refunded';

    protected $fillable = [
        'booking_code',
        'user_id',
        'service_id',
        'provider_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'address',
        'notes',
        'booking_date',
        'start_time',
        'end_time',
        'duration_minutes',
        'price',
        'admin_fee',
        'total_price',
        'status',
        'payment_method',
        'payment_status',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
            'price' => 'integer',
            'admin_fee' => 'integer',
            'total_price' => 'integer',
            'duration_minutes' => 'integer',
        ];
    }

    public static function statusOptions(): array
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_APPROVED => 'Approved',
            self::STATUS_REJECTED => 'Rejected',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_RESCHEDULED => 'Rescheduled',
        ];
    }

    public static function paymentMethodOptions(): array
    {
        return [
            self::PAYMENT_METHOD_PAY_LATER => 'Pay Later',
            self::PAYMENT_METHOD_MANUAL_TRANSFER => 'Manual Transfer',
        ];
    }

    public static function paymentStatusOptions(): array
    {
        return [
            self::PAYMENT_STATUS_UNPAID => 'Unpaid',
            self::PAYMENT_STATUS_PAID => 'Paid',
            self::PAYMENT_STATUS_REFUNDED => 'Refunded',
        ];
    }

    public static function activeScheduleStatuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_APPROVED,
            self::STATUS_RESCHEDULED,
        ];
    }

    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        if ($user->isAdmin()) {
            return $query;
        }

        if ($user->isProvider()) {
            return $query->where('provider_id', $user->id);
        }

        return $query->where('user_id', $user->id);
    }

    public function scopeActiveSchedule(Builder $query): Builder
    {
        return $query->whereIn('status', self::activeScheduleStatuses());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(BookingActivity::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }
}
