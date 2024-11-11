<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartDestroyRequest extends FormRequest
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
            'product_id' => ['required', 'exists:products,id'],
        ];
    }
}
