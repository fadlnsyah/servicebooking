<?php

namespace App\Filament\Resources\Providers\Pages;

use App\Filament\Resources\Providers\ProviderResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Arr;

class EditProvider extends EditRecord
{
    protected static string $resource = ProviderResource::class;

    protected array $profileData = [];

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $profile = $this->record->providerProfile;

        $data['bio'] = $profile?->bio;
        $data['profile_phone'] = $profile?->phone;
        $data['status'] = $profile?->status ?? 'available';
        $data['availability_notes'] = $profile?->availability_notes;

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->profileData = Arr::only($data, ['bio', 'profile_phone', 'status', 'availability_notes']);

        return Arr::except($data, ['bio', 'profile_phone', 'status', 'availability_notes']);
    }

    protected function afterSave(): void
    {
        $this->record->syncRoles(['provider']);
        $this->record->providerProfile()->updateOrCreate([], [
            'bio' => $this->profileData['bio'] ?? null,
            'phone' => $this->profileData['profile_phone'] ?? $this->record->phone,
            'status' => $this->profileData['status'] ?? 'available',
            'availability_notes' => $this->profileData['availability_notes'] ?? null,
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
