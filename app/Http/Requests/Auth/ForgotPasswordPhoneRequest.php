<?php

namespace App\Http\Requests\Auth;

use App\Constants\SystemConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ForgotPasswordPhoneRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => 'required|string|exists:users,phone',
            'locale' => ['nullable', 'string', Rule::in(SystemConstants::LANGUAGES)],
        ];
    }

}
