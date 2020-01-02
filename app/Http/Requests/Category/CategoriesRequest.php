<?php

namespace App\Http\Requests\Category;

use App\Traits\TableRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoriesRequest extends FormRequest
{
    use TableRequest;
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
        return $this->merge([
            'ids' => ['nullable', 'array'],
            'ids.*' => ['numeric', 'exists:categories,id'],
        ]);
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(),422));
    }
}
