<x-filament-panels::page>
    <div class="space-y-6">
        <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-900 sm:p-6">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-primary-600">{{ $roleLabel }}</p>
                    <h2 class="mt-1 text-xl font-semibold text-gray-950 dark:text-white">Reporting overview</h2>
                </div>

                <div class="flex flex-col gap-3 lg:items-end">
                    <form method="GET" class="grid gap-3 sm:grid-cols-[minmax(0,1fr)_minmax(0,1fr)_auto_auto]">
                        <label class="text-sm text-gray-700 dark:text-gray-200">
                            <span class="mb-1 block font-medium">Start date</span>
                            <input type="date" name="start_date" value="{{ $filters['start_date'] }}" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-950 shadow-sm dark:border-gray-700 dark:bg-gray-950 dark:text-white">
                        </label>
                        <label class="text-sm text-gray-700 dark:text-gray-200">
                            <span class="mb-1 block font-medium">End date</span>
                            <input type="date" name="end_date" value="{{ $filters['end_date'] }}" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-950 shadow-sm dark:border-gray-700 dark:bg-gray-950 dark:text-white">
                        </label>
                        <button class="self-end rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm">Apply</button>
                        <a href="{{ url()->current() }}" class="self-end rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm dark:border-gray-700 dark:text-gray-200">Reset</a>
                    </form>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.reports.export.pdf', request()->only(['start_date', 'end_date'])) }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm dark:border-gray-700 dark:text-gray-200">Export PDF</a>
                        <a href="{{ route('admin.reports.export.excel', request()->only(['start_date', 'end_date'])) }}" class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm">Export Excel</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach([
                ['label' => 'Total Bookings', 'value' => $totals['bookings']],
                ['label' => 'Total Revenue', 'value' => format_rupiah($totals['revenue'])],
                ['label' => 'Completed Services', 'value' => $totals['completed']],
                ['label' => 'Cancelled Bookings', 'value' => $totals['cancelled']],
                ['label' => 'Customers', 'value' => $totals['customers']],
                ['label' => 'Services', 'value' => $totals['services']],
            ] as $item)
                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $item['label'] }}</p>
                    <p class="mt-2 text-2xl font-semibold text-gray-950 dark:text-white">{{ $item['value'] }}</p>
                </div>
            @endforeach
        </section>

        <section class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <h3 class="text-base font-semibold text-gray-950 dark:text-white">Booking Status Distribution</h3>
                <div class="mt-4 divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach($statusBreakdown as $label => $count)
                        <div class="flex items-center justify-between py-3">
                            <span class="text-sm text-gray-600 dark:text-gray-300">{{ $label }}</span>
                            <span class="text-sm font-semibold text-gray-950 dark:text-white">{{ $count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <h3 class="text-base font-semibold text-gray-950 dark:text-white">Popular Services</h3>
                <div class="mt-4 divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($popularServices as $service => $count)
                        <div class="flex items-center justify-between gap-4 py-3">
                            <span class="truncate text-sm text-gray-600 dark:text-gray-300">{{ $service }}</span>
                            <span class="text-sm font-semibold text-gray-950 dark:text-white">{{ $count }}</span>
                        </div>
                    @empty
                        <p class="py-6 text-sm text-gray-500 dark:text-gray-400">No bookings available in this period.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="grid gap-6 xl:grid-cols-[0.9fr_1.1fr]">
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <h3 class="text-base font-semibold text-gray-950 dark:text-white">Monthly Booking Volume</h3>
                <div class="mt-4 divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($monthlyBookings as $month => $count)
                        <div class="flex items-center justify-between py-3">
                            <span class="text-sm text-gray-600 dark:text-gray-300">{{ $month }}</span>
                            <span class="text-sm font-semibold text-gray-950 dark:text-white">{{ $count }}</span>
                        </div>
                    @empty
                        <p class="py-6 text-sm text-gray-500 dark:text-gray-400">No monthly data available for this selection.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                <h3 class="text-base font-semibold text-gray-950 dark:text-white">Recent Booking Snapshot</h3>
                <div class="mt-4 overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-700">
                        <thead class="bg-gray-50 text-left text-gray-500 dark:bg-gray-950 dark:text-gray-400">
                            <tr>
                                <th class="whitespace-nowrap px-4 py-3 font-medium">Code</th>
                                <th class="whitespace-nowrap px-4 py-3 font-medium">Service</th>
                                <th class="whitespace-nowrap px-4 py-3 font-medium">Date</th>
                                <th class="whitespace-nowrap px-4 py-3 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-800 dark:bg-gray-900">
                            @forelse($recentBookings as $booking)
                                <tr>
                                    <td class="whitespace-nowrap px-4 py-3 font-semibold text-gray-950 dark:text-white">{{ $booking->booking_code }}</td>
                                    <td class="px-4 py-3 text-gray-600 dark:text-gray-300">{{ $booking->service->name }}</td>
                                    <td class="whitespace-nowrap px-4 py-3 text-gray-600 dark:text-gray-300">{{ $booking->booking_date->format('d M Y') }}</td>
                                    <td class="whitespace-nowrap px-4 py-3 text-gray-600 dark:text-gray-300">{{ \Illuminate\Support\Str::headline($booking->status) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">No booking data for the current filters.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</x-filament-panels::page>
