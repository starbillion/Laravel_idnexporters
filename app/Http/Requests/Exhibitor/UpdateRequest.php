<?php

namespace App\Http\Requests\Exhibitor;

use App\Rules\VideoUrl;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'address'     => 'required|string|max:90000',
            'description' => 'required|string|max:90000',
            'country_id'  => 'required|exists:countries,id',
            'phone'       => 'required|string|max:255',
            'fax'         => 'nullable|string|max:255',
            'categories'  => 'required|array|max:3',
            'video'       => ['nullable', 'string', 'max:255', new VideoUrl],
        ];
    }
}
