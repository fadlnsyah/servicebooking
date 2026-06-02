<?php

namespace App\Exports;

use App\Models\Booking;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingsExport implements FromCollection, WithHeadings
{
    public function __construct(
        protected User $user,
        protected ?string $startDate = null,
        protected ?string $endDate = null,
    ) {
    }

    public function collection()
    {
        return Booking::query()
            ->with(['user', 'service', 'provider'])
            ->visibleTo($this->user)
            ->when($this->startDate, fn ($query) => $query->whereDate('booking_date', '>=', $this->startDate))
            ->when($this->endDate, fn ($query) => $query->whereDate('booking_date', '<=', $this->endDate))
            ->latest('booking_date')
            ->get()
            ->map(fn (Booking $booking) => [
                'booking_code' => $booking->booking_code,
                'customer' => $booking->user->name,
                'service' => $booking->service->name,
                'provider' => $booking->provider?->name,
                'booking_date' => $booking->booking_date->format('Y-m-d'),
                'start_time' => $booking->start_time,
                'status' => $booking->status,
                'payment_status' => $booking->payment_status,
                'total_price' => $booking->total_price,
            ]);
    }

    public function headings(): array
    {
        return [
            'Booking Code',
            'Customer',
            'Service',
            'Provider',
            'Booking Date',
            'Start Time',
            'Status',
            'Payment Status',
            'Total Price',
        ];
    }
}
