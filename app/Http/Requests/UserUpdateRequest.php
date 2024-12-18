<?php

namespace App\Http\Requests;

use App\Traits\LockedDemoUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    use LockedDemoUser;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:80'],
            'email' => ['required', 'max:50', 'email',
                Rule::unique('users')->ignore($this->route('user')->id),
            ],
            'password' => ['nullable'],
            'isOwner' => ['required', 'boolean'],
        ];
    }
}
