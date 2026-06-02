<x-filament-panels::page>
    <div class="space-y-6">
        <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <p class="text-xs font-semibold uppercase tracking-wide text-primary-600">Customer directory</p>
            <h2 class="mt-1 text-xl font-semibold text-gray-950 dark:text-white">Registered customers</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $customers->count() }} customer accounts seeded or registered in the system.</p>
        </section>

        <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-700">
                    <thead class="bg-gray-50 text-left text-gray-500 dark:bg-gray-950 dark:text-gray-400">
                        <tr>
                            <th class="whitespace-nowrap px-4 py-3 font-medium">Customer</th>
                            <th class="whitespace-nowrap px-4 py-3 font-medium">Email</th>
                            <th class="whitespace-nowrap px-4 py-3 font-medium">Phone</th>
                            <th class="whitespace-nowrap px-4 py-3 font-medium">Joined</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($customers as $customer)
                            <tr>
                                <td class="whitespace-nowrap px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary-50 text-sm font-semibold text-primary-700">{{ str($customer->name)->substr(0, 1)->upper() }}</span>
                                        <span class="font-semibold text-gray-950 dark:text-white">{{ $customer->name }}</span>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-gray-600 dark:text-gray-300">{{ $customer->email }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-gray-600 dark:text-gray-300">{{ $customer->phone ?? '-' }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-gray-600 dark:text-gray-300">{{ $customer->created_at?->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">No customer accounts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-filament-panels::page>
