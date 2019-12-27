<?php

namespace App\Http\Requests\Auth;

use App\ConfigProject\Constants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResetPasswordFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'token' => 'required|string',
            'password' => 'required|string|min:6|max:25|confirmed',
            'locale' => ['nullable', 'string', Rule::in(Constants::LANGUAGES)],
        ];
    }
}
