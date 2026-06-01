<x-layouts.app>
    <div class="flex items-end justify-between gap-6">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-teal-700">My Bookings</p>
            <h1 class="mt-3 text-4xl font-bold text-slate-950">Track your service history</h1>
        </div>
    </div>
    <div class="mt-8 space-y-4">
        @forelse($bookings as $booking)
            <x-ui.booking-card :booking="$booking" />
        @empty
            <x-ui.empty-state title="No bookings yet" description="Browse services and create your first booking." />
        @endforelse
    </div>
    <div class="mt-8">
        {{ $bookings->links() }}
    </div>
</x-layouts.app>
