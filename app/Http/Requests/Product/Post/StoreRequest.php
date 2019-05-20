<?php

namespace App\Http\Requests\Product\Post;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name'           => 'required|string|max:255',
            'currency_id'    => 'required|exists:currencies,id',
            'price'          => 'required|string|max:255',
            'category_id-1'  => 'required|exists:product_categories,id',
            'category_id-2'  => 'required|exists:product_categories,id',
            'category_id-3'  => 'required|exists:product_categories,id',
            'supply_ability' => 'nullable|string|max:255',
            'fob_port'       => 'nullable|string|max:255',
            'payment_term'   => 'nullable|string|max:255',
            'minimum_order'  => 'nullable|string|max:255',
            'description_en' => 'nullable|string|max:9000',
            'description_id' => 'nullable|string|max:9000',
            'description_zh' => 'nullable|string|max:9000',
        ];
    }
}
