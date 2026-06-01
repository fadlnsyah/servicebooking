<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $services = Service::query()
            ->with(['category', 'provider'])
            ->where('is_active', true)
            ->when($request->filled('search'), function (Builder $query) use ($request): void {
                $query->where(function (Builder $inner) use ($request): void {
                    $inner
                        ->where('name', 'like', '%'.$request->string('search').'%')
                        ->orWhere('short_description', 'like', '%'.$request->string('search').'%');
                });
            })
            ->when($request->filled('category'), function (Builder $query) use ($request): void {
                $query->whereHas('category', fn (Builder $categoryQuery) => $categoryQuery->where('slug', $request->string('category')));
            })
            ->when($request->filled('rating'), fn (Builder $query) => $query->where('rating', '>=', $request->integer('rating')))
            ->when($request->filled('min_price'), fn (Builder $query) => $query->where('price', '>=', $request->integer('min_price')))
            ->when($request->filled('max_price'), fn (Builder $query) => $query->where('price', '<=', $request->integer('max_price')))
            ->when($request->string('availability')->value() === 'available', fn (Builder $query) => $query->whereNotNull('provider_id'))
            ->when($request->filled('sort'), function (Builder $query) use ($request): void {
                match ($request->string('sort')->value()) {
                    'lowest_price' => $query->orderBy('price'),
                    'highest_rating' => $query->orderByDesc('rating'),
                    'newest' => $query->latest(),
                    default => $query->orderByDesc('reviews_count')->orderByDesc('rating'),
                };
            }, fn (Builder $query) => $query->orderByDesc('reviews_count')->orderByDesc('rating'))
            ->paginate(9)
            ->withQueryString();

        return view('pages.services.index', [
            'services' => $services,
            'categories' => Category::query()->where('is_active', true)->get(),
            'filters' => $request->all(),
        ]);
    }

    public function show(Service $service): View
    {
        $service->load(['category', 'provider.providerProfile', 'reviews.user']);

        return view('pages.services.show', [
            'service' => $service,
            'relatedServices' => Service::query()
                ->with(['category', 'provider'])
                ->where('category_id', $service->category_id)
                ->whereKeyNot($service->id)
                ->take(3)
                ->get(),
        ]);
    }

    public function book(Service $service): View
    {
        $service->load(['category', 'provider.providerProfile']);

        return view('pages.bookings.create', [
            'service' => $service,
            'scheduleOptions' => [
                ['label' => 'Today', 'date' => now()->toDateString()],
                ['label' => 'Tomorrow', 'date' => now()->addDay()->toDateString()],
                ['label' => 'This Week', 'date' => now()->addDays(3)->toDateString()],
            ],
            'timeOptions' => ['09:00', '13:30', '16:00'],
        ]);
    }
}
