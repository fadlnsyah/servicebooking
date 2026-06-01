<?php

use App\Models\Booking;
use App\Models\Category;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

function makeUserWithRole(string $role, array $attributes = []): User
{
    Role::findOrCreate($role, 'web');

    $user = User::factory()->create(array_merge([
        'email_verified_at' => now(),
        'password' => Hash::make('password'),
    ], $attributes));

    $user->assignRole($role);

    return $user;
}

test('customer cannot create a booking when the provider is already booked for that slot', function () {
    $provider = makeUserWithRole('provider');
    $customer = makeUserWithRole('customer');

    $category = Category::create([
        'name' => 'Test Category',
        'slug' => 'test-category',
        'is_active' => true,
    ]);

    $service = Service::create([
        'category_id' => $category->id,
        'provider_id' => $provider->id,
        'name' => 'AC Tune Up',
        'slug' => 'ac-tune-up',
        'description' => 'Test service',
        'short_description' => 'Test service',
        'price' => 150000,
        'duration_minutes' => 90,
        'is_active' => true,
    ]);

    Booking::create([
        'booking_code' => 'BK-20260524-9001',
        'user_id' => $customer->id,
        'service_id' => $service->id,
        'provider_id' => $provider->id,
        'customer_name' => $customer->name,
        'customer_email' => $customer->email,
        'customer_phone' => '081200000001',
        'booking_date' => now()->addDay()->toDateString(),
        'start_time' => '09:00:00',
        'end_time' => '10:30:00',
        'duration_minutes' => 90,
        'price' => 150000,
        'admin_fee' => 25000,
        'total_price' => 175000,
        'status' => Booking::STATUS_APPROVED,
        'payment_method' => Booking::PAYMENT_METHOD_PAY_LATER,
        'payment_status' => Booking::PAYMENT_STATUS_UNPAID,
    ]);

    $response = $this->actingAs($customer)->post(route('bookings.store'), [
        'service_id' => $service->id,
        'full_name' => $customer->name,
        'email' => $customer->email,
        'phone_number' => '081200000001',
        'preferred_date' => now()->addDay()->toDateString(),
        'preferred_time' => '09:30',
        'payment_method' => Booking::PAYMENT_METHOD_PAY_LATER,
    ]);

    $response->assertSessionHasErrors('preferred_time');
    expect(Booking::query()->count())->toBe(1);
});

test('provider cannot access admin only customer page', function () {
    $provider = makeUserWithRole('provider');

    $this->actingAs($provider)
        ->get('/admin/customers')
        ->assertForbidden();
});

test('provider can access provider scoped reports page', function () {
    $provider = makeUserWithRole('provider');

    $this->actingAs($provider)
        ->get('/admin/reports')
        ->assertOk();
});
