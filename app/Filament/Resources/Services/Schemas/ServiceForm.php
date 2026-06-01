<?php

namespace App\Filament\Resources\Services\Schemas;

use App\Models\Category;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')->options(Category::query()->pluck('name', 'id'))->searchable()->required(),
                Select::make('provider_id')->label('Provider')->options(User::role('provider')->pluck('name', 'id'))->searchable(),
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('slug')->required()->maxLength(255),
                TextInput::make('price')->numeric()->prefix('Rp')->required(),
                TextInput::make('duration_minutes')->numeric()->required(),
                Textarea::make('short_description')->rows(3)->columnSpanFull(),
                Textarea::make('description')->rows(6)->columnSpanFull()->required(),
                FileUpload::make('image')->directory('services')->image()->columnSpanFull(),
                TextInput::make('rating')->numeric()->default(0),
                TextInput::make('reviews_count')->numeric()->default(0),
                Toggle::make('is_active')->default(true),
            ])
            ->columns(2);
    }
}
