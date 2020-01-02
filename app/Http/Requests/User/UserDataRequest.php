<?php

namespace App\Http\Requests\User;

use App\Constants\UserConstants;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UserDataRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:150'],
            'last_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['required', 'string', 'max:150'],
            'tag_line' => ['required', 'string', 'max:150'],
            'birth_date' => ['required', 'date', 'before:01.01.2001'],
            'abn' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:3000'],
            'type' => ['nullable', 'array', 'max:150'],
            'type.*' => ['nullable', 'string', Rule::in(UserConstants::TYPES)],
            'location' => ['required', 'array'],
            'location.name' => ['required', 'string', 'max:150'],
            'location.long_name' => ['required', 'string', 'max:150'],
            'location.place_id' => ['required', 'string', 'max:150'],
            'location.lat' => ['required', 'string', 'max:150'],
            'location.lng' => ['required', 'string', 'max:150'],
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
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(),422));
    }
}
