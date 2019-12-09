<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'first_name' => 'required|string|unique:users|max:150',
            'last_name' => 'required|string|unique:users|max:150',
            'email' => 'required|email|unique:users|max:150',
            'phone' => 'required|string|unique:users|max:150',
            'password' => 'required|string|min:6|max:25|confirmed',
        ];
    }
}
