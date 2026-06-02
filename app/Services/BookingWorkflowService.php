<?php

namespace App\Services;

use App\Mail\BookingSubmittedMail;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class BookingWorkflowService
{
    public function createBooking(array $validated, User $user, Service $service): Booking
    {
        $this->assertBookableService($service);
        [$startTime, $endTime] = $this->resolveTimeRange($validated['preferred_time'], $service->duration_minutes);
        $adminFee = 25000;

        $booking = DB::transaction(function () use ($validated, $user, $service, $startTime, $endTime, $adminFee): Booking {
            $this->ensureProviderAvailability(
                $service->provider_id,
                $validated['preferred_date'],
                $startTime->format('H:i:s'),
                $endTime->format('H:i:s'),
            );

            $booking = Booking::create([
                'booking_code' => $this->generateBookingCode(),
                'user_id' => $user->id,
                'service_id' => $service->id,
                'provider_id' => $service->provider_id,
                'customer_name' => $validated['full_name'],
                'customer_email' => $validated['email'],
                'customer_phone' => $validated['phone_number'],
                'address' => $validated['address'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'booking_date' => $validated['preferred_date'],
                'start_time' => $startTime->format('H:i:s'),
                'end_time' => $endTime->format('H:i:s'),
                'duration_minutes' => $service->duration_minutes,
                'price' => $service->price,
                'admin_fee' => $adminFee,
                'total_price' => $service->price + $adminFee,
                'status' => Booking::STATUS_PENDING,
                'payment_method' => $validated['payment_method'],
                'payment_status' => Booking::PAYMENT_STATUS_UNPAID,
            ]);

            $this->recordActivity(
                $booking,
                $user,
                'created',
                'Booking submitted and waiting for admin confirmation.',
                null,
                Booking::STATUS_PENDING,
            );

            return $booking;
        });

        Mail::to($booking->customer_email)->queue(new BookingSubmittedMail($booking->load(['service', 'provider'])));

        return $booking;
    }

    public function updateStatus(Booking $booking, string $status, ?User $actor, string $action, string $description): Booking
    {
        $oldStatus = $booking->status;

        $booking->update(['status' => $status]);

        $this->recordActivity($booking, $actor, $action, $description, $oldStatus, $status);

        return $booking->refresh();
    }

    public function reschedule(Booking $booking, array $validated, ?User $actor): Booking
    {
        $service = $booking->service;
        [$startTime, $endTime] = $this->resolveTimeRange($validated['preferred_time'], $service->duration_minutes);
        $oldStatus = $booking->status;

        $this->ensureProviderAvailability(
            $booking->provider_id,
            $validated['preferred_date'],
            $startTime->format('H:i:s'),
            $endTime->format('H:i:s'),
            $booking,
        );

        $booking->update([
            'booking_date' => $validated['preferred_date'],
            'start_time' => $startTime->format('H:i:s'),
            'end_time' => $endTime->format('H:i:s'),
            'status' => Booking::STATUS_RESCHEDULED,
        ]);

        $this->recordActivity(
            $booking,
            $actor,
            'rescheduled',
            'Booking date and time were rescheduled by the customer.',
            $oldStatus,
            Booking::STATUS_RESCHEDULED,
        );

        return $booking->refresh();
    }

    public function recordActivity(
        Booking $booking,
        ?User $actor,
        string $action,
        string $description,
        ?string $oldStatus = null,
        ?string $newStatus = null,
    ): void {
        $booking->activities()->create([
            'user_id' => $actor?->id,
            'action' => $action,
            'description' => $description,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
        ]);
    }

    protected function generateBookingCode(): string
    {
        $datePrefix = now()->format('Ymd');

        do {
            $bookingCode = sprintf('BK-%s-%04d', $datePrefix, random_int(1000, 9999));
        } while (Booking::query()->where('booking_code', $bookingCode)->exists());

        return $bookingCode;
    }

    protected function resolveTimeRange(string $preferredTime, int $durationMinutes): array
    {
        $startTime = Carbon::createFromFormat('H:i', $preferredTime);
        $endTime = $startTime->copy()->addMinutes($durationMinutes);

        return [$startTime, $endTime];
    }

    protected function assertBookableService(Service $service): void
    {
        if (! $service->is_active) {
            throw ValidationException::withMessages([
                'service_id' => 'This service is currently unavailable.',
            ]);
        }

        if ($service->provider_id === null) {
            throw ValidationException::withMessages([
                'service_id' => 'This service does not have an assigned provider yet.',
            ]);
        }
    }

    protected function ensureProviderAvailability(
        ?int $providerId,
        string $bookingDate,
        string $startTime,
        string $endTime,
        ?Booking $ignoreBooking = null,
    ): void {
        if ($providerId === null) {
            return;
        }

        $conflictExists = Booking::query()
            ->activeSchedule()
            ->where('provider_id', $providerId)
            ->whereDate('booking_date', $bookingDate)
            ->where('start_time', '<', $endTime)
            ->where('end_time', '>', $startTime)
            ->when($ignoreBooking, fn ($query) => $query->whereKeyNot($ignoreBooking->getKey()))
            ->exists();

        if ($conflictExists) {
            throw ValidationException::withMessages([
                'preferred_time' => 'The selected provider is already booked for that time. Please choose another slot.',
            ]);
        }
    }
}
