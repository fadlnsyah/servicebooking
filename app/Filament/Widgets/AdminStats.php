<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStats extends StatsOverviewWidget
{
    public static function canView(): bool
    {
        return auth()->user()?->hasAnyRole(['admin', 'provider']) ?? false;
    }

    protected function getStats(): array
    {
        /** @var User|null $user */
        $user = auth()->user();
        $bookings = $user ? Booking::query()->visibleTo($user) : Booking::query()->whereRaw('1 = 0');
        $completed = (clone $bookings)->where('status', Booking::STATUS_COMPLETED);
        $pending = (clone $bookings)->where('status', Booking::STATUS_PENDING);
        $approved = (clone $bookings)->where('status', Booking::STATUS_APPROVED);

        return [
            Stat::make($user?->isProvider() ? 'My Bookings' : 'Total Bookings', (string) (clone $bookings)->count()),
            Stat::make('Pending Bookings', (string) $pending->count()),
            Stat::make('Approved Bookings', (string) $approved->count()),
            Stat::make('Completed Services', (string) $completed->count()),
            Stat::make('Total Revenue', format_rupiah((int) $completed->sum('total_price'))),
            Stat::make($user?->isProvider() ? 'My Customers' : 'New Customers', (string) (
                $user?->isProvider()
                    ? (clone $bookings)->distinct('user_id')->count('user_id')
                    : User::role('customer')->count()
            )),
        ];
    }
}
