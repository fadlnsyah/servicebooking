<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Review;
use App\Models\Service;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('pages.home', [
            'categories' => Category::query()->where('is_active', true)->take(6)->get(),
            'featuredServices' => Service::query()
                ->with(['category', 'provider'])
                ->where('is_active', true)
                ->latest()
                ->take(6)
                ->get(),
            'testimonials' => Review::query()
                ->with(['user', 'service'])
                ->latest()
                ->take(3)
                ->get(),
            'stats' => [
                'services' => Service::query()->count(),
                'bookings' => Booking::query()->count(),
                'customers' => Booking::query()->distinct('user_id')->count('user_id'),
            ],
            'faqs' => [
                [
                    'question' => 'How do I book a service?',
                    'answer' => 'Choose a service, select an available schedule, complete your details, and confirm the booking.',
                ],
                [
                    'question' => 'Can I reschedule my booking?',
                    'answer' => 'Yes. Signed-in customers can reschedule pending or approved bookings from My Bookings.',
                ],
                [
                    'question' => 'Which payment methods are available?',
                    'answer' => 'This demo includes Pay Later and Manual Transfer options.',
                ],
            ],
        ]);
    }
}
