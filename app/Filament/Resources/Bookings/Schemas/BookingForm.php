<?php

namespace App\Filament\Resources\Bookings\Schemas;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('booking_code')->required()->maxLength(255),
                Select::make('user_id')->label('Customer')->options(User::role('customer')->pluck('name', 'id'))->searchable()->required(),
                Select::make('service_id')->options(Service::query()->pluck('name', 'id'))->searchable()->required(),
                Select::make('provider_id')->label('Provider')->options(User::role('provider')->pluck('name', 'id'))->searchable(),
                TextInput::make('customer_name')->required()->maxLength(255),
                TextInput::make('customer_email')->email()->required(),
                TextInput::make('customer_phone')->required()->maxLength(30),
                DatePicker::make('booking_date')->required(),
                TextInput::make('start_time')->required(),
                TextInput::make('end_time')->required(),
                TextInput::make('duration_minutes')->numeric()->required(),
                TextInput::make('price')->numeric()->prefix('Rp')->required(),
                TextInput::make('admin_fee')->numeric()->prefix('Rp')->required(),
                TextInput::make('total_price')->numeric()->prefix('Rp')->required(),
                Select::make('status')->options(Booking::statusOptions())->required(),
                Select::make('payment_method')->options(Booking::paymentMethodOptions())->required(),
                Select::make('payment_status')->options(Booking::paymentStatusOptions())->required(),
                Textarea::make('address')->columnSpanFull(),
                Textarea::make('notes')->columnSpanFull(),
            ])
            ->columns(2);
    }
}
