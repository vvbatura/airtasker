<?php

namespace App\Http\Requests\Category;

use App\Constants\SystemConstants;
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
        $fieldTitleL1 = 'title.' . SystemConstants::LANGUAGE_EN;
        $fieldTitleL2 = 'title.' . SystemConstants::LANGUAGE_DE;
        $fieldDescriptionL1 = 'description.' . SystemConstants::LANGUAGE_EN;
        $fieldDescriptionL2 = 'description.' . SystemConstants::LANGUAGE_DE;
        return [
            'category' => ['numeric', 'exists:categories,id'],
            'title' => ['required', 'array'],
            $fieldTitleL1 => ['required', 'string', 'max:150'],
            $fieldTitleL2 => ['required', 'string', 'max:150'],
            'description' => ['required', 'array'],
            $fieldDescriptionL1 => ['required', 'string', 'max:3000'],
            $fieldDescriptionL2 => ['required', 'string', 'max:3000'],
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
