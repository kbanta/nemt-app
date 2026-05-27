<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'            => 'required|string|max:100',
            'description'     => 'nullable|string',
            'base_price'      => 'required|numeric|min:0',
            'included_miles'  => 'nullable|numeric|min:0',
            'condition_miles' => 'nullable|numeric|min:0.1',
            'price_per_mile'  => 'required|numeric|min:0',
            'is_active'       => 'boolean',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active'       => $this->boolean('is_active'),
            'included_miles'  => $this->input('included_miles') ?? 0,
            'condition_miles' => $this->input('condition_miles') ?? 1,
        ]);
    }
}
