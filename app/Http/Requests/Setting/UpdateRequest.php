<?php

namespace App\Http\Requests\Setting;

use URL;
use App\Rules\EmailsCommaSeparated;
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
        $ref = app('router')->getRoutes()->match(app('request')->create(URL::previous()))->getName();

        switch ($ref) {
            case 'admin.setting.company':
                return [
                    'name'              => 'required|string|max:255',
                    'company.name'      => 'required|string|max:255',
                    'company.phone'     => 'required|string|max:255',
                    'company.fax'       => 'required|string|max:255',
                    'company.address_1' => 'required|string|max:255',
                    'company.address_2' => 'required|string|max:255',
                    'company.address_3' => 'required|string|max:255',
                    'billing_info'      => 'required|string|max:9000',
                    'billing_info_intl' => 'required|string|max:9000',
                ];
                break;
            case 'admin.setting.application':
                return [
                    'pagination' => 'required|numeric|min:10|max:50',
                    'admin_path' => 'required|alpha_dash|string|max:255',
                ];
                break;
            case 'admin.setting.email':

                foreach (config('emails') as $section => $forms) {
                    foreach ($forms as $form => $field) {
                        if (isset($field['subject'])) {
                            $return[$section . '_' . $form . '_subject'] = 'required|string|max:255';
                        }
                        if (isset($field['button'])) {
                            $return[$section . '_' . $form . '_button'] = 'required|string|max:255';
                        }
                        if (isset($field['body'])) {
                            $return[$section . '_' . $form . '_body'] = 'required|string|max:255';
                        }
                        if (isset($field['recipients'])) {
                            $return[$section . '_' . $form . '_recipients'] = [
                                'required',
                                'string',
                                'max:255',
                                new EmailsCommaSeparated,
                            ];
                        }
                    }
                }

                return $return;
                break;

            default:
                return abort(404);
                break;
        }
    }
}
