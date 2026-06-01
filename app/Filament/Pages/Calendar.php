<?php

namespace App\Filament\Pages;

use App\Models\Booking;
use App\Models\User;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\Bookings\BookingResource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Calendar extends Page
{
    protected string $view = 'filament.pages.calendar';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static ?string $navigationLabel = 'Calendar';

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
            ->with(['service', 'provider', 'user'])
            ->visibleTo($user)
            ->activeSchedule()
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->take(30)
            ->get();

        return [
            'roleLabel' => $user->isProvider() ? 'My assigned schedule' : 'All active bookings',
            'totals' => [
                'days' => $bookings->groupBy(fn (Booking $booking) => $booking->booking_date->toDateString())->count(),
                'bookings' => $bookings->count(),
                'pending' => $bookings->where('status', Booking::STATUS_PENDING)->count(),
                'approved' => $bookings->where('status', Booking::STATUS_APPROVED)->count(),
            ],
            'bookingsByDate' => $bookings->groupBy(fn (Booking $booking): string => $booking->booking_date->toDateString())
                ->map(function (Collection $group): array {
                    return [
                        'label' => $group->first()->booking_date->format('D, d M Y'),
                        'items' => $group->values(),
                    ];
                }),
            'calendarEvents' => $bookings->map(fn (Booking $booking): array => [
                'id' => (string) $booking->id,
                'title' => $booking->service->name,
                'start' => $booking->booking_date->toDateString().'T'.substr($booking->start_time, 0, 5),
                'end' => $booking->booking_date->toDateString().'T'.substr($booking->end_time, 0, 5),
                'url' => BookingResource::getUrl('view', ['record' => $booking]),
                'extendedProps' => [
                    'code' => $booking->booking_code,
                    'customer' => $booking->user?->name ?? 'Unknown',
                    'provider' => $booking->provider?->name ?? 'Provider pending',
                    'status' => $booking->status,
                    'time' => substr($booking->start_time, 0, 5).' - '.substr($booking->end_time, 0, 5),
                ],
            ])->values(),
        ];
    }
}
