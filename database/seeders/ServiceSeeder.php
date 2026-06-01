<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $providers = User::role('provider')->get()->keyBy('email');

        $services = [
            ['name' => 'Haircut & Styling', 'category' => 'Beauty & Salon', 'price' => 75000, 'duration' => 60, 'provider' => 'provider@servicebooking.test', 'rating' => 4.8, 'reviews' => 124],
            ['name' => 'Home Deep Cleaning', 'category' => 'Home Cleaning', 'price' => 250000, 'duration' => 180, 'provider' => 'dimas@servicebooking.test', 'rating' => 4.7, 'reviews' => 89],
            ['name' => 'Smartphone Repair', 'category' => 'Tech Repair', 'price' => 150000, 'duration' => 90, 'provider' => 'dimas@servicebooking.test', 'rating' => 4.6, 'reviews' => 57],
            ['name' => 'Studio Photography', 'category' => 'Photography', 'price' => 500000, 'duration' => 120, 'provider' => 'nabila@servicebooking.test', 'rating' => 4.9, 'reviews' => 92],
            ['name' => 'AC Maintenance', 'category' => 'AC Maintenance', 'price' => 125000, 'duration' => 75, 'provider' => 'dimas@servicebooking.test', 'rating' => 4.5, 'reviews' => 48],
            ['name' => 'Vehicle Wash', 'category' => 'Vehicle Wash', 'price' => 100000, 'duration' => 45, 'provider' => 'provider@servicebooking.test', 'rating' => 4.4, 'reviews' => 61],
            ['name' => 'Private Consultation', 'category' => 'Consultation', 'price' => 250000, 'duration' => 60, 'provider' => 'nabila@servicebooking.test', 'rating' => 4.8, 'reviews' => 39],
            ['name' => 'Massage Therapy', 'category' => 'Beauty & Salon', 'price' => 150000, 'duration' => 90, 'provider' => 'provider@servicebooking.test', 'rating' => 4.9, 'reviews' => 74],
        ];

        foreach ($services as $item) {
            $category = Category::where('name', $item['category'])->firstOrFail();

            Service::updateOrCreate(
                ['slug' => str($item['name'])->slug()],
                [
                    'category_id' => $category->id,
                    'provider_id' => $providers[$item['provider']]->id ?? null,
                    'name' => $item['name'],
                    'description' => $item['name'].' delivers a polished booking experience with clear scheduling, responsive support, and portfolio-ready service presentation.',
                    'short_description' => 'Professional '.$item['name'].' tailored for modern customers.',
                    'price' => $item['price'],
                    'duration_minutes' => $item['duration'],
                    'image' => null,
                    'rating' => $item['rating'],
                    'reviews_count' => $item['reviews'],
                    'is_active' => true,
                ],
            );
        }
    }
}
