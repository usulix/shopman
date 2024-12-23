<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartStoreRequest extends FormRequest
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
            'number' => ['required', 'string'],
            'name' => ['required', 'string'],
            'price' => ['required', 'integer', 'gt:0'],
            'received' => ['required'],
        ];
    }
}
