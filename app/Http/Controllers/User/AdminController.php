<?php

namespace App\Http\Controllers\User;

use DB;
use Auth;
use Excel;
use App\Plan;
use App\Role;
use App\User;
use Validator;
use App\Country;
use App\Language;
use Notification;
use App\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Notifications\Admin\NewMember;
use Illuminate\Auth\Events\Registered;
use App\Notifications\User\MemberApproved;
use App\Notifications\User\MemberRejected;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Requests\User\ProfileUpdateRequest;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Jrean\UserVerification\Facades\UserVerification;
use App\Http\Requests\User\MemberUpdateRequest as UpdateRequest;

class AdminController extends Controller
{
    use RegistersUsers;
    use VerifiesUsers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type  = request()->segment(3) or abort(404);
        $users = User::with('country');

        switch (request()->input('status')) {
            case 'pending':
                $users->pending();
                break;
            case 'approved':
                $users->approved();
                break;
            case 'rejected':
                $users->rejected();
                break;
            default:
                $users->withAnyStatus();
                break;
        }

        $q      = '%' . request()->input('q') . '%';
        $search = [
            'mode'    => 'or',
            'company' => $q,
            'name'    => $q,
            'email'   => $q,
        ];

        if (request()->input('status') == 'pending') {
            $users->orderBy('created_at', 'desc');
        }

        $filter = request()->input('q') ? $search : null;
        $sort   = request()->input('sort') ? request()->input('sort') . ',asc' : 'company,asc';
        $users->pimp($filter, $sort);

        $this->data['packages'] = Plan::get();

        if ($type) {
            switch ($type) {
                case 'seller':
                    $users->whereRoleIs('seller');

                    if ($package = request()->input('package')) {
                        $users->whereHas('subscriptions', function ($q) use ($package) {
                            $q->where('plan_id', $package);
                        });
                    }

                    $this->data['users'] = $users->paginate(config('app.pagination'));
                    $this->data['count'] = [
                        'total'    => User::withAnyStatus()->whereRoleIs('seller')->count(),
                        'pending'  => User::pending()->whereRoleIs('seller')->count(),
                        'approved' => User::approved()->whereRoleIs('seller')->count(),
                        'rejected' => User::rejected()->whereRoleIs('seller')->count(),
                    ];

                    break;
                case 'buyer':
                    $users->whereRoleIs('buyer');

                    if ($package = request()->input('package')) {
                        $users->whereHas('subscriptions', function ($q) use ($package) {
                            $q->where('plan_id', $package);
                        });
                    }

                    $this->data['users'] = $users->paginate(config('app.pagination'));
                    $this->data['count'] = [
                        'total'    => User::withAnyStatus()->whereRoleIs('buyer')->count(),
                        'pending'  => User::pending()->whereRoleIs('buyer')->count(),
                        'approved' => User::approved()->whereRoleIs('buyer')->count(),
                        'rejected' => User::rejected()->whereRoleIs('buyer')->count(),
                    ];

                    break;
                default:
                    return abort(404);
                    break;
            }
        }

