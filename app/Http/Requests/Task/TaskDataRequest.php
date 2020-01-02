<?php

namespace App\Http\Requests\Task;

use App\Constants\SystemConstants;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class TaskDataRequest extends FormRequest
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
            'task' => ['numeric', 'exists:tasks,id'],
            'title' => ['required', 'string', 'max:150'],
            'details' => ['required', 'string', 'max:3000'],
            'date' => ['required', 'date'],
            'price_total' => ['required_without:price_hourly', 'integer'],
            'price_hourly' => ['required_without:price_total', 'integer'],
            'location' => ['array'],
            'location.name' => ['string', 'max:150'],
            'location.long_name' => ['string', 'max:150'],
            'location.place_id' => ['string', 'max:150'],
            'location.lat' => ['string', 'max:150'],
            'location.lng' => ['string', 'max:150'],
            'locale' => ['nullable', 'string', Rule::in(SystemConstants::LANGUAGES)],
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
