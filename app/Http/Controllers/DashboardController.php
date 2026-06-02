<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View|RedirectResponse
    {
        $user = request()->user();

        if ($user->hasAnyRole(['admin', 'provider'])) {
            return redirect('/admin');
        }

        return view('dashboard', [
            'upcomingBookings' => $user->bookings()
                ->with(['service', 'provider'])
                ->whereIn('status', [Booking::STATUS_PENDING, Booking::STATUS_APPROVED, Booking::STATUS_RESCHEDULED])
                ->orderBy('booking_date')
                ->orderBy('start_time')
                ->take(3)
                ->get(),
            'bookingHistory' => $user->bookings()
                ->with(['service', 'provider'])
                ->latest('booking_date')
                ->take(6)
                ->get(),
            'profile' => $user,
        ]);
    }
}
