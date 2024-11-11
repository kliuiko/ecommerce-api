<?php

namespace App\Http\Requests;

use App\Enums\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderIndexRequest extends FormRequest
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
            'status' => ['nullable', 'string', Rule::in(OrderStatus::cases())],
            'sort_by' => ['nullable', 'string', 'in:total_amount,created_at'],
            'sort_order' => ['nullable', 'string', 'in:asc,desc']
        ];
    }
}
