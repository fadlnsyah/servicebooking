<x-filament-panels::page>
    <div class="sb-page">
        <section class="sb-panel">
            <p class="sb-kicker">Customer directory</p>
            <h2 class="sb-title">Registered customers</h2>
            <p class="sb-muted">{{ $customers->count() }} customer accounts seeded or registered in the system.</p>
        </section>

        <section class="sb-panel">
            <div class="sb-table-wrap">
                <table class="sb-table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            <tr>
                                <td>
                                    <span class="sb-customer-cell">
                                        <span class="sb-avatar">{{ str($customer->name)->substr(0, 1)->upper() }}</span>
                                        {{ $customer->name }}
                                    </span>
                                </td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone ?? '-' }}</td>
                                <td>{{ $customer->created_at?->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4">No customer accounts found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-filament-panels::page>
