<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_type_id'  => 'required|exists:service_types,id',
            'pickup_address'   => 'required|string|max:255',
            'dropoff_address'  => 'required|string|max:255',
            'distance_miles'   => 'required|numeric|min:0.1',
            'scheduled_at'     => 'required|date|after:now',
            'notes'            => 'nullable|string|max:1000',
            'patient_name' => ['required', 'string', 'max:255'],
            'payment_method'       => 'required|in:online,cash,check,insurance',
            'insurance_provider'   => 'required_if:payment_method,insurance|nullable|string|max:100',
            'insurance_member_id'  => 'required_if:payment_method,insurance|nullable|string|max:100',
            'insurance_group_number' => 'nullable|string|max:100',
        ];
    }
}
