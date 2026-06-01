<x-layouts.app>
    <div
        x-data="{
            preferredDate: @js(old('preferred_date', now()->toDateString())),
            preferredTime: @js(old('preferred_time', $timeOptions[0] ?? '09:00')),
            paymentMethod: @js(old('payment_method', 'pay_later')),
            quickDate(date) { this.preferredDate = date },
            formattedDate() {
                if (! this.preferredDate) return 'Choose date';
                return new Intl.DateTimeFormat('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }).format(new Date(this.preferredDate));
            },
            paymentLabel() {
                return this.paymentMethod === 'manual_transfer' ? 'Manual Transfer' : 'Pay Later';
            }
        }"
        class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr]"
    >
        <div class="space-y-6">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-teal-700">Booking Workflow</p>
                <h1 class="mt-3 text-4xl font-bold text-slate-950">Book {{ $service->name }}</h1>
            </div>
            <x-ui.card class="p-8">
                <div class="mb-8 grid gap-4 sm:grid-cols-5">
                    @foreach(['Select Service', 'Choose Date & Time', 'Customer Information', 'Review Booking', 'Confirmation'] as $index => $step)
                        <div class="{{ $index === 1 ? 'bg-teal-700 text-white' : 'bg-slate-100 text-slate-500' }} rounded-2xl px-4 py-3 text-center text-xs font-semibold uppercase tracking-[0.2em]">
                            {{ $step }}
                        </div>
                    @endforeach
                </div>
                <form method="POST" action="{{ route('bookings.store') }}" class="space-y-5">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label class="text-sm font-semibold text-slate-700">Full Name</label>
                            <input name="full_name" value="{{ old('full_name', auth()->user()->name) }}" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3">
                            @error('full_name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-slate-700">Email</label>
                            <input name="email" type="email" value="{{ old('email', auth()->user()->email) }}" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3">
                            @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-slate-700">Phone Number</label>
                            <input name="phone_number" value="{{ old('phone_number', auth()->user()->phone) }}" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3">
                            @error('phone_number') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-slate-700">Preferred Date</label>
                            <input type="date" name="preferred_date" x-model="preferredDate" min="{{ now()->toDateString() }}" value="{{ old('preferred_date', now()->toDateString()) }}" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3">
                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach($scheduleOptions as $option)
                                    <button type="button" @click="quickDate('{{ $option['date'] }}')" class="rounded-full border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 transition hover:border-teal-300 hover:text-teal-700">{{ $option['label'] }}</button>
                                @endforeach
                            </div>
                            @error('preferred_date') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-slate-700">Preferred Time</label>
                            <select name="preferred_time" x-model="preferredTime" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3">
                                @foreach($timeOptions as $time)
                                    <option value="{{ $time }}" @selected(old('preferred_time', $timeOptions[0] ?? null) === $time)>{{ $time }}</option>
                                @endforeach
                            </select>
                            @error('preferred_time') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-slate-700">Payment Method</label>
                            <select name="payment_method" x-model="paymentMethod" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3">
                                <option value="pay_later" @selected(old('payment_method', 'pay_later') === 'pay_later')>Pay Later</option>
                                <option value="manual_transfer" @selected(old('payment_method') === 'manual_transfer')>Manual Transfer</option>
                            </select>
                            @error('payment_method') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Address / Location</label>
                        <textarea name="address" rows="3" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3">{{ old('address') }}</textarea>
                        @error('address') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Notes / Special Request</label>
                        <textarea name="notes" rows="3" class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3">{{ old('notes') }}</textarea>
                        @error('notes') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <button class="rounded-full bg-teal-700 px-6 py-4 text-sm font-semibold text-white">Confirm Booking</button>
                </form>
            </x-ui.card>
        </div>

        <x-ui.card class="h-fit p-8">
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-teal-700">Booking Summary</p>
            <h2 class="mt-3 text-2xl font-bold text-slate-950">{{ $service->name }}</h2>
            <div class="mt-6 space-y-4 text-sm text-slate-600">
                <div class="flex justify-between"><span>Provider</span><span>{{ $service->provider?->name ?? 'TBA' }}</span></div>
                <div class="flex justify-between"><span>Date</span><span x-text="formattedDate()"></span></div>
                <div class="flex justify-between"><span>Time</span><span x-text="preferredTime || 'Choose time'"></span></div>
                <div class="flex justify-between"><span>Duration</span><span>{{ $service->duration_minutes }} min</span></div>
                <div class="flex justify-between"><span>Price</span><span>{{ format_rupiah($service->price) }}</span></div>
                <div class="flex justify-between"><span>Admin fee</span><span>{{ format_rupiah(25000) }}</span></div>
                <div class="flex justify-between border-t border-slate-200 pt-4 text-base font-bold text-slate-950"><span>Total</span><span>{{ format_rupiah($service->price + 25000) }}</span></div>
                <div class="flex justify-between"><span>Payment status</span><span>Unpaid</span></div>
                <div class="flex justify-between"><span>Payment method</span><span x-text="paymentLabel()"></span></div>
            </div>
        </x-ui.card>
    </div>
</x-layouts.app>
