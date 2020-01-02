<?php

namespace App\Http\Requests\Task;

use App\Constants\TaskConstants;
use Composer\DependencyResolver\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaskGetRequest extends FormRequest
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
            'type' => ['nullable', 'string', Rule::in(TaskConstants::TYPES)],
        ];
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(),422));
    }
}
