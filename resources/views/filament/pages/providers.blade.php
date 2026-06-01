<x-filament-panels::page>
    <div class="grid gap-4 lg:grid-cols-2">
        @foreach($providers as $provider)
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="text-xl font-bold text-gray-950">{{ $provider->name }}</h3>
                <p class="mt-2 text-sm text-gray-500">{{ $provider->email }}</p>
                <p class="mt-2 text-sm text-gray-500">{{ $provider->phone }}</p>
                <p class="mt-4 text-sm text-gray-600">{{ $provider->providerProfile?->bio }}</p>
                <p class="mt-4 inline-flex rounded-full bg-teal-50 px-3 py-1 text-xs font-semibold text-teal-700">{{ $provider->providerProfile?->status ?? 'available' }}</p>
            </div>
        @endforeach
    </div>
</x-filament-panels::page>
