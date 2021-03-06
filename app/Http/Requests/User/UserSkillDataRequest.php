<?php

namespace App\Http\Requests\User;

use App\Constants\UserConstants;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UserSkillDataRequest extends FormRequest
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
            'user' => ['numeric', 'exists:users,id'],
            'good_at' => ['required', 'string', 'max:1000'],
            'get_around' => ['required', 'array'],
            'get_around.*' => ['required', 'array', Rule::in(UserConstants::SKILLS_GET_AROUND)],
            'languages' => ['required', 'string', 'max:1000'],
            'qualifications' => ['required', 'string', 'max:1000'],
            'experience' => ['required', 'string', 'max:1000'],
        ];
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData()
    {
        return array_merge($this->route()->parameters(), $this->all());
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(),422));
    }
}
