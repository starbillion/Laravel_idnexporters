<?php

namespace App\Http\Requests\User;

use URL;
use Auth;
use App\Rules\VideoUrl;
use App\Rules\OldPassword;
use App\Rules\Url as CleanUrl;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
        if (Auth::user()->hasRole('seller|buyer')) {
            $ref = app('router')->getRoutes()->match(app('request')->create(URL::previous()))->getName();

            switch ($ref) {
                case 'member.profile.general':
                    return [
                        'salutation'   => [
                            'required',
                            Rule::in(['mr', 'mrs', 'ms', 'dr', 'prof']),
                        ],
                        'name'         => 'required|string|max:255',
                        'email'        => [
                            'required',
                            'email',
                            'max:255',
                            Rule::unique('users')->ignore(Auth::id()),
                        ],
                        'subscribe'    => 'required|boolean',
                        'old_password' => [
                            'nullable',
                            'required_with:password',
                            'string',
                            'max:20',
                            new OldPassword,
                        ],
                        'password'     => 'nullable|required_with:old_password|string|max:20|different:old_password|confirmed',
                    ];
                    break;

                case 'member.profile.complete':
                    if (Auth::user()->hasRole('seller')) {
                        return [
                            'company'        => 'required|string|max:255',
                            'business_types' => 'required|array|min:1',
                            'city'           => 'required|string|max:255',
                            'country_id'     => 'required|exists:countries,id',
                            'mobile'         => 'required|string|max:255',
                            'phone_1'        => 'required|string|max:255',
                            'fax'            => 'required|string|max:255',
                            'company_email'  => 'required|email|max:255',
                            'main_exports'   => 'required|string|max:255',
                        ];
                    } else {
                        return [
                            'company'           => 'required|string|max:255',
                            'business_types'    => 'required|array|min:1',
                            'city'              => 'required|string|max:255',
                            'country_id'        => 'required|exists:countries,id',
                            'mobile'            => 'required|string|max:255',
                            'phone_1'           => 'required|string|max:255',
                            'fax'               => 'required|string|max:255',
                            'company_email'     => 'required|email|max:255',
                            'main_imports'      => 'required|string|max:255',
                            'product_interests' => 'required|string|max:255',
                        ];
                    }
                    break;

                case 'member.profile.category':
                    if (Auth::user()->hasRole('seller')) {
                        return [
                            'categories' => 'nullable|array|max:3',
                        ];
                    } else {
                        return [
                            'categories' => 'nullable|array|max:3',
                        ];
                    }
                    break;

                case 'member.profile.company':
                    return [
                        'company'          => 'required|string|max:255',
                        'business_types'   => 'required|array|min:1',
                        'established'      => 'nullable|date_format:Y|before:this year',
                        'city'             => 'required|string|max:255',
                        'postal'           => 'nullable|regex:/^[0-9]{5}(\-[0-9]{4})?$/',
                        'country_id'       => 'required|exists:countries,id',
                        'mobile'           => 'required|string|max:255',
                        'phone_1'          => 'required|string|max:255',
                        'phone_2'          => 'required|string|max:255',
                        'fax'              => 'required|string|max:255',
                        'company_email'    => 'required|email|max:255',
                        'website'          => [
                            'nullable',
                            'max:255',
                            new CleanUrl,
                        ],
                        'language_id'      => 'nullable|exists:languages,id',
                        'address'          => 'nullable|string|max:9000',
                        'description'      => 'nullable|string|max:9000',
                        'additional_notes' => 'nullable|string|max:9000',
                    ];
                    break;

                case 'member.profile.profile':

                    if (Auth::user()->hasRole('seller')) {
                        return [
                            'main_exports'        => 'required|string|max:255',
                            'export_destinations' => 'nullable|string|max:255',
                            'current_markets'     => 'nullable|string|max:255',
                            'annual_revenue'      => 'nullable|string|max:255',
                            'factory_address'     => 'nullable|string|max:9000',
                            'certifications'      => 'nullable|string|max:9000',
                            'product_interests'   => 'nullable|string|max:255',
                        ];
                    } else {
                        return [
                            'main_imports'      => 'required|string|max:255',
                            'product_interests' => 'required|string|max:255',
                        ];
                    }

                    break;

                case 'member.profile.media':
                    return [
                        'video_1' => ['nullable', 'string', 'max:255', new VideoUrl],
                        'video_2' => ['nullable', 'string', 'max:255', new VideoUrl],
                        'video_3' => ['nullable', 'string', 'max:255', new VideoUrl],
                    ];
                    break;

                default:
                    return abort(404);
                    break;
            }
        }

        if (Auth::user()->hasRole('superadmin')) {
            return [
                'name'         => 'required|string|max:255',
                'email'        => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore(Auth::id()),
                ],

                'old_password' => [
                    'nullable',
                    'required_with:password',
                    'string',
                    'max:20',
                    new OldPassword,
                ],
                'password'     => 'nullable|required_with:old_password|string|max:20|different:old_password|confirmed',
            ];
        }
    }
}
