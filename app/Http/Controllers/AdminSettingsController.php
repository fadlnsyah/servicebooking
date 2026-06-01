<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingsRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;

class AdminSettingsController extends Controller
{
    public function update(UpdateSettingsRequest $request): RedirectResponse
    {
        foreach ($request->validated() as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'type' => in_array($key, ['address', 'booking_rules', 'payment_information'], true) ? 'textarea' : 'text',
                ],
            );
        }

        return back()->with('status', 'Settings updated successfully.');
    }
}
