<?php

namespace App\Filament\Pages;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class Reports extends Page
{
    protected string $view = 'filament.pages.reports';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBarSquare;

    protected static ?string $navigationLabel = 'Reports';

    protected static string|\UnitEnum|null $navigationGroup = 'Operations';

    public static function canAccess(): bool
    {
        return Auth::user()?->hasAnyRole(['admin', 'provider']) ?? false;
    }

    public function getViewData(): array
    {
        /** @var User $user */
        $user = Auth::user();

        $bookings = Booking::query()
            ->with('service')
            ->visibleTo($user)
            ->when(request()->filled('start_date'), fn ($query) => $query->whereDate('booking_date', '>=', request('start_date')))
            ->when(request()->filled('end_date'), fn ($query) => $query->whereDate('booking_date', '<=', request('end_date')))
            ->orderBy('booking_date')
            ->get();

        return [
            'filters' => [
                'start_date' => request('start_date'),
                'end_date' => request('end_date'),
            ],
            'roleLabel' => $user->isProvider() ? 'Provider report' : 'Operations report',
            'totals' => [
                'bookings' => $bookings->count(),
                'revenue' => $bookings->where('status', Booking::STATUS_COMPLETED)->sum('total_price'),
                'completed' => $bookings->where('status', Booking::STATUS_COMPLETED)->count(),
                'cancelled' => $bookings->where('status', Booking::STATUS_CANCELLED)->count(),
                'customers' => $user->isProvider()
                    ? $bookings->pluck('user_id')->filter()->unique()->count()
                    : User::role('customer')->count(),
                'services' => $user->isProvider()
                    ? Service::query()->where('provider_id', $user->id)->count()
                    : Service::count(),
            ],
            'statusBreakdown' => collect(Booking::statusOptions())->mapWithKeys(
                fn (string $label, string $status) => [$label => $bookings->where('status', $status)->count()]
            ),
            'popularServices' => $bookings->groupBy(fn (Booking $booking) => $booking->service->name)
                ->map(fn ($group) => $group->count())
                ->sortDesc()
                ->take(5),
            'monthlyBookings' => $bookings->groupBy(fn (Booking $booking) => $booking->booking_date->format('M Y'))
                ->map(fn ($group) => $group->count()),
            'recentBookings' => $bookings->sortByDesc('booking_date')->take(8),
        ];
    }
}
