<x-filament-panels::page>
    <form method="POST" action="{{ route('admin.settings.update') }}" class="max-w-5xl space-y-6">
        @csrf
        @method('PATCH')

        <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <div class="border-b border-gray-200 pb-4 dark:border-gray-700">
                <h2 class="text-base font-semibold text-gray-950 dark:text-white">Business Information</h2>
            </div>

            <div class="mt-5 grid gap-5 md:grid-cols-2">
                <label class="text-sm text-gray-700 dark:text-gray-200">
                    <span class="mb-1 block font-medium">Business Name</span>
                    <input name="business_name" value="{{ $settings['business_name'] ?? '' }}" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-950 shadow-sm dark:border-gray-700 dark:bg-gray-950 dark:text-white">
                    @error('business_name') <span class="mt-1 block text-sm text-danger-600">{{ $message }}</span> @enderror
                </label>

                <label class="text-sm text-gray-700 dark:text-gray-200">
                    <span class="mb-1 block font-medium">Contact Email</span>
                    <input name="contact_email" type="email" value="{{ $settings['contact_email'] ?? '' }}" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-950 shadow-sm dark:border-gray-700 dark:bg-gray-950 dark:text-white">
                    @error('contact_email') <span class="mt-1 block text-sm text-danger-600">{{ $message }}</span> @enderror
                </label>

                <label class="text-sm text-gray-700 dark:text-gray-200">
                    <span class="mb-1 block font-medium">Phone Number</span>
                    <input name="phone_number" value="{{ $settings['phone_number'] ?? '' }}" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-950 shadow-sm dark:border-gray-700 dark:bg-gray-950 dark:text-white">
                    @error('phone_number') <span class="mt-1 block text-sm text-danger-600">{{ $message }}</span> @enderror
                </label>

                <label class="text-sm text-gray-700 dark:text-gray-200">
                    <span class="mb-1 block font-medium">Operating Hours</span>
                    <input name="operating_hours" value="{{ $settings['operating_hours'] ?? '' }}" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-950 shadow-sm dark:border-gray-700 dark:bg-gray-950 dark:text-white">
                    @error('operating_hours') <span class="mt-1 block text-sm text-danger-600">{{ $message }}</span> @enderror
                </label>

                <label class="text-sm text-gray-700 dark:text-gray-200 md:col-span-2">
                    <span class="mb-1 block font-medium">Address</span>
                    <textarea name="address" rows="3" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-950 shadow-sm dark:border-gray-700 dark:bg-gray-950 dark:text-white">{{ $settings['address'] ?? '' }}</textarea>
                    @error('address') <span class="mt-1 block text-sm text-danger-600">{{ $message }}</span> @enderror
                </label>
            </div>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <div class="border-b border-gray-200 pb-4 dark:border-gray-700">
                <h2 class="text-base font-semibold text-gray-950 dark:text-white">Booking and Payment</h2>
            </div>

            <div class="mt-5 grid gap-5">
                <label class="text-sm text-gray-700 dark:text-gray-200">
                    <span class="mb-1 block font-medium">Booking Rules</span>
                    <textarea name="booking_rules" rows="4" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-950 shadow-sm dark:border-gray-700 dark:bg-gray-950 dark:text-white">{{ $settings['booking_rules'] ?? '' }}</textarea>
                    @error('booking_rules') <span class="mt-1 block text-sm text-danger-600">{{ $message }}</span> @enderror
                </label>

                <label class="text-sm text-gray-700 dark:text-gray-200">
                    <span class="mb-1 block font-medium">Payment Information</span>
                    <textarea name="payment_information" rows="4" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-950 shadow-sm dark:border-gray-700 dark:bg-gray-950 dark:text-white">{{ $settings['payment_information'] ?? '' }}</textarea>
                    @error('payment_information') <span class="mt-1 block text-sm text-danger-600">{{ $message }}</span> @enderror
                </label>
            </div>
        </section>

        <div class="flex justify-end">
            <button class="rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm">Save Settings</button>
        </div>
    </form>
</x-filament-panels::page>
