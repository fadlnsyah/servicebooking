<x-layouts.app>
    <div class="grid gap-8 lg:grid-cols-[1fr_0.9fr]">
        <div class="space-y-6">
            <x-ui.card class="p-8">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">{{ $booking->booking_code }}</p>
                        <h1 class="mt-3 text-3xl font-bold text-slate-950">{{ $booking->service->name }}</h1>
                    </div>
                    <x-ui.badge :value="$booking->status" />
                </div>
                <div class="mt-8 grid gap-4 sm:grid-cols-2">
                    <x-ui.card class="p-5"><p class="text-sm text-slate-500">Provider</p><p class="mt-2 font-bold text-slate-950">{{ $booking->provider?->name ?? 'TBA' }}</p></x-ui.card>
                    <x-ui.card class="p-5"><p class="text-sm text-slate-500">Schedule</p><p class="mt-2 font-bold text-slate-950">{{ $booking->booking_date->format('d M Y') }} • {{ \Illuminate\Support\Str::of($booking->start_time)->substr(0, 5) }}</p></x-ui.card>
                    <x-ui.card class="p-5"><p class="text-sm text-slate-500">Location</p><p class="mt-2 font-bold text-slate-950">{{ $booking->address ?: 'Not provided' }}</p></x-ui.card>
                    <x-ui.card class="p-5"><p class="text-sm text-slate-500">Total</p><p class="mt-2 font-bold text-slate-950">{{ format_rupiah($booking->total_price) }}</p></x-ui.card>
                </div>
            </x-ui.card>
            <x-ui.card class="p-8">
                <h2 class="text-2xl font-bold text-slate-950">Activity log</h2>
                <div class="mt-6 space-y-4">
                    @foreach($booking->activities as $activity)
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <div class="flex items-center justify-between gap-4">
                                <p class="font-semibold text-slate-950">{{ \Illuminate\Support\Str::headline($activity->action) }}</p>
                                <p class="text-xs text-slate-400">{{ optional($activity->created_at)->format('d M Y H:i') }}</p>
                            </div>
                            <p class="mt-1 text-sm text-slate-500">{{ $activity->description }}</p>
                            @if($activity->user)
                                <p class="mt-2 text-xs font-medium uppercase tracking-[0.2em] text-slate-400">By {{ $activity->user->name }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </x-ui.card>
        </div>
        <div class="space-y-6">
            @if($booking->user_id === auth()->id() && in_array($booking->status, ['pending', 'approved', 'rescheduled'], true))
                <x-ui.card class="p-8">
                    <h2 class="text-2xl font-bold text-slate-950">Manage booking</h2>
                    @can('cancel', $booking)
                        <form method="POST" action="{{ route('bookings.cancel', $booking) }}" class="mt-6">
                            @csrf
                            @method('PATCH')
                            <button class="rounded-full bg-red-600 px-5 py-3 text-sm font-semibold text-white">Cancel Booking</button>
                        </form>
                    @endcan
                    @can('reschedule', $booking)
                        <form method="POST" action="{{ route('bookings.reschedule', $booking) }}" class="mt-6 space-y-4">
                            @csrf
                            @method('PATCH')
                            <div>
                                <label class="text-sm font-semibold text-slate-700">Preferred Date</label>
                                <input type="date" name="preferred_date" min="{{ now()->toDateString() }}" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3" value="{{ old('preferred_date', $booking->booking_date->toDateString()) }}">
                                @error('preferred_date') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="text-sm font-semibold text-slate-700">Preferred Time</label>
                                <select name="preferred_time" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3">
                                    @foreach(['09:00', '13:30', '16:00'] as $time)
                                        <option value="{{ $time }}" @selected(old('preferred_time', \Illuminate\Support\Str::of($booking->start_time)->substr(0, 5)->value()) === $time)>{{ $time }}</option>
                                    @endforeach
                                </select>
                                @error('preferred_time') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <button class="rounded-full border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700">Reschedule</button>
                        </form>
                    @endcan
                </x-ui.card>
            @endif

            @if($booking->status === 'completed')
                <x-ui.card class="p-8">
                    <h2 class="text-2xl font-bold text-slate-950">Leave a review</h2>
                    <form method="POST" action="{{ route('bookings.review', $booking) }}" class="mt-6 space-y-4">
                        @csrf
                        <input type="number" min="1" max="5" name="rating" value="{{ old('rating', $booking->review?->rating) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3" placeholder="Rating 1-5">
                        @error('rating') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                        <textarea name="comment" rows="4" class="w-full rounded-2xl border border-slate-200 px-4 py-3" placeholder="Share your experience">{{ old('comment', $booking->review?->comment) }}</textarea>
                        @error('comment') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                        <button class="rounded-full bg-teal-700 px-5 py-3 text-sm font-semibold text-white">Submit Review</button>
                    </form>
                </x-ui.card>
            @endif
        </div>
    </div>
</x-layouts.app>
