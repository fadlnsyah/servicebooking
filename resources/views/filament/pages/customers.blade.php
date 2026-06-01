<x-filament-panels::page>
    <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.25em] text-gray-500">Customer</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.25em] text-gray-500">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.25em] text-gray-500">Phone</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($customers as $customer)
                    <tr>
                        <td class="px-6 py-4 font-semibold text-gray-950">{{ $customer->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $customer->email }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $customer->phone }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-filament-panels::page>
