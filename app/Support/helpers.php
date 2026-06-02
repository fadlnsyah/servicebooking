<?php

use App\Models\Booking;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (! function_exists('format_rupiah')) {
    function format_rupiah(int|float|null $amount): string
    {
        return 'Rp'.number_format((int) ($amount ?? 0), 0, ',', '.');
    }
}

if (! function_exists('booking_status_classes')) {
    function booking_status_classes(string $status): string
    {
        return match ($status) {
            Booking::STATUS_PENDING => 'bg-amber-100 text-amber-700 ring-amber-200',
            Booking::STATUS_APPROVED => 'bg-blue-100 text-blue-700 ring-blue-200',
            Booking::STATUS_COMPLETED => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
            Booking::STATUS_CANCELLED => 'bg-red-100 text-red-700 ring-red-200',
            Booking::STATUS_REJECTED => 'bg-slate-200 text-slate-700 ring-slate-300',
            Booking::STATUS_RESCHEDULED => 'bg-violet-100 text-violet-700 ring-violet-200',
            default => 'bg-slate-100 text-slate-700 ring-slate-200',
        };
    }
}

if (! function_exists('service_image_url')) {
    function service_image_url(?string $image): string
    {
        if (blank($image)) {
            return asset('images/services/default-service.svg');
        }

        if (Str::startsWith($image, ['http://', 'https://', '/'])) {
            return $image;
        }

        if (Str::startsWith($image, 'images/')) {
            return asset($image);
        }

        return Storage::disk('public')->url($image);
    }
}
