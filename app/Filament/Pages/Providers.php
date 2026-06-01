<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class Providers extends Page
{
    protected string $view = 'filament.pages.providers';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $navigationLabel = 'Staff / Providers';

    protected static string|\UnitEnum|null $navigationGroup = 'Management';

    public static function canAccess(): bool
    {
        return Auth::user()?->isAdmin() ?? false;
    }

    public function getViewData(): array
    {
        return [
            'providers' => User::role('provider')->with('providerProfile')->latest()->get(),
        ];
    }
}
