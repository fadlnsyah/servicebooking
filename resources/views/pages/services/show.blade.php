<x-layouts.public>
    <section class="container-app py-16">
        <div class="grid gap-10 lg:grid-cols-[1.15fr_0.85fr]">
            <div>
                <div class="h-80 rounded-[2rem] bg-gradient-to-br from-teal-800 to-blue-700"></div>
                <div class="mt-6 grid gap-4 sm:grid-cols-3">
                    <div class="h-24 rounded-3xl bg-slate-200"></div>
                    <div class="h-24 rounded-3xl bg-slate-200"></div>
                    <div class="h-24 rounded-3xl bg-slate-200"></div>
                </div>
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-teal-700">{{ $service->category->name }}</p>
                <h1 class="mt-3 text-4xl font-bold text-slate-950">{{ $service->name }}</h1>
                <div class="mt-4 flex flex-wrap items-center gap-4 text-sm text-slate-500">
                    <span>{{ number_format($service->rating, 1) }} rating</span>
                    <span>{{ $service->reviews_count }} reviews</span>
                    <span>{{ $service->duration_minutes }} minutes</span>
                </div>
                <p class="mt-6 text-4xl font-extrabold text-slate-950">{{ format_rupiah($service->price) }}</p>
                <p class="mt-6 text-sm leading-7 text-slate-600">{{ $service->description }}</p>

                <div class="mt-8 grid gap-4 sm:grid-cols-2">
                    <x-ui.card class="p-5">
                        <p class="text-sm font-semibold text-slate-500">Provider</p>
                        <p class="mt-3 text-xl font-bold text-slate-950">{{ $service->provider?->name ?? 'Assigned at confirmation' }}</p>
                    </x-ui.card>
                    <x-ui.card class="p-5">
                        <p class="text-sm font-semibold text-slate-500">Available schedule</p>
                        <p class="mt-3 text-xl font-bold text-slate-950">09:00 • 13:30 • 16:00</p>
                    </x-ui.card>
                </div>

                <div class="mt-8">
                    <a href="{{ route('services.book', $service) }}" class="rounded-full bg-teal-700 px-6 py-4 text-sm font-semibold text-white">Continue Booking</a>
                </div>
            </div>
        </div>

        <section class="mt-16">
            <h2 class="text-3xl font-bold text-slate-950">Related services</h2>
            <div class="mt-6 grid gap-6 lg:grid-cols-3">
                @foreach($relatedServices as $related)
                    <x-ui.service-card :service="$related" />
                @endforeach
            </div>
        </section>
    </section>
</x-layouts.public>
