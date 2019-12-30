<?php

namespace App\Http\Requests\Auth;

use App\Constants\SystemConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:150',
            'last_name' => 'required|string|max:150',
            'email' => 'required|email|unique:users|max:150',
            'phone' => 'required|string|unique:users|max:150',
            'password' => 'required|string|min:6|max:25|confirmed',
            'location' => ['required', 'array'],
            'location.name' => ['required', 'string', 'max:150'],
            'location.long_name' => ['required', 'string', 'max:150'],
            'location.place_id' => ['required', 'string', 'max:150'],
            'location.lat' => ['required', 'string', 'max:150'],
            'location.lng' => ['required', 'string', 'max:150'],
            'locale' => ['nullable', 'string', Rule::in(SystemConstants::LANGUAGES)],
        ];
    }
}
