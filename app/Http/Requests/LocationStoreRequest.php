<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'phone' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'address2' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'region' => ['nullable', 'string'],
            'country' => ['nullable', 'string'],
            'postal_code' => ['nullable', 'string'],
            'account_id' => ['required', 'integer', 'exists:accounts,id'],
        ];
    }
}
