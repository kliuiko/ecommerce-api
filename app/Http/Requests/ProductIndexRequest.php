<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductIndexRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'sort_by' => ['nullable', 'string', 'in:name,price,created_at'],
            'sort_order' => ['nullable', 'string', 'in:asc,desc']
        ];
    }
}
