<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'business_name' => ['value' => 'ServiceBooking', 'type' => 'text'],
            'contact_email' => ['value' => 'hello@servicebooking.test', 'type' => 'email'],
            'phone_number' => ['value' => '021-555-2026', 'type' => 'text'],
            'address' => ['value' => 'Jakarta, Indonesia', 'type' => 'textarea'],
            'operating_hours' => ['value' => 'Mon - Sat, 09:00 - 18:00', 'type' => 'text'],
            'booking_rules' => ['value' => 'Bookings should be placed at least 2 hours before the selected schedule.', 'type' => 'textarea'],
            'payment_information' => ['value' => 'Manual transfer available to Bank BCA 1234567890 a.n. ServiceBooking Demo', 'type' => 'textarea'],
            'notification_settings' => ['value' => json_encode(['email' => true, 'dashboard' => true]), 'type' => 'json'],
        ];

        foreach ($settings as $key => $setting) {
            Setting::updateOrCreate(['key' => $key], $setting);
        }
    }
}
