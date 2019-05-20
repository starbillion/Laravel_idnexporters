<?php

namespace App\Http\Controllers\Setting;

use URL;
use Config;
use Artisan;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\UpdateRequest;

class AdminController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.setting.company');
    }

    public function company()
    {
        return view('setting.admin.company', $this->data);
    }

    public function application()
    {
        return view('setting.admin.application', $this->data);
    }

    public function email()
    {
        return view('setting.admin.email', $this->data);
    }

    public function update(UpdateRequest $request)
    {
        $ref = app('router')->getRoutes()->match(app('request')->create(URL::previous()))->getName();

        switch ($ref) {
            /*********** Company ***********/
            case 'admin.setting.company':
                $data = array_only($request->input(), [
                    'name',
                    'company',
                    'billing_info',
                    'billing_info_intl',
                ]);

                Config::write('app', $data);
                Artisan::call('config:clear');
                Artisan::call('key:generate');

                return redirect()
                    ->back()
                    ->with('status-success', __('setting.notification_update_success'));
                break;

            /*********** Application ***********/
            case 'admin.setting.application':
                $data = array_only($request->input(), [
                    'pagination',
                    'admin_path',
                ]);

                Config::write('app', $data);
                Artisan::call('config:clear');
                Artisan::call('key:generate');

                return redirect($data['admin_path'] . '/setting/application')
                    ->with('status-success', __('setting.notification_update_success'));
                break;

            /*********** Email ***********/
            case 'admin.setting.email':
                $config = new \Larapack\ConfigWriter\Repository('emails');

                foreach (config('emails') as $section => $forms) {
                    foreach ($forms as $form => $field) {
                        if (isset($field['subject'])) {
                            $config->set($section . '.' . $form . '.subject', $request->input($section . '_' . $form . '_subject'));
                        }
                        if (isset($field['button'])) {
                            $config->set($section . '.' . $form . '.button', $request->input($section . '_' . $form . '_button'));
                        }
                        if (isset($field['body'])) {
                            $config->set($section . '.' . $form . '.body', $request->input($section . '_' . $form . '_body'));
                        }
                        if (isset($field['recipients'])) {
                            $config->set($section . '.' . $form . '.recipients', $request->input($section . '_' . $form . '_recipients'));
                        }
                    }
                }

                $config->save();

                Artisan::call('config:clear');
                Artisan::call('queue:restart');
                Artisan::call('key:generate');

                return redirect()
                    ->back()
                    ->with('status-success', __('setting.notification_update_success'));
                break;

            default:
                return abort(404);
                break;
        }
    }
}
