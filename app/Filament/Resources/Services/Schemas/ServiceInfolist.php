<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ServiceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('category.name')->label('Category'),
                TextEntry::make('provider.name')->label('Provider'),
                TextEntry::make('name'),
                TextEntry::make('slug'),
                TextEntry::make('price')->money('IDR'),
                TextEntry::make('duration_minutes')->suffix(' min'),
                TextEntry::make('short_description')->columnSpanFull(),
                TextEntry::make('description')->columnSpanFull(),
                ImageEntry::make('image')->columnSpanFull(),
                TextEntry::make('rating'),
                TextEntry::make('reviews_count'),
                IconEntry::make('is_active')->boolean(),
            ])
            ->columns(2);
    }
}
