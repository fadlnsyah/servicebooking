<?php

namespace App\Filament\Resources\Bookings\Tables;

use App\Models\Booking;
use App\Services\BookingWorkflowService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking_code')->label('Code')->searchable()->sortable()->copyable(),
                TextColumn::make('user.name')->label('Customer')->searchable()->toggleable(),
                TextColumn::make('service.name')->label('Service')->searchable(),
                TextColumn::make('provider.name')->label('Provider')->toggleable(isToggledHiddenByDefault: auth()->user()?->isProvider() ?? false),
                TextColumn::make('booking_date')->date('d M Y')->sortable(),
                TextColumn::make('start_time')->label('Time'),
                TextColumn::make('status')->badge(),
                TextColumn::make('payment_status')->label('Payment')->badge(),
                TextColumn::make('total_price')->money('IDR')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(Booking::statusOptions()),
                SelectFilter::make('service')->relationship('service', 'name'),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('approve')
                    ->visible(fn (Booking $record): bool => (auth()->user()?->isAdmin() ?? false) && $record->status === Booking::STATUS_PENDING)
                    ->action(function (Booking $record): void {
                        abort_unless(auth()->user()?->isAdmin(), 403);

                        app(BookingWorkflowService::class)->updateStatus(
                            $record,
                            Booking::STATUS_APPROVED,
                            auth()->user(),
                            'approved',
                            'Booking approved by admin.'
                        );
                    }),
                Action::make('reject')
                    ->color('danger')
                    ->visible(fn (Booking $record): bool => (auth()->user()?->isAdmin() ?? false) && $record->status === Booking::STATUS_PENDING)
                    ->action(function (Booking $record): void {
                        abort_unless(auth()->user()?->isAdmin(), 403);

                        app(BookingWorkflowService::class)->updateStatus(
                            $record,
                            Booking::STATUS_REJECTED,
                            auth()->user(),
                            'rejected',
                            'Booking rejected by admin.'
                        );
                    }),
                Action::make('complete')
                    ->visible(fn (Booking $record): bool => (auth()->user()?->isAdmin() ?? false) && in_array($record->status, [Booking::STATUS_APPROVED, Booking::STATUS_RESCHEDULED], true))
                    ->action(function (Booking $record): void {
                        abort_unless(auth()->user()?->isAdmin(), 403);

                        app(BookingWorkflowService::class)->updateStatus(
                            $record,
                            Booking::STATUS_COMPLETED,
                            auth()->user(),
                            'completed',
                            'Booking marked as completed by admin.'
                        );

                        $record->update(['payment_status' => Booking::PAYMENT_STATUS_PAID]);
                    }),
                EditAction::make()->visible(fn (): bool => auth()->user()?->isAdmin() ?? false),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->visible(fn (): bool => auth()->user()?->isAdmin() ?? false),
                    ForceDeleteBulkAction::make()->visible(fn (): bool => auth()->user()?->isAdmin() ?? false),
                    RestoreBulkAction::make()->visible(fn (): bool => auth()->user()?->isAdmin() ?? false),
                ]),
            ]);
    }
}
