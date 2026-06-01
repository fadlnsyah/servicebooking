<x-layouts.public>
    <section id="home" class="overflow-hidden bg-[radial-gradient(circle_at_top_right,_rgba(37,99,235,0.16),_transparent_36%),radial-gradient(circle_at_top_left,_rgba(15,118,110,0.18),_transparent_32%)]">
        <div class="container-app grid gap-12 py-16 lg:grid-cols-[1.05fr_0.95fr] lg:py-24">
            <div class="flex flex-col justify-center">
                <p class="w-fit rounded-full bg-teal-50 px-4 py-2 text-xs font-bold uppercase tracking-[0.3em] text-teal-700">Smart Scheduling Platform</p>
                <h1 class="mt-6 text-5xl font-extrabold leading-tight text-slate-950 sm:text-6xl">Book Trusted Services Anytime, Anywhere</h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600">A simple online booking platform for managing appointments, customers, and service schedules.</p>
                <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                    <a href="{{ route('services.index') }}" class="rounded-full bg-teal-700 px-6 py-4 text-center text-sm font-semibold text-white shadow-xl shadow-teal-700/20">Book a Service</a>
                    <a href="#how-it-works" class="rounded-full border border-slate-200 bg-white px-6 py-4 text-center text-sm font-semibold text-slate-700">How It Works</a>
                </div>
                <div class="mt-10 grid gap-4 sm:grid-cols-3">
                    <x-ui.stat-card label="Services" :value="$stats['services']" hint="Portfolio-ready demo data" />
                    <x-ui.stat-card label="Bookings" :value="$stats['bookings']" hint="Structured booking workflow" />
                    <x-ui.stat-card label="Customers" :value="$stats['customers']" hint="Seeded with local personas" />
                </div>
            </div>
            <div class="card-surface p-6 sm:p-8">
                <div class="flex items-center justify-between border-b border-slate-200 pb-5">
                    <div>
                        <p class="text-sm font-semibold text-teal-700">Weekly Schedule</p>
                        <h2 class="mt-2 text-2xl font-bold text-slate-950">15 May 2026 - 16 May 2026</h2>
                    </div>
                    <div class="rounded-2xl bg-teal-50 px-4 py-2 text-sm font-semibold text-teal-700">Today</div>
                </div>
                <div class="mt-6 grid grid-cols-3 gap-4">
                    <div class="rounded-3xl bg-slate-50 p-5">
                        <p class="text-sm text-slate-500">09:00</p>
                        <p class="mt-3 font-bold text-slate-950">Haircut & Styling</p>
                        <p class="mt-2 text-sm text-slate-500">Sarah Amelia</p>
                    </div>
                    <div class="rounded-3xl bg-blue-50 p-5">
                        <p class="text-sm text-blue-700">13:30</p>
                        <p class="mt-3 font-bold text-slate-950">Studio Photography</p>
                        <p class="mt-2 text-sm text-slate-500">Nabila Aulia</p>
                    </div>
                    <div class="rounded-3xl bg-amber-50 p-5">
                        <p class="text-sm text-amber-700">16:00</p>
                        <p class="mt-3 font-bold text-slate-950">AC Maintenance</p>
                        <p class="mt-2 text-sm text-slate-500">Dimas Prasetyo</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container-app py-16">
        <div class="flex items-end justify-between gap-6">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-teal-700">Categories</p>
                <h2 class="mt-3 text-3xl font-bold text-slate-950">Browse service categories</h2>
            </div>
        </div>
        <div class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach($categories as $category)
                <x-ui.card class="p-6">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-teal-700">{{ $category->icon }}</p>
                    <h3 class="mt-4 text-xl font-bold text-slate-950">{{ $category->name }}</h3>
                    <p class="mt-2 text-sm text-slate-500">{{ $category->description }}</p>
                </x-ui.card>
            @endforeach
        </div>
    </section>

    <section id="how-it-works" class="bg-white py-16">
        <div class="container-app">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-teal-700">How It Works</p>
            <div class="mt-8 grid gap-5 lg:grid-cols-4">
                @foreach([['01','Choose Service'],['02','Select Date'],['03','Confirm Booking'],['04','Get Updates']] as [$step, $title])
                    <x-ui.card class="p-6">
                        <p class="text-sm font-bold text-teal-700">{{ $step }}</p>
                        <h3 class="mt-4 text-2xl font-bold text-slate-950">{{ $title }}</h3>
                    </x-ui.card>
                @endforeach
            </div>
        </div>
    </section>

    <section id="pricing" class="container-app py-16">
        <div class="flex items-end justify-between gap-6">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-teal-700">Featured Services</p>
                <h2 class="mt-3 text-3xl font-bold text-slate-950">Popular services with Indonesian pricing</h2>
            </div>
            <a href="{{ route('services.index') }}" class="text-sm font-semibold text-teal-700">View all services</a>
        </div>
        <div class="mt-8 grid gap-6 lg:grid-cols-3">
            @foreach($featuredServices as $service)
                <x-ui.service-card :service="$service" />
            @endforeach
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="container-app grid gap-6 lg:grid-cols-3">
            @forelse($testimonials as $review)
                <x-ui.card class="p-6">
                    <p class="text-lg font-semibold text-slate-700">“{{ $review->comment ?? 'Smooth scheduling experience and clear communication from start to finish.' }}”</p>
                    <p class="mt-6 font-bold text-slate-950">{{ $review->user->name }}</p>
                    <p class="text-sm text-slate-500">{{ $review->service->name }}</p>
                </x-ui.card>
            @empty
                <x-ui.empty-state title="Testimonials will appear here" description="Seeded reviews are generated after completed bookings are reviewed." />
            @endforelse
        </div>
    </section>

    <section id="contact" class="container-app py-16">
        <div class="grid gap-8 lg:grid-cols-[1.2fr_0.8fr]">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-teal-700">FAQ</p>
                <div class="mt-6 space-y-4">
                    @foreach($faqs as $faq)
                        <x-ui.card class="p-6">
                            <h3 class="text-lg font-bold text-slate-950">{{ $faq['question'] }}</h3>
                            <p class="mt-3 text-sm leading-6 text-slate-500">{{ $faq['answer'] }}</p>
                        </x-ui.card>
                    @endforeach
                </div>
            </div>
            <x-ui.card class="p-8">
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-teal-700">Contact</p>
                <h3 class="mt-4 text-3xl font-bold text-slate-950">Need a tailored setup?</h3>
                <p class="mt-4 text-sm leading-6 text-slate-500">This demo is designed as a full-stack Laravel portfolio project and can be adapted for real business operations.</p>
                <div class="mt-8 space-y-3 text-sm text-slate-600">
                    <p>hello@servicebooking.test</p>
                    <p>021-555-2026</p>
                    <p>Jakarta, Indonesia</p>
                </div>
            </x-ui.card>
        </div>
    </section>
</x-layouts.public>
