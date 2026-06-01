<?php

namespace App\Filament\Resources\Providers\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProviderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('email'),
                TextEntry::make('phone'),
                TextEntry::make('providerProfile.status')->label('Status')->badge(),
                TextEntry::make('provided_services_count')->label('Services'),
                TextEntry::make('providerProfile.phone')->label('Profile phone'),
                TextEntry::make('providerProfile.bio')->columnSpanFull(),
                TextEntry::make('providerProfile.availability_notes')->columnSpanFull(),
                TextEntry::make('created_at')->dateTime('d M Y H:i'),
                TextEntry::make('updated_at')->dateTime('d M Y H:i'),
            ])
            ->columns(2);
    }
}
