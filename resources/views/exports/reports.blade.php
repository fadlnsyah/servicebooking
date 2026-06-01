<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ServiceBooking Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #0f172a; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #cbd5e1; padding: 8px; font-size: 12px; text-align: left; }
        th { background: #f1f5f9; }
    </style>
</head>
<body>
    <h1>ServiceBooking Report</h1>
    <p>Total Revenue: {{ format_rupiah($totalRevenue) }}</p>
    <table>
        <thead>
            <tr>
                <th>Booking Code</th>
                <th>Customer</th>
                <th>Service</th>
                <th>Date</th>
                <th>Status</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->booking_code }}</td>
                    <td>{{ $booking->customer_name }}</td>
                    <td>{{ $booking->service->name }}</td>
                    <td>{{ $booking->booking_date->format('d M Y') }}</td>
                    <td>{{ \Illuminate\Support\Str::headline($booking->status) }}</td>
                    <td>{{ format_rupiah($booking->total_price) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
