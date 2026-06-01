<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    public function view(User $user, Booking $booking): bool
    {
        return $booking->user_id === $user->id
            || $user->isAdmin()
            || ($user->isProvider() && $booking->provider_id === $user->id);
    }

    public function cancel(User $user, Booking $booking): bool
    {
        return $booking->user_id === $user->id
            && in_array($booking->status, [Booking::STATUS_PENDING, Booking::STATUS_APPROVED, Booking::STATUS_RESCHEDULED], true);
    }

    public function reschedule(User $user, Booking $booking): bool
    {
        return $booking->user_id === $user->id
            && in_array($booking->status, [Booking::STATUS_PENDING, Booking::STATUS_APPROVED, Booking::STATUS_RESCHEDULED], true);
    }

    public function review(User $user, Booking $booking): bool
    {
        return $booking->user_id === $user->id
            && $booking->status === Booking::STATUS_COMPLETED;
    }
}
