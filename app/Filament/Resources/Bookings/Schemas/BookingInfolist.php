<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BookingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('booking_code'),
                TextEntry::make('user.name')->label('Customer'),
                TextEntry::make('service.name'),
                TextEntry::make('provider.name')->label('Provider'),
                TextEntry::make('status')->badge(),
                TextEntry::make('payment_status')->badge(),
                TextEntry::make('booking_date')->date('d M Y'),
                TextEntry::make('start_time'),
                TextEntry::make('total_price')->money('IDR'),
                TextEntry::make('address')->columnSpanFull(),
                TextEntry::make('notes')->columnSpanFull(),
                RepeatableEntry::make('activities')
                    ->schema([
                        TextEntry::make('action'),
                        TextEntry::make('description'),
                        TextEntry::make('created_at')->since(),
                    ])
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
