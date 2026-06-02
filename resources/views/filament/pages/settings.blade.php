<x-filament-panels::page>
    <form method="POST" action="{{ route('admin.settings.update') }}" class="sb-settings-form">
        @csrf
        @method('PATCH')

        <section class="sb-panel">
            <p class="sb-kicker">Settings</p>
            <h2 class="sb-title">Business Information</h2>

            <div class="sb-form-grid">
                <label class="sb-label">
                    <span>Business Name</span>
                    <input name="business_name" value="{{ $settings['business_name'] ?? '' }}" class="sb-input">
                    @error('business_name') <span>{{ $message }}</span> @enderror
                </label>

                <label class="sb-label">
                    <span>Contact Email</span>
                    <input name="contact_email" type="email" value="{{ $settings['contact_email'] ?? '' }}" class="sb-input">
                    @error('contact_email') <span>{{ $message }}</span> @enderror
                </label>

                <label class="sb-label">
                    <span>Phone Number</span>
                    <input name="phone_number" value="{{ $settings['phone_number'] ?? '' }}" class="sb-input">
                    @error('phone_number') <span>{{ $message }}</span> @enderror
                </label>

                <label class="sb-label">
                    <span>Operating Hours</span>
                    <input name="operating_hours" value="{{ $settings['operating_hours'] ?? '' }}" class="sb-input">
                    @error('operating_hours') <span>{{ $message }}</span> @enderror
                </label>

                <label class="sb-label sb-form-full">
                    <span>Address</span>
                    <textarea name="address" rows="3" class="sb-input sb-textarea">{{ $settings['address'] ?? '' }}</textarea>
                    @error('address') <span>{{ $message }}</span> @enderror
                </label>
            </div>
        </section>

        <section class="sb-panel">
            <p class="sb-kicker">Operations</p>
            <h2 class="sb-title">Booking and Payment</h2>

            <div class="sb-form-grid">
                <label class="sb-label sb-form-full">
                    <span>Booking Rules</span>
                    <textarea name="booking_rules" rows="4" class="sb-input sb-textarea">{{ $settings['booking_rules'] ?? '' }}</textarea>
                    @error('booking_rules') <span>{{ $message }}</span> @enderror
                </label>

                <label class="sb-label sb-form-full">
                    <span>Payment Information</span>
                    <textarea name="payment_information" rows="4" class="sb-input sb-textarea">{{ $settings['payment_information'] ?? '' }}</textarea>
                    @error('payment_information') <span>{{ $message }}</span> @enderror
                </label>
            </div>
        </section>

        <div class="sb-form-footer">
            <button class="sb-button">Save Settings</button>
        </div>
    </form>
</x-filament-panels::page>
