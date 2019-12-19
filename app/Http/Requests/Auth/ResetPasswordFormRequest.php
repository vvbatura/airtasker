<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'token' => 'required|string|exists:password_resets,token',
            'password' => 'required|string|min:6|max:25|confirmed',
        ];
    }
}
