<x-filament-panels::page>
    <form method="POST" action="{{ route('admin.settings.update') }}" class="max-w-4xl space-y-6">
        @csrf
        @method('PATCH')
        <div class="grid gap-6 md:grid-cols-2">
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <label class="text-sm font-semibold text-gray-700">Business Name</label>
                <input name="business_name" value="{{ $settings['business_name'] ?? '' }}" class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3">
            </div>
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <label class="text-sm font-semibold text-gray-700">Contact Email</label>
                <input name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3">
            </div>
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <label class="text-sm font-semibold text-gray-700">Phone Number</label>
                <input name="phone_number" value="{{ $settings['phone_number'] ?? '' }}" class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3">
            </div>
            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                <label class="text-sm font-semibold text-gray-700">Operating Hours</label>
                <input name="operating_hours" value="{{ $settings['operating_hours'] ?? '' }}" class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3">
            </div>
        </div>
        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
            <label class="text-sm font-semibold text-gray-700">Address</label>
            <textarea name="address" rows="3" class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3">{{ $settings['address'] ?? '' }}</textarea>
        </div>
        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
            <label class="text-sm font-semibold text-gray-700">Booking Rules</label>
            <textarea name="booking_rules" rows="4" class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3">{{ $settings['booking_rules'] ?? '' }}</textarea>
        </div>
        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
            <label class="text-sm font-semibold text-gray-700">Payment Information</label>
            <textarea name="payment_information" rows="4" class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3">{{ $settings['payment_information'] ?? '' }}</textarea>
        </div>
        <button class="rounded-full bg-teal-700 px-5 py-3 text-sm font-semibold text-white">Save Settings</button>
    </form>
</x-filament-panels::page>
