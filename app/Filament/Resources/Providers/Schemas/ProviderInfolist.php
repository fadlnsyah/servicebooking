<?php

namespace App\Filament\Resources\Providers\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProviderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Provider Account')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('email')->copyable(),
                        TextEntry::make('phone')->placeholder('-'),
                        TextEntry::make('providerProfile.status')->label('Status')->badge(),
                        TextEntry::make('provided_services_count')->label('Assigned Services'),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
                Section::make('Profile')
                    ->schema([
                        TextEntry::make('providerProfile.phone')->label('Profile phone')->placeholder('-'),
                        TextEntry::make('providerProfile.bio')->placeholder('-')->columnSpanFull(),
                        TextEntry::make('providerProfile.availability_notes')->placeholder('-')->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Record')
                    ->schema([
                        TextEntry::make('created_at')->dateTime('d M Y H:i'),
                        TextEntry::make('updated_at')->dateTime('d M Y H:i'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }
}
