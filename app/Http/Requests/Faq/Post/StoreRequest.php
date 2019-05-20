<?php

namespace App\Http\Requests\Faq\Post;

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
            'question'    => 'required|string|max:255',
            'category_id' => 'required|exists:faq_categories,id',
            'answer'      => 'required|string|max:9000',
        ];
    }
}
