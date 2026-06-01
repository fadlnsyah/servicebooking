<x-mail::message>
# Booking Submitted Successfully

Your booking has been submitted successfully and is now waiting for confirmation.

- Booking Code: {{ $booking->booking_code }}
- Service: {{ $booking->service->name }}
- Date: {{ $booking->booking_date->format('d M Y') }}
- Time: {{ \Illuminate\Support\Str::of($booking->start_time)->substr(0, 5) }}
- Status: {{ \Illuminate\Support\Str::headline($booking->status) }}
- Payment: {{ \Illuminate\Support\Str::headline(str_replace('_', ' ', $booking->payment_method)) }}

<x-mail::button :url="route('bookings.success', $booking)">
View My Booking
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
