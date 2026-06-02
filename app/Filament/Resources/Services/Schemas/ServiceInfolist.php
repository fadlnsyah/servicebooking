<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ServiceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Service Overview')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('slug')->copyable(),
                        TextEntry::make('category.name')->label('Category'),
                        TextEntry::make('provider.name')->label('Provider')->placeholder('Unassigned'),
                        TextEntry::make('price')->money('IDR'),
                        TextEntry::make('duration_minutes')->suffix(' min'),
                        TextEntry::make('rating'),
                        TextEntry::make('reviews_count')->label('Reviews'),
                        IconEntry::make('is_active')->boolean()->label('Active'),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
                Section::make('Content')
                    ->schema([
                        TextEntry::make('short_description')->placeholder('-')->columnSpanFull(),
                        TextEntry::make('description')->columnSpanFull(),
                        ImageEntry::make('image')->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }
}
