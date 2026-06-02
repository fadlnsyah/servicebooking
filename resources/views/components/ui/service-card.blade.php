@props(['service'])

<x-ui.card class="overflow-hidden p-0">
    <img src="{{ service_image_url($service->image) }}" alt="{{ $service->name }}" class="h-48 w-full object-cover">
    <div class="space-y-4 p-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-teal-700">{{ $service->category->name }}</p>
                <h3 class="mt-2 text-xl font-bold text-slate-950">{{ $service->name }}</h3>
            </div>
            <span class="rounded-full bg-amber-50 px-3 py-1 text-sm font-semibold text-amber-700">{{ number_format($service->rating, 1) }}</span>
        </div>
        <p class="text-sm leading-6 text-slate-500">{{ $service->short_description }}</p>
        <div class="flex items-center justify-between text-sm text-slate-500">
            <span>{{ $service->duration_minutes }} min</span>
            <span>{{ $service->reviews_count }} reviews</span>
        </div>
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Starting at</p>
                <p class="text-2xl font-extrabold text-slate-950">{{ format_rupiah($service->price) }}</p>
            </div>
            <a href="{{ route('services.show', $service) }}" class="rounded-full bg-teal-700 px-5 py-3 text-sm font-semibold text-white">Book Now</a>
        </div>
    </div>
</x-ui.card>
