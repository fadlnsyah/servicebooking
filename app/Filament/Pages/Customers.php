<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class Customers extends Page
{
    protected string $view = 'filament.pages.customers';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $navigationLabel = 'Customers';

    protected static string|\UnitEnum|null $navigationGroup = 'Management';

    public static function canAccess(): bool
    {
        return Auth::user()?->isAdmin() ?? false;
    }

    public function getViewData(): array
    {
        return [
            'customers' => User::role('customer')->latest()->get(),
        ];
    }
}
