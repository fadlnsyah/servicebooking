<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\User;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentBookings extends TableWidget
{
    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()?->hasAnyRole(['admin', 'provider']) ?? false;
    }

    public function table(Table $table): Table
    {
        /** @var User|null $user */
        $user = auth()->user();

        return $table
            ->heading($user?->isProvider() ? 'My Recent Assignments' : 'Recent Booking Table')
            ->query(fn (): Builder => Booking::query()->with(['user', 'service', 'provider'])->visibleTo($user)->latest()->limit(8))
            ->columns([
                TextColumn::make('booking_code')->searchable(),
                TextColumn::make('user.name')->label('Customer'),
                TextColumn::make('service.name')->label('Service'),
                TextColumn::make('provider.name')->label('Provider'),
                TextColumn::make('booking_date')->date('d M Y'),
                TextColumn::make('status')->badge(),
                TextColumn::make('payment_status')->badge(),
            ])
            ->recordActions([
                ViewAction::make()->url(fn (Booking $record): string => '/admin/bookings/'.$record->getKey()),
            ]);
    }
}
