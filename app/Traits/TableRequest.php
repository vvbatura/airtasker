<?php

namespace App\Traits;

use App\Constants\SystemConstants;
use Illuminate\Validation\Rule;

trait TableRequest
{
    public function merge($rules)
    {

        return array_merge([
            'order_field' => 'nullable|string',
            'order_type' => 'nullable|in:ASC,DESC',
            'per_page' => 'nullable|numeric|max:500',
            'page' => 'nullable|numeric',
            'search_field' => 'nullable|string',
            'search_query' => 'nullable|string',
            'locale' => ['nullable', 'array', Rule::in(SystemConstants::LANGUAGES)],
        ], $rules);
    }

}
