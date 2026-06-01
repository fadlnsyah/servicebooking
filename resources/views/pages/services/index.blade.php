<x-layouts.public>
    <section class="container-app py-16">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-teal-700">Services</p>
                <h1 class="mt-3 text-4xl font-bold text-slate-950">Find a service that fits your schedule</h1>
            </div>
        </div>

        <form class="card-surface mt-8 grid gap-4 p-6 lg:grid-cols-6">
            <input name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search services" class="rounded-2xl border border-slate-200 px-4 py-3 lg:col-span-2">
            <select name="category" class="rounded-2xl border border-slate-200 px-4 py-3">
                <option value="">All categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->slug }}" @selected(($filters['category'] ?? '') === $category->slug)>{{ $category->name }}</option>
                @endforeach
            </select>
            <select name="rating" class="rounded-2xl border border-slate-200 px-4 py-3">
                <option value="">Any rating</option>
                <option value="4" @selected(($filters['rating'] ?? '') === '4')>4 stars+</option>
                <option value="5" @selected(($filters['rating'] ?? '') === '5')>5 stars</option>
            </select>
            <select name="sort" class="rounded-2xl border border-slate-200 px-4 py-3">
                <option value="most_popular">Most Popular</option>
                <option value="lowest_price" @selected(($filters['sort'] ?? '') === 'lowest_price')>Lowest Price</option>
                <option value="highest_rating" @selected(($filters['sort'] ?? '') === 'highest_rating')>Highest Rating</option>
                <option value="newest" @selected(($filters['sort'] ?? '') === 'newest')>Newest</option>
            </select>
            <button class="rounded-2xl bg-teal-700 px-4 py-3 font-semibold text-white">Apply Filters</button>
        </form>

        <div class="mt-8 grid gap-6 lg:grid-cols-3">
            @forelse($services as $service)
                <x-ui.service-card :service="$service" />
            @empty
                <div class="lg:col-span-3">
                    <x-ui.empty-state title="No services found" description="Try adjusting the search or filters to find another option." />
                </div>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $services->links() }}
        </div>
    </section>
</x-layouts.public>
