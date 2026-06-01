<?php

namespace App\Filament\Resources\Providers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class ProviderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('email')->email()->required()->unique(ignoreRecord: true)->maxLength(255),
                TextInput::make('phone')->tel()->maxLength(30),
                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->required(fn ($livewire): bool => $livewire instanceof CreateRecord)
                    ->dehydrateStateUsing(fn (?string $state): ?string => filled($state) ? Hash::make($state) : null)
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->maxLength(255),
                Textarea::make('bio')->rows(4)->columnSpanFull(),
                TextInput::make('profile_phone')->label('Profile phone')->tel()->maxLength(30),
                Select::make('status')
                    ->options([
                        'available' => 'Available',
                        'busy' => 'Busy',
                        'inactive' => 'Inactive',
                    ])
                    ->default('available')
                    ->required(),
                Textarea::make('availability_notes')->rows(4)->columnSpanFull(),
            ])
            ->columns(2);
    }
}
