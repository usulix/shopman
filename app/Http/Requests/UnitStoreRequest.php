<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitStoreRequest extends FormRequest
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
            'number' => ['nullable', 'integer', 'gt:0'],
            'make' => ['nullable', 'string'],
            'model' => ['nullable', 'string'],
            'mileage' => ['nullable', 'integer', 'gt:0'],
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
        ];
    }
}
