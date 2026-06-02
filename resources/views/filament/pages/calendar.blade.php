<x-filament-panels::page>
    <div class="space-y-6">
        <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <p class="text-xs font-semibold uppercase tracking-wide text-primary-600">{{ $roleLabel }}</p>
            <h2 class="mt-1 text-xl font-semibold text-gray-950 dark:text-white">Schedule calendar</h2>
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach([
                ['label' => 'Scheduled Days', 'value' => $totals['days'], 'class' => 'text-gray-950 dark:text-white'],
                ['label' => 'Active Bookings', 'value' => $totals['bookings'], 'class' => 'text-gray-950 dark:text-white'],
                ['label' => 'Pending', 'value' => $totals['pending'], 'class' => 'text-amber-600'],
                ['label' => 'Approved', 'value' => $totals['approved'], 'class' => 'text-blue-600'],
            ] as $item)
                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $item['label'] }}</p>
                    <p class="mt-2 text-2xl font-semibold {{ $item['class'] }}">{{ $item['value'] }}</p>
                </div>
            @endforeach
        </section>

        <section class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_20rem]">
            <div class="servicebooking-calendar-shell rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900 sm:p-6">
                <div
                    id="servicebooking-calendar"
                    data-events='@json($calendarEvents)'
                    class="min-h-[620px]"
                ></div>
            </div>

            <aside class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <p class="text-xs font-semibold uppercase tracking-wide text-primary-600">Selected booking</p>
                <div id="servicebooking-calendar-detail" class="mt-5 space-y-4 text-sm text-gray-600 dark:text-gray-300">
                    <p class="rounded-lg bg-gray-50 px-4 py-6 text-center dark:bg-gray-950">Select an event to inspect booking details.</p>
                </div>
            </aside>
        </section>
    </div>

    @vite('resources/js/filament-calendar.js')
</x-filament-panels::page>
