<?php

namespace App\Http\Requests\Exhibition;

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
            'title'      => 'required|string|max:255',
            'slug'       => 'nullable|alpha_dash|string|max:255',
            'start_at'   => 'nullable|date_format:d-m-Y',
            'ending_at'  => 'nullable|after_or_equal:start_at|date_format:d-m-Y',
            'organizer'  => 'nullable|string|max:255',
            'venue'      => 'nullable|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'body'       => 'required|string|max:9000000',
            'featured'   => 'nullable|boolean',
            'calendar'   => 'nullable|boolean',
            'color'      => 'required|hexcolor',
            'directory'  => 'nullable|boolean',
        ];
    }
}
