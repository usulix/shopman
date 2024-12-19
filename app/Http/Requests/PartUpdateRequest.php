<?php

namespace App\Http\Requests;

use App\Models\Part;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PartUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        //return parent::messages(); // TODO: Change the autogenerated stub
        return [
            'price.prohibited' => 'You may not changed the price of an unreceived part'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {

        return [
            'number' => ['required', 'string'],
            'name' => ['required', 'string'],
            'price' => ['required', 'string',
                Rule::prohibitedIf($this->input()['received'] === 'No' &&
                    $this->input()['price'] !== Part::find($this->input()['id'])->price)
        ],
            'received' => ['required'],
        ];
    }
}
