<?php

namespace Database\Seeders;

use App\Models\ProviderProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@servicebooking.test'],
            [
                'name' => 'Fadlan Zikri',
                'phone' => '0812-3456-7890',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ],
        );
        $admin->syncRoles(['admin']);

        $customer = User::updateOrCreate(
            ['email' => 'customer@servicebooking.test'],
            [
                'name' => 'Budi Santoso',
                'phone' => '0813-2222-1111',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ],
        );
        $customer->syncRoles(['customer']);

        $provider = User::updateOrCreate(
            ['email' => 'provider@servicebooking.test'],
            [
                'name' => 'Sarah Amelia',
                'phone' => '0812-5555-0001',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ],
        );
        $provider->syncRoles(['provider']);

        $extraCustomers = [
            ['name' => 'Rani Putri', 'email' => 'rani@servicebooking.test', 'phone' => '0813-0000-2001'],
            ['name' => 'Andi Pratama', 'email' => 'andi@servicebooking.test', 'phone' => '0813-0000-2002'],
        ];

        foreach ($extraCustomers as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                ],
            );
            $user->syncRoles(['customer']);
        }

        $extraProviders = [
            [
                'name' => 'Dimas Prasetyo',
                'email' => 'dimas@servicebooking.test',
                'phone' => '0812-5555-0002',
                'bio' => 'Experienced field technician focused on fast onsite support.',
            ],
            [
                'name' => 'Nabila Aulia',
                'email' => 'nabila@servicebooking.test',
                'phone' => '0812-5555-0003',
                'bio' => 'Photography and consultation specialist with a calm client-first approach.',
            ],
        ];

        foreach (array_merge([[
            'name' => 'Sarah Amelia',
            'email' => 'provider@servicebooking.test',
            'phone' => '0812-5555-0001',
            'bio' => 'Trusted provider for beauty and lifestyle appointments.',
        ]], $extraProviders) as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                ],
            );

            $user->syncRoles(['provider']);

            ProviderProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'bio' => $data['bio'],
                    'phone' => $data['phone'],
                    'status' => 'available',
                    'availability_notes' => 'Available Today, Tomorrow, and This Week',
                ],
            );
        }
    }
}
