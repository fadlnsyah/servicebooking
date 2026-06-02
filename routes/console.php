<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingReminderMail;
use App\Models\Booking;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('bookings:send-reminders {--date= : Send reminders for a specific booking date}', function (): int {
    $date = $this->option('date') ?: now()->addDay()->toDateString();

    $bookings = Booking::query()
        ->with(['service', 'provider'])
        ->whereIn('status', [Booking::STATUS_APPROVED, Booking::STATUS_RESCHEDULED])
        ->whereDate('booking_date', $date)
        ->whereNull('reminder_sent_at')
        ->get();

    $bookings->each(function (Booking $booking): void {
        Mail::to($booking->customer_email)->queue(new BookingReminderMail($booking));
        $booking->forceFill(['reminder_sent_at' => now()])->save();
    });

    $this->info("Queued {$bookings->count()} booking reminder emails for {$date}.");

    return 0;
})->purpose('Queue reminder emails for upcoming approved bookings');
