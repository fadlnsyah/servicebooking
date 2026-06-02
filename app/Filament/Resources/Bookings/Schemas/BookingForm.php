<?php

namespace App\Filament\Resources\Bookings\Schemas;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Booking')
                    ->schema([
                        TextInput::make('booking_code')->required()->maxLength(255),
                        Select::make('status')->options(Booking::statusOptions())->required(),
                        Select::make('payment_method')->options(Booking::paymentMethodOptions())->required(),
                        Select::make('payment_status')->options(Booking::paymentStatusOptions())->required(),
                    ])
                    ->columns(2),
                Section::make('People and Service')
                    ->schema([
                        Select::make('user_id')->label('Customer')->options(User::role('customer')->pluck('name', 'id'))->searchable()->required(),
                        Select::make('service_id')->options(Service::query()->pluck('name', 'id'))->searchable()->required(),
                        Select::make('provider_id')->label('Provider')->options(User::role('provider')->pluck('name', 'id'))->searchable(),
                    ])
                    ->columns(3),
                Section::make('Customer Snapshot')
                    ->schema([
                        TextInput::make('customer_name')->required()->maxLength(255),
                        TextInput::make('customer_email')->email()->required(),
                        TextInput::make('customer_phone')->required()->maxLength(30),
                        Textarea::make('address')->columnSpanFull(),
                        Textarea::make('notes')->columnSpanFull(),
                    ])
                    ->columns(3),
                Section::make('Schedule and Price')
                    ->schema([
                        DatePicker::make('booking_date')->required(),
                        TextInput::make('start_time')->required(),
                        TextInput::make('end_time')->required(),
                        TextInput::make('duration_minutes')->numeric()->required(),
                        TextInput::make('price')->numeric()->prefix('Rp')->required(),
                        TextInput::make('admin_fee')->numeric()->prefix('Rp')->required(),
                        TextInput::make('total_price')->numeric()->prefix('Rp')->required(),
                    ])
                    ->columns(4),
            ])
            ->columns(1);
    }
}
