<?php

namespace App\Http\Controllers;

use App\Exports\BookingsExport;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportExportController extends Controller
{
    public function pdf(): Response
    {
        $bookings = Booking::query()->with(['user', 'service', 'provider'])->latest('booking_date')->get();

        $pdf = Pdf::loadView('exports.reports', [
            'bookings' => $bookings,
            'totalRevenue' => $bookings->where('status', 'completed')->sum('total_price'),
        ]);

        return $pdf->download('servicebooking-report.pdf');
    }

    public function excel(): BinaryFileResponse
    {
        return Excel::download(new BookingsExport, 'servicebooking-report.xlsx');
    }
}
