<?php

namespace App\Http\Requests\Task;

use App\Constants\TaskConstants;
use Composer\DependencyResolver\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TasksShowRequest extends FormRequest
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
            'user_id' => ['nullable', 'exists:tasks,id'],
            'type' => ['nullable', 'string', Rule::in(TaskConstants::TYPES)],
            'after' => ['nullable', 'integer'],
            'price' => ['nullable', 'array'],
            'price.*' => ['required_with:price', 'integer'],
            'location' => ['nullable', 'array'],
            'location.name' => ['required_with:location', 'string', 'max:150'],
            'location.long_name' => ['required_with:location', 'string', 'max:150'],
            'location.place_id' => ['required_with:location', 'string', 'max:150'],
            'location.lat' => ['required_with:location', 'string', 'max:150'],
            'location.lng' => ['required_with:location', 'string', 'max:150'],
            'location.distance' => ['required_with:location', 'integer', 'max:101'],
            'location.type' => ['required_with:location', 'string', Rule::in(TaskConstants::PLACES)],
            'search' => ['nullable', 'string'],
        ];
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(),422));
    }
}
