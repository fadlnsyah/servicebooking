<x-filament-panels::page>
    <div class="space-y-6">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-primary-600">{{ $roleLabel }}</p>
            <h2 class="mt-2 text-2xl font-bold text-gray-950">Interactive schedule calendar</h2>
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

        <div class="grid gap-6 xl:grid-cols-[1fr_20rem]">
            <div class="rounded-3xl border border-gray-200 bg-white p-4 shadow-sm sm:p-6">
                <div
                    id="servicebooking-calendar"
                    data-events='@json($calendarEvents)'
                    class="min-h-[680px]"
                ></div>
            </div>

            <aside class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-teal-600">Selected booking</p>
                <div id="servicebooking-calendar-detail" class="mt-5 space-y-4 text-sm text-gray-600">
                    <p class="rounded-2xl bg-gray-50 px-4 py-6 text-center">Select an event to inspect booking details.</p>
                </div>
            </aside>
        </div>
    </div>

    @vite('resources/js/filament-calendar.js')
</x-filament-panels::page>
