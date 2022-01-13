<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'eid' => 'integer',
            'title' => 'required|string|min:3|max:12',
            'price' => 'required|numeric|between:0,200.00',
            'category_ids' => 'array|required',
            'category_ids.*' => 'integer|exists:categories,id',
        ];
    }
}
