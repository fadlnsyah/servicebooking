<?php

namespace App\Http\Controllers;

use App\Exports\BookingsExport;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportExportController extends Controller
{
    public function pdf(Request $request): Response
    {
        $user = $request->user();
        abort_unless($user?->hasAnyRole(['admin', 'provider']), 403);

        $bookings = Booking::query()
            ->with(['user', 'service', 'provider'])
            ->visibleTo($user)
            ->when($request->filled('start_date'), fn ($query) => $query->whereDate('booking_date', '>=', $request->date('start_date')))
            ->when($request->filled('end_date'), fn ($query) => $query->whereDate('booking_date', '<=', $request->date('end_date')))
            ->latest('booking_date')
            ->get();

        $pdf = Pdf::loadView('exports.reports', [
            'bookings' => $bookings,
            'totalRevenue' => $bookings->where('status', 'completed')->sum('total_price'),
            'reportLabel' => $user->isProvider() ? 'Provider Report' : 'Operations Report',
        ]);

        return $pdf->download('servicebooking-report.pdf');
    }

    public function excel(Request $request): BinaryFileResponse
    {
        $user = $request->user();
        abort_unless($user?->hasAnyRole(['admin', 'provider']), 403);

        return Excel::download(
            new BookingsExport(
                $user,
                $request->filled('start_date') ? $request->date('start_date')?->toDateString() : null,
                $request->filled('end_date') ? $request->date('end_date')?->toDateString() : null,
            ),
            'servicebooking-report.xlsx',
        );
    }
}
