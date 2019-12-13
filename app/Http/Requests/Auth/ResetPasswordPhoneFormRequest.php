<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordPhoneFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'token' => 'required',
            'phone' => 'required|string',
            'password' => 'required|string|min:6|max:25|confirmed',
        ];
    }
}
