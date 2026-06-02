<x-filament-panels::page>
    <div class="space-y-6">
        <div class="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-primary-600">{{ $roleLabel }}</p>
                <h2 class="mt-2 text-2xl font-bold text-gray-950">Reporting overview</h2>
            </div>

            <form method="GET" class="grid gap-3 rounded-3xl border border-gray-200 bg-white p-4 shadow-sm sm:grid-cols-3">
                <label class="text-sm text-gray-600">
                    <span class="mb-2 block font-medium">Start date</span>
                    <input type="date" name="start_date" value="{{ $filters['start_date'] }}" class="w-full rounded-2xl border border-gray-200 px-4 py-3">
                </label>
                <label class="text-sm text-gray-600">
                    <span class="mb-2 block font-medium">End date</span>
                    <input type="date" name="end_date" value="{{ $filters['end_date'] }}" class="w-full rounded-2xl border border-gray-200 px-4 py-3">
                </label>
                <div class="flex items-end gap-3">
                    <button class="rounded-full bg-gray-900 px-5 py-3 text-sm font-semibold text-white">Apply</button>
                    <a href="{{ url()->current() }}" class="rounded-full border border-gray-200 px-5 py-3 text-sm font-semibold text-gray-700">Reset</a>
                </div>
            </form>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('admin.reports.export.pdf', request()->only(['start_date', 'end_date'])) }}" class="rounded-full bg-gray-900 px-5 py-3 text-sm font-semibold text-white">Export PDF</a>
            <a href="{{ route('admin.reports.export.excel', request()->only(['start_date', 'end_date'])) }}" class="rounded-full bg-teal-700 px-5 py-3 text-sm font-semibold text-white">Export Excel</a>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm"><p class="text-sm text-gray-500">Total Bookings</p><p class="mt-3 text-3xl font-bold text-gray-950">{{ $totals['bookings'] }}</p></div>
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm"><p class="text-sm text-gray-500">Total Revenue</p><p class="mt-3 text-3xl font-bold text-gray-950">{{ format_rupiah($totals['revenue']) }}</p></div>
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm"><p class="text-sm text-gray-500">Completed Services</p><p class="mt-3 text-3xl font-bold text-gray-950">{{ $totals['completed'] }}</p></div>
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm"><p class="text-sm text-gray-500">Cancelled Bookings</p><p class="mt-3 text-3xl font-bold text-gray-950">{{ $totals['cancelled'] }}</p></div>
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm"><p class="text-sm text-gray-500">Customers</p><p class="mt-3 text-3xl font-bold text-gray-950">{{ $totals['customers'] }}</p></div>
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm"><p class="text-sm text-gray-500">Services</p><p class="mt-3 text-3xl font-bold text-gray-950">{{ $totals['services'] }}</p></div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-gray-950">Booking Status Distribution</h3>
                <div class="mt-5 space-y-3">
                    @foreach($statusBreakdown as $label => $count)
                        <div class="flex items-center justify-between rounded-2xl bg-gray-50 px-4 py-3">
                            <span class="text-sm font-medium text-gray-600">{{ $label }}</span>
                            <span class="text-sm font-bold text-gray-950">{{ $count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-gray-950">Popular Services</h3>
                <div class="mt-5 space-y-3">
                    @forelse($popularServices as $service => $count)
                        <div class="flex items-center justify-between rounded-2xl bg-gray-50 px-4 py-3">
                            <span class="text-sm font-medium text-gray-600">{{ $service }}</span>
                            <span class="text-sm font-bold text-gray-950">{{ $count }}</span>
                        </div>
                    @empty
                        <p class="rounded-2xl bg-gray-50 px-4 py-6 text-sm text-gray-500">No bookings available in this period.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[0.95fr_1.05fr]">
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-gray-950">Monthly Booking Volume</h3>
                <div class="mt-5 space-y-3">
                    @forelse($monthlyBookings as $month => $count)
                        <div class="flex items-center justify-between rounded-2xl bg-gray-50 px-4 py-3">
                            <span class="text-sm font-medium text-gray-600">{{ $month }}</span>
                            <span class="text-sm font-bold text-gray-950">{{ $count }}</span>
                        </div>
                    @empty
                        <p class="rounded-2xl bg-gray-50 px-4 py-6 text-sm text-gray-500">No monthly data available for this selection.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-gray-950">Recent Booking Snapshot</h3>
                <div class="mt-5 overflow-hidden rounded-2xl border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-left text-gray-500">
                            <tr>
                                <th class="px-4 py-3 font-medium">Code</th>
                                <th class="px-4 py-3 font-medium">Service</th>
                                <th class="px-4 py-3 font-medium">Date</th>
                                <th class="px-4 py-3 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($recentBookings as $booking)
                                <tr>
                                    <td class="px-4 py-3 font-semibold text-gray-950">{{ $booking->booking_code }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $booking->service->name }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $booking->booking_date->format('d M Y') }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ \Illuminate\Support\Str::headline($booking->status) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">No booking data for the current filters.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
