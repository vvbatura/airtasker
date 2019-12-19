<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

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
            'location.google_place_id' => ['required', 'string', 'max:150'],
            'location.lat' => ['required', 'string', 'max:150'],
            'location.lng' => ['required', 'string', 'max:150'],
        ];
    }
}
