<x-mail::message>
# Booking Reminder

This is a reminder for your upcoming booking.

- Booking Code: {{ $booking->booking_code }}
- Service: {{ $booking->service->name }}
- Date: {{ $booking->booking_date->format('d M Y') }}
- Time: {{ \Illuminate\Support\Str::of($booking->start_time)->substr(0, 5) }} - {{ \Illuminate\Support\Str::of($booking->end_time)->substr(0, 5) }}
- Provider: {{ $booking->provider?->name ?? 'Provider pending' }}
- Status: {{ \Illuminate\Support\Str::headline($booking->status) }}

<x-mail::button :url="route('bookings.show', $booking)">
View Booking Details
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
