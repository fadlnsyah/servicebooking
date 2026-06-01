<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Review;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::role('customer')->get()->keyBy('email');
        $services = Service::all()->keyBy('slug');

        $bookings = [
            ['code' => 'BK-20260515-001', 'customer' => 'customer@servicebooking.test', 'service' => 'haircut-styling', 'date' => '2026-05-15', 'time' => '09:00:00', 'status' => Booking::STATUS_PENDING, 'payment_method' => Booking::PAYMENT_METHOD_PAY_LATER],
            ['code' => 'BK-20260515-002', 'customer' => 'rani@servicebooking.test', 'service' => 'studio-photography', 'date' => '2026-05-16', 'time' => '13:30:00', 'status' => Booking::STATUS_APPROVED, 'payment_method' => Booking::PAYMENT_METHOD_MANUAL_TRANSFER],
            ['code' => 'BK-20260515-003', 'customer' => 'andi@servicebooking.test', 'service' => 'ac-maintenance', 'date' => '2026-05-17', 'time' => '16:00:00', 'status' => Booking::STATUS_COMPLETED, 'payment_method' => Booking::PAYMENT_METHOD_PAY_LATER],
        ];

        foreach ($bookings as $item) {
            $service = $services[$item['service']];
            $customer = $customers[$item['customer']];
            $adminFee = 25000;
            $duration = $service->duration_minutes;
            $endTime = now()->createFromFormat('H:i:s', $item['time'])->addMinutes($duration)->format('H:i:s');

            $booking = Booking::updateOrCreate(
                ['booking_code' => $item['code']],
                [
                    'user_id' => $customer->id,
                    'service_id' => $service->id,
                    'provider_id' => $service->provider_id,
                    'customer_name' => $customer->name,
                    'customer_email' => $customer->email,
                    'customer_phone' => $customer->phone,
                    'address' => 'Jakarta Selatan',
                    'notes' => 'Please confirm via email.',
                    'booking_date' => $item['date'],
                    'start_time' => $item['time'],
                    'end_time' => $endTime,
                    'duration_minutes' => $duration,
                    'price' => $service->price,
                    'admin_fee' => $adminFee,
                    'total_price' => $service->price + $adminFee,
                    'status' => $item['status'],
                    'payment_method' => $item['payment_method'],
                    'payment_status' => $item['status'] === Booking::STATUS_COMPLETED ? Booking::PAYMENT_STATUS_PAID : Booking::PAYMENT_STATUS_UNPAID,
                ],
            );

            $booking->activities()->delete();
            $booking->activities()->createMany([
                [
                    'user_id' => $customer->id,
                    'action' => 'created',
                    'description' => 'Booking was created by the customer.',
                    'old_status' => null,
                    'new_status' => Booking::STATUS_PENDING,
                ],
                [
                    'user_id' => $service->provider_id,
                    'action' => 'updated',
                    'description' => 'Booking status synced for demo data.',
                    'old_status' => Booking::STATUS_PENDING,
                    'new_status' => $item['status'],
                ],
            ]);

            if ($item['status'] === Booking::STATUS_COMPLETED) {
                Review::updateOrCreate(
                    ['booking_id' => $booking->id],
                    [
                        'user_id' => $customer->id,
                        'service_id' => $service->id,
                        'rating' => 5,
                        'comment' => 'Fast confirmation, clear scheduling, and a professional service experience.',
                    ],
                );
            }
        }
    }
}
