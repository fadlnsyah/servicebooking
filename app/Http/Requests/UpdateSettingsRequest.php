<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('admin') ?? false;
    }

    public function rules(): array
    {
        return [
            'business_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'phone_number' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:1000'],
            'operating_hours' => ['required', 'string', 'max:255'],
            'booking_rules' => ['nullable', 'string', 'max:2000'],
            'payment_information' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
