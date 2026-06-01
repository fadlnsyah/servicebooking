<x-layouts.app>
    <div class="flex flex-col gap-10">
        <div class="flex flex-col gap-3">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-teal-700">Customer Dashboard</p>
            <h1 class="text-4xl font-bold text-slate-950">Welcome back, {{ $profile->name }}</h1>
            <p class="text-slate-500">Manage your booking history, upcoming schedules, and profile information.</p>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <x-ui.stat-card label="Upcoming Bookings" :value="$upcomingBookings->count()" hint="Pending, approved, or rescheduled" />
            <x-ui.stat-card label="Booking History" :value="$bookingHistory->count()" hint="Recent customer activity" />
            <x-ui.stat-card label="Profile Phone" :value="$profile->phone ?? '-'" hint="Keep contact info updated" />
        </div>

        <div class="grid gap-8 lg:grid-cols-[1.15fr_0.85fr]">
            <div class="space-y-4">
                <h2 class="text-2xl font-bold text-slate-950">Upcoming bookings</h2>
                @forelse($upcomingBookings as $booking)
                    <x-ui.booking-card :booking="$booking" />
                @empty
                    <x-ui.empty-state title="No upcoming bookings" description="You do not have any scheduled appointments right now." />
                @endforelse
            </div>
            <x-ui.card class="p-8">
                <h2 class="text-2xl font-bold text-slate-950">Profile information</h2>
                <dl class="mt-6 space-y-4 text-sm text-slate-600">
                    <div><dt class="font-semibold text-slate-950">Full name</dt><dd class="mt-1">{{ $profile->name }}</dd></div>
                    <div><dt class="font-semibold text-slate-950">Email</dt><dd class="mt-1">{{ $profile->email }}</dd></div>
                    <div><dt class="font-semibold text-slate-950">Phone number</dt><dd class="mt-1">{{ $profile->phone }}</dd></div>
                </dl>
            </x-ui.card>
        </div>

        <div class="space-y-4">
            <h2 class="text-2xl font-bold text-slate-950">Booking history</h2>
            @forelse($bookingHistory as $booking)
                <x-ui.booking-card :booking="$booking" />
            @empty
                <x-ui.empty-state title="No booking history" description="Completed and past bookings will appear here." />
            @endforelse
        </div>
    </div>
</x-layouts.app>
