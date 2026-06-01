<x-filament-panels::page>
    <div class="space-y-6">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-primary-600">{{ $roleLabel }}</p>
            <h2 class="mt-2 text-2xl font-bold text-gray-950">Schedule board</h2>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-gray-500">Scheduled Days</p>
                <p class="mt-3 text-3xl font-bold text-gray-950">{{ $totals['days'] }}</p>
            </div>
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-gray-500">Active Bookings</p>
                <p class="mt-3 text-3xl font-bold text-gray-950">{{ $totals['bookings'] }}</p>
            </div>
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-gray-500">Pending</p>
                <p class="mt-3 text-3xl font-bold text-amber-600">{{ $totals['pending'] }}</p>
            </div>
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-gray-500">Approved</p>
                <p class="mt-3 text-3xl font-bold text-blue-600">{{ $totals['approved'] }}</p>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            @forelse($bookingsByDate as $day)
                <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-teal-600">{{ $day['label'] }}</p>
                            <h3 class="mt-2 text-lg font-bold text-gray-950">{{ $day['items']->count() }} bookings</h3>
                        </div>
                    </div>

                    <div class="mt-5 space-y-4">
                        @foreach($day['items'] as $booking)
                            <div class="rounded-2xl bg-gray-50 p-4">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="font-semibold text-gray-950">{{ $booking->service->name }}</p>
                                        <p class="mt-1 text-sm text-gray-500">{{ substr($booking->start_time, 0, 5) }} - {{ substr($booking->end_time, 0, 5) }}</p>
                                        <p class="mt-1 text-sm text-gray-500">Customer: {{ $booking->user?->name ?? 'Unknown' }}</p>
                                        <p class="mt-1 text-sm text-gray-500">Provider: {{ $booking->provider?->name ?? 'Provider pending' }}</p>
                                    </div>
                                    <p class="inline-flex rounded-full bg-white px-3 py-1 text-xs font-semibold text-gray-700 shadow-sm">{{ \Illuminate\Support\Str::headline($booking->status) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="rounded-3xl border border-dashed border-gray-300 bg-white p-10 text-center text-sm text-gray-500 xl:col-span-2">
                    No scheduled bookings found for the current view.
                </div>
            @endforelse
        </div>
    </div>
</x-filament-panels::page>
