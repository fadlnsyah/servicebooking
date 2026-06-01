<?php

namespace App\Filament\Resources\Providers\Pages;

use App\Filament\Resources\Providers\ProviderResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class CreateProvider extends CreateRecord
{
    protected static string $resource = ProviderResource::class;

    protected array $profileData = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->profileData = Arr::only($data, ['bio', 'profile_phone', 'status', 'availability_notes']);

        return Arr::except($data, ['bio', 'profile_phone', 'status', 'availability_notes']);
    }

    protected function handleRecordCreation(array $data): Model
    {
        /** @var User $record */
        $record = parent::handleRecordCreation($data);
        $record->syncRoles(['provider']);
        $record->providerProfile()->updateOrCreate([], [
            'bio' => $this->profileData['bio'] ?? null,
            'phone' => $this->profileData['profile_phone'] ?? $record->phone,
            'status' => $this->profileData['status'] ?? 'available',
            'availability_notes' => $this->profileData['availability_notes'] ?? null,
        ]);

        return $record;
    }
}
