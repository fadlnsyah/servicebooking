<x-filament-panels::page>
    <div class="sb-page">
        <section class="sb-panel">
            <p class="sb-kicker">{{ $roleLabel }}</p>
            <h2 class="sb-title">Schedule calendar</h2>
        </section>

        <section class="sb-stat-grid">
            @foreach([
                ['label' => 'Scheduled Days', 'value' => $totals['days'], 'class' => ''],
                ['label' => 'Active Bookings', 'value' => $totals['bookings'], 'class' => ''],
                ['label' => 'Pending', 'value' => $totals['pending'], 'class' => 'sb-stat-value-warning'],
                ['label' => 'Approved', 'value' => $totals['approved'], 'class' => 'sb-stat-value-info'],
            ] as $item)
                <div class="sb-stat-card">
                    <p class="sb-stat-label">{{ $item['label'] }}</p>
                    <p class="sb-stat-value {{ $item['class'] }}">{{ $item['value'] }}</p>
                </div>
            @endforeach
        </section>

        <section class="sb-calendar-layout">
            <div class="sb-panel sb-calendar-card servicebooking-calendar-shell">
                <div id="servicebooking-calendar" data-events='@json($calendarEvents)'></div>
            </div>

            <aside class="sb-panel sb-detail-card">
                <p class="sb-kicker">Selected booking</p>
                <div id="servicebooking-calendar-detail" class="sb-detail-list">
                    <p class="sb-detail-empty">Select an event to inspect booking details.</p>
                </div>
            </aside>
        </section>
    </div>

    @vite('resources/js/filament-calendar.js')
</x-filament-panels::page>