        return view('user.admin.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.admin.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'as'       => [
                'required',
                Rule::in(['seller', 'buyer']),
            ],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator->errors());
        }

        $user = $this->_create($request->all());
        $as   = $request->input('as') == 'seller' ? 'seller' : 'buyer';

        event(new Registered($user));
        UserVerification::generate($user);
        UserVerification::sendQueue($user, config('emails.authentication.register.subject'));

        if ($recipients = config('emails.admin.new_member.recipients')) {
            $recipients = explode(',', $recipients);

            foreach ($recipients as $recipient) {
                Notification::route('mail', trim($recipient))->notify(new NewMember($user, $as));
            }
        }

        return redirect()->route('admin.user.edit', $user->id);
    }

    protected function _create(array $data)
    {
        $role = Role::where('name', $data['as'])->first();
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'],
        ]);

        if (empty($user)) {    // Failed to register user
            redirect('/register'); // Wherever you want to redirect
        }

        $plan = Plan::where([
            'type' => ($data['as'] == 'seller' ? 'seller' : 'buyer'),
            'name' => 'regular',
        ])->first();

        $user->attachRole($role);
        $user->newSubscription('main', $plan)->create();

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['user']       = User::withAnyStatus()->find($id) or abort(404);
        $this->data['countries']  = Country::get();
        $this->data['languages']  = Language::get();
        $this->data['categories'] = ProductCategory::whereIsRoot()->get();
        $this->data['plans']      = Plan::where('type', $this->data['user']->hasRole('seller') ? 'seller' : 'buyer')->get();

        return view('user.admin.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $user = User::withAnyStatus()->find($id) or abort(404);

        if ($request->input('status')) {
            DB::beginTransaction();

            try {
                switch ($request->input('status')) {
                    case 'pending':
                        $user->markPending();
                        break;
                    case 'approved':
                        $user->markApproved();
                        $user->notify(new MemberApproved());
                        break;
                    case 'rejected':
                        $user->markRejected();
                        $user->notify(new MemberRejected());
                        break;
                    default:
                        return abort(404);
                        break;
                }

                DB::commit();

                return redirect()
                    ->back()
                    ->with('status-success', __('user.notification_update_success', ['user' => $user->company]));

            } catch (Exception $e) {
                DB::rollBack();

                return redirect()
                    ->back()
                    ->with('status-error', __('general.notification_general_error'))
                    ->withInput();
            }
        } elseif ($request->input('membership')) {
            DB::beginTransaction();

            try {
                $plan = Plan::find($request->input('membership')) or abort(404);
                $user->subscriptions()->delete();
                $user->balance = 0;
                $user->save();
                $user->newSubscription('main', $plan)->create();

                if ($plan->name == 'option_2') {
                    $user->balance = $plan->price;
                    $user->save();
                }

                if (($products = $user->products()->withAnyStatus()->count()) > 0) {
                    $user->subscriptionUsage('main')->record('products', $products);
                }

                DB::commit();

                return redirect()
                    ->back()
                    ->with('status-success', __('package.notification_update_success'));

            } catch (Exception $e) {
                DB::rollBack();

                return redirect()
                    ->back()
                    ->with('status-error', __('general.notification_general_error'))
                    ->withInput();
            }
        } else {
            $user->fill($request->input());

            if ($categories = $request->input('categories')) {
                $user->categories = $categories;
            } else {
                $user->categories = [];
            }

            return $user->save()
            ? redirect()
                ->back()
                ->with('status-success', __('user.notification_profile_success'))
            : redirect()
                ->back()
                ->with('status-error', __('general.notification_general_error'))
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::withAnyStatus()->find($id) or abort(404);

        DB::beginTransaction();

        try {
            $user->delete();
            $user->products()->delete();

            DB::commit();

            return redirect()
                ->back()
                ->with('status-success', __('user.notification_destroy_success', ['user' => $user->company]));
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('status-error', __('general.notification_general_error'))
                ->withInput();
        }
    }

    public function profile()
    {
        return view('user.admin.profile', $this->data);
    }

    public function profileUpdate(ProfileUpdateRequest $request)
    {
        $user = Auth::user();

        DB::beginTransaction();

        try {
            $user->fill(array_filter($request->input()));
            $user->save();

            DB::commit();

            return redirect()
                ->back()
                ->with('status-success', __('user.notification_profile_success'));

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('status-error', __('general.notification_general_error'))
                ->withInput();
        }
    }

    public function export()
    {
        return view('user.admin.export', $this->data);
    }

    public function export_process()
    {

        $users = User::withAnyStatus()
            ->whereRoleIs(request()->input('type') == 'seller' ? 'seller' : 'buyer')
            ->orderBy('name', 'asc')
            ->get();

        $users = $users->map(function ($item, $key) use ($users) {
            $columns = collect(request()->input('columns'))->keys()->toArray();
            $return  = [];

            foreach ($item->toArray() as $k => $v) {
                if (in_array($k, $columns)) {
                    if ($k == 'salutation') {
                        $v = __('user.' . $v);
                    } elseif ($k == 'halal' or $k == 'subscribe') {
                        $v = __('general.' . ($v == 0 ? 'no' : 'yes'));
                    } elseif ($k == 'languages') {
                        if ($v) {
                            $v = Language::whereIn('id', $v)->pluck('name')->toArray();
                            array_walk($v, function (&$value) {
                                $value = trim($value);
                            });

                            $v = implode(', ', $v);
                        }
                    }

                    $return[__('user.' . $k)] = $v;
                }
            }

            return $return;
        });

        Excel::create('IDNExporters', function ($excel) use ($users) {
            $excel->sheet('Default', function ($sheet) use ($users) {
                $sheet->fromArray($users->toArray());
            });

        })->download('xls');
    }

    public function import()
    {
        if (request()->input('draft')) {
            return response()->download(base_path('example-import.csv'));
        }

        return view('user.admin.import', $this->data);
    }

    public function import_process(Request $request)
    {
        $data  = [];
        $fail  = false;
        $file  = $request->file('file');
        $types = ['text/csv'];

        if (!in_array($file->getClientMimeType(), $types)) {
            return redirect()
                ->back()
                ->with('status-error', 'Uploaded file is not valid.');
        }

        Excel::load($file, function ($reader) use (&$fail, &$data) {
            $results = $reader->get();
            $results = $results->map(function ($value, $key) use (&$fail, &$data) {
                $value = $value->toArray();

                // email
                if (User::where('email', $value['email'])->count()) {
                    $fail = true;
                }

                // type
                $role = Role::where('name', $value['type'])->first();
                if ($role) {
                    $value['type'] = $role;
                } else {
                    $fail = true;
                }

                // package
                $value['package'] = str_replace(' ', '_', $value['package']);
                $package          = Plan::where([
                    'type' => $value['type']->name,
                    'name' => $value['package'],
                ])->first();

                if (!$package) {
                    $fail = true;
                }
                $value['package'] = $package;

                // salutation
                $value['salutation'] = strtolower(
                    in_array($value['salutation'], ['mr', 'mrs', 'ms', 'dr', 'prof'])
                    ? $value['salutation']
                    : null
                );

                // name
                $value['name'] = ucwords($value['name']);

                // company
                $value['company'] = ucwords($value['company']);

                // business_types
                $business_types          = explode(',', $value['business_types']);
                $value['business_types'] = [];
                foreach ($business_types as $i) {
                    $i = strtolower(trim($i));
                    if (in_array($i, ['manufacturer', 'wholesaler', 'distributor', 'retailer'])) {
                        $value['business_types'][] = $i;
                    }
                }

                // established
                $value['established'] = is_int($value['established']) ? $value['established'] : null;

                // city
                $value['city'] = ucwords($value['city']);

                // postal
                $value['postal'] = is_int($value['postal']) ? $value['postal'] : null;

                // country_id
                $value['country_id'] = ($country = Country::where(['name' => $value['country_id']])->first())
                ? $country->id
                : null;

                // categories
                $categories          = explode(',', $value['categories']);
                $value['categories'] = [];
                foreach ($categories as $i) {
                    $i = strtolower(trim($i));
                    if ($category = ProductCategory::select('id')->where('name', $i)->first()) {
                        $value['categories'][] = $category->id;
                    }
                }
                $value['categories'] = count($value['categories']) ? $value['categories'] : null;

                // company_email
                $value['company_email'] = filter_var($value['company_email'], FILTER_VALIDATE_EMAIL) ? $value['company_email'] : null;

                // website
                $value['website'] = strpos($value['website'], 'http') !== 0 ? 'http://' . $value['website'] : $value['website'];
                $value['website'] = filter_var($value['website'], FILTER_VALIDATE_URL) ? $value['website'] : null;

                // hide_contact
                $value['hide_contact'] = strtolower($value['hide_contact']) == 'yes' ? 1 : 0;

                // languages
                $languages          = explode(',', $value['languages']);
                $value['languages'] = [];
                foreach ($languages as $i) {
                    $i = strtolower(trim($i));
                    if ($language = Language::select('id')->where('name', $i)->first()) {
                        $value['languages'][] = $language->id;
                    }
                }
                $value['languages'] = count($value['languages']) ? $value['languages'] : null;

                // subscribe
                $value['subscribe'] = strtolower($value['subscribe']) == 'yes' ? 1 : 0;

                // halal
                $value['halal'] = strtolower($value['halal']) == 'yes' ? 1 : 0;

                // verified_member
                $value['verified_member'] = strtolower($value['verified_member']) == 'yes' ? 1 : 0;

                // ----- NO VALIDATE
                // password
                // mobile
                // phone_1
                // phone_2
                // fax
                // address
                // description
                // additional_notes
                // main_exports
                // main_imports
                // export_destinations
                // current_markets
                // annual_revenue
                // product_interests
                // factory_address
                // certifications

                $data[] = $value;

                return $value;
            });
        });

        // dd($fail, $data);

        if ($fail) {
            return redirect()
                ->back()
                ->with('status-error', 'Opps.. Something error! Make sure the data has the correct format, and also not duplicate the existing data');
        }

        DB::beginTransaction();

        try {
            foreach ($data as $user) {
                $role    = $user['type'];
                $package = $user['package'];

                unset($user['type'], $user['package']);

                $u = new User;
                $u->fill($user);
                $u->verified = 1;
                $u->save();
                $u->attachRole($role);
                $u->newSubscription('main', $package)->create();
            }

            DB::commit();

            return redirect()
                ->back()
                ->with('status-success', __('Import Success'));

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->rback()
                ->with('status-error', __('general.notification_general_error'));
        }
    }
}
