<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Service;
use App\Services\BookingWorkflowService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function store(StoreBookingRequest $request, BookingWorkflowService $workflow): RedirectResponse
    {
        $service = Service::query()->with('provider')->findOrFail($request->integer('service_id'));
        $booking = $workflow->createBooking($request->validated(), $request->user(), $service);

        return redirect()->route('bookings.success', $booking);
    }

    public function success(Booking $booking): View
    {
        abort_unless(Auth::id() === $booking->user_id || Auth::user()?->hasRole('admin'), 403);

        return view('pages.bookings.success', [
            'booking' => $booking->load(['service', 'provider']),
        ]);
    }
}
