<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Beauty & Salon', 'icon' => 'sparkles', 'description' => 'Hair, grooming, and wellness services.'],
            ['name' => 'Home Cleaning', 'icon' => 'home', 'description' => 'Residential cleaning and maintenance.'],
            ['name' => 'Tech Repair', 'icon' => 'smartphone', 'description' => 'Phone, gadget, and device support.'],
            ['name' => 'Photography', 'icon' => 'camera', 'description' => 'Studio and event photography sessions.'],
            ['name' => 'AC Maintenance', 'icon' => 'fan', 'description' => 'Air conditioner cleaning and service.'],
            ['name' => 'Vehicle Wash', 'icon' => 'truck', 'description' => 'Motorcycle and car wash packages.'],
            ['name' => 'Consultation', 'icon' => 'message-circle', 'description' => 'Private consulting appointments.'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => str($category['name'])->slug()], array_merge($category, ['is_active' => true]));
        }
    }
}
