<?php

namespace App\Http\Controllers;

use App\Http\Requests\RescheduleBookingRequest;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Booking;
use App\Services\BookingWorkflowService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MyBookingController extends Controller
{
    public function index(): View
    {
        return view('pages.bookings.index', [
            'bookings' => request()->user()->bookings()->with(['service', 'provider'])->latest('booking_date')->paginate(10),
        ]);
    }

    public function show(Booking $booking): View
    {
        $this->authorize('view', $booking);

        return view('pages.bookings.show', [
            'booking' => $booking->load(['service.category', 'provider', 'activities.user', 'review']),
        ]);
    }

    public function cancel(Booking $booking, BookingWorkflowService $workflow): RedirectResponse
    {
        $this->authorize('cancel', $booking);

        $workflow->updateStatus(
            $booking,
            Booking::STATUS_CANCELLED,
            request()->user(),
            'cancelled',
            'Booking cancelled by customer.'
        );

        return back()->with('status', 'Booking cancelled successfully.');
    }

    public function reschedule(RescheduleBookingRequest $request, Booking $booking, BookingWorkflowService $workflow): RedirectResponse
    {
        $this->authorize('reschedule', $booking);

        $workflow->reschedule($booking, $request->validated(), $request->user());

        return back()->with('status', 'Booking rescheduled successfully.');
    }

    public function review(StoreReviewRequest $request, Booking $booking): RedirectResponse
    {
        $this->authorize('review', $booking);

        $booking->review()->updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'user_id' => $request->user()->id,
                'service_id' => $booking->service_id,
                'rating' => $request->integer('rating'),
                'comment' => $request->string('comment')->value(),
            ],
        );

        $service = $booking->service;
        $service->update([
            'reviews_count' => $service->reviews()->count(),
            'rating' => round((float) $service->reviews()->avg('rating'), 2),
        ]);

        return back()->with('status', 'Review submitted successfully.');
    }
}
