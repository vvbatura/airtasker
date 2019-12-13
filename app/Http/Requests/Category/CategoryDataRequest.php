<?php

namespace App\Http\Requests\Category;

use App\ConfigProject\Constants;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryDataRequest extends FormRequest
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
        $fieldTitleL1 = 'title.' . Constants::LANGUAGE_EN;
        $fieldTitleL2 = 'title.' . Constants::LANGUAGE_DE;
        $fieldDescriptionL1 = 'description.' . Constants::LANGUAGE_EN;
        $fieldDescriptionL2 = 'description.' . Constants::LANGUAGE_DE;
        return [
            'category' => ['numeric', 'exists:categories,id'],
            'title' => ['required', 'array'],
            $fieldTitleL1 => ['required', 'string'],
            $fieldTitleL2 => ['required', 'string'],
            'description' => ['required', 'array'],
            $fieldDescriptionL1 => ['required', 'string'],
            $fieldDescriptionL2 => ['required', 'string'],
            'image' => ['nullable', 'string'],
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
