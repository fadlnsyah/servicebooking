<x-layouts.app>
    <x-ui.card class="mx-auto max-w-3xl p-10 text-center">
        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-emerald-100 text-3xl text-emerald-700">✓</div>
        <h1 class="mt-6 text-4xl font-bold text-slate-950">Your booking has been submitted successfully</h1>
        <p class="mt-3 text-slate-500">Booking code {{ $booking->booking_code }}</p>
        <div class="mt-10 grid gap-4 text-left sm:grid-cols-2">
            <x-ui.card class="p-5"><p class="text-sm text-slate-500">Service</p><p class="mt-2 font-bold text-slate-950">{{ $booking->service->name }}</p></x-ui.card>
            <x-ui.card class="p-5"><p class="text-sm text-slate-500">Customer</p><p class="mt-2 font-bold text-slate-950">{{ $booking->customer_name }}</p></x-ui.card>
            <x-ui.card class="p-5"><p class="text-sm text-slate-500">Date and time</p><p class="mt-2 font-bold text-slate-950">{{ $booking->booking_date->format('d M Y') }} • {{ \Illuminate\Support\Str::of($booking->start_time)->substr(0, 5) }}</p></x-ui.card>
            <x-ui.card class="p-5"><p class="text-sm text-slate-500">Payment</p><p class="mt-2 font-bold text-slate-950">{{ \Illuminate\Support\Str::headline(str_replace('_', ' ', $booking->payment_method)) }}</p></x-ui.card>
        </div>
        <div class="mt-10 flex flex-col justify-center gap-4 sm:flex-row">
            <a href="{{ route('bookings.show', $booking) }}" class="rounded-full bg-teal-700 px-6 py-4 text-sm font-semibold text-white">View My Booking</a>
            <a href="{{ route('home') }}" class="rounded-full border border-slate-200 px-6 py-4 text-sm font-semibold text-slate-700">Back to Home</a>
        </div>
    </x-ui.card>
</x-layouts.app>
