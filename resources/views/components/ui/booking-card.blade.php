@props(['booking'])

<x-ui.card class="p-6">
    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">{{ $booking->booking_code }}</p>
            <h3 class="mt-2 text-xl font-bold text-slate-950">{{ $booking->service->name }}</h3>
            <p class="mt-2 text-sm text-slate-500">{{ $booking->booking_date->format('d M Y') }} • {{ \Illuminate\Support\Str::of($booking->start_time)->substr(0, 5) }}</p>
        </div>
        <div class="flex items-center gap-3">
            <x-ui.badge :value="$booking->status" />
            <a href="{{ route('bookings.show', $booking) }}" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700">Booking Detail</a>
        </div>
    </div>
</x-ui.card>
