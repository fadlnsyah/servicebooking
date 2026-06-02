<x-filament-panels::page>
    <div class="sb-page">
        <section class="sb-panel sb-toolbar">
            <div>
                <p class="sb-kicker">{{ $roleLabel }}</p>
                <h2 class="sb-title">Reporting overview</h2>
            </div>

            <div class="sb-toolbar-actions">
                <form method="GET" class="sb-filter-form">
                    <label class="sb-label">
                        <span>Start date</span>
                        <input type="date" name="start_date" value="{{ $filters['start_date'] }}" class="sb-input">
                    </label>
                    <label class="sb-label">
                        <span>End date</span>
                        <input type="date" name="end_date" value="{{ $filters['end_date'] }}" class="sb-input">
                    </label>
                    <button class="sb-button">Apply</button>
                    <a href="{{ url()->current() }}" class="sb-button sb-button-secondary">Reset</a>
                </form>

                <div class="sb-actions">
                    <a href="{{ route('admin.reports.export.pdf', request()->only(['start_date', 'end_date'])) }}" class="sb-button sb-button-secondary">Export PDF</a>
                    <a href="{{ route('admin.reports.export.excel', request()->only(['start_date', 'end_date'])) }}" class="sb-button">Export Excel</a>
                </div>
            </div>
        </section>

        <section class="sb-stat-grid sb-stat-grid-six">
            @foreach([
                ['label' => 'Total Bookings', 'value' => $totals['bookings']],
                ['label' => 'Total Revenue', 'value' => format_rupiah($totals['revenue'])],
                ['label' => 'Completed Services', 'value' => $totals['completed']],
                ['label' => 'Cancelled Bookings', 'value' => $totals['cancelled']],
                ['label' => 'Customers', 'value' => $totals['customers']],
                ['label' => 'Services', 'value' => $totals['services']],
            ] as $item)
                <div class="sb-stat-card">
                    <p class="sb-stat-label">{{ $item['label'] }}</p>
                    <p class="sb-stat-value">{{ $item['value'] }}</p>
                </div>
            @endforeach
        </section>

        <section class="sb-two-col">
            <div class="sb-panel">
                <h3 class="sb-title">Booking Status Distribution</h3>
                <div class="sb-list">
                    @foreach($statusBreakdown as $label => $count)
                        <div class="sb-row"><span>{{ $label }}</span><strong>{{ $count }}</strong></div>
                    @endforeach
                </div>
            </div>

            <div class="sb-panel">
                <h3 class="sb-title">Popular Services</h3>
                <div class="sb-list">
                    @forelse($popularServices as $service => $count)
                        <div class="sb-row"><span>{{ $service }}</span><strong>{{ $count }}</strong></div>
                    @empty
                        <p class="sb-muted">No bookings available in this period.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="sb-report-grid">
            <div class="sb-panel">
                <h3 class="sb-title">Monthly Booking Volume</h3>
                <div class="sb-list">
                    @forelse($monthlyBookings as $month => $count)
                        <div class="sb-row"><span>{{ $month }}</span><strong>{{ $count }}</strong></div>
                    @empty
                        <p class="sb-muted">No monthly data available for this selection.</p>
                    @endforelse
                </div>
            </div>

            <div class="sb-panel">
                <h3 class="sb-title">Recent Booking Snapshot</h3>
                <div class="sb-table-wrap">
                    <table class="sb-table">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Service</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBookings as $booking)
                                <tr>
                                    <td>{{ $booking->booking_code }}</td>
                                    <td>{{ $booking->service->name }}</td>
                                    <td>{{ $booking->booking_date->format('d M Y') }}</td>
                                    <td>{{ \Illuminate\Support\Str::headline($booking->status) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4">No booking data for the current filters.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</x-filament-panels::page>
