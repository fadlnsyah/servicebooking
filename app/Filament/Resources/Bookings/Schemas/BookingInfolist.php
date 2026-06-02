<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BookingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Booking Summary')
                    ->schema([
                        TextEntry::make('booking_code')->label('Code')->copyable(),
                        TextEntry::make('status')->badge(),
                        TextEntry::make('payment_status')->label('Payment')->badge(),
                        TextEntry::make('total_price')->money('IDR'),
                    ])
                    ->columns(4)
                    ->columnSpanFull(),
                Section::make('Schedule')
                    ->schema([
                        TextEntry::make('service.name')->label('Service'),
                        TextEntry::make('provider.name')->label('Provider')->placeholder('Unassigned'),
                        TextEntry::make('booking_date')->date('d M Y'),
                        TextEntry::make('start_time')->label('Time'),
                        TextEntry::make('end_time')->label('End time'),
                        TextEntry::make('duration_minutes')->suffix(' min'),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
                Section::make('Customer')
                    ->schema([
                        TextEntry::make('customer_name')->label('Name'),
                        TextEntry::make('customer_email')->label('Email')->copyable(),
                        TextEntry::make('customer_phone')->label('Phone')->copyable(),
                        TextEntry::make('address')->placeholder('-')->columnSpanFull(),
                        TextEntry::make('notes')->placeholder('-')->columnSpanFull(),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
                Section::make('Activity Timeline')
                    ->schema([
                        RepeatableEntry::make('activities')
                            ->label('')
                            ->schema([
                                TextEntry::make('action')->badge(),
                                TextEntry::make('description'),
                                TextEntry::make('created_at')->since(),
                            ])
                            ->columns(3),
                    ])
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }
}
