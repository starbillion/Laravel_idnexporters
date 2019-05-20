<?php

namespace App\Http\Controllers\Auth;

use App\Role;
use App\User;
use Notification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\Admin\NewMember;
use Illuminate\Auth\Events\Registered;
use Gerardojbaez\LaraPlans\Models\Plan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Jrean\UserVerification\Facades\UserVerification;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;
    use VerifiesUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo;
    protected $redirectIfVerified          = '/';
    protected $redirectAfterVerification   = '/';
    protected $redirectIfVerificationFails = '/email-verification/error';
    protected $verificationErrorView       = 'laravel-user-verification::user-verification';
    protected $verificationEmailView       = 'laravel-user-verification::email';
    protected $userTable                   = 'users';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->redirectTo                = route('dashboard');
        $this->redirectAfterVerification = route('dashboard');
        $this->middleware('guest', ['except' => ['getVerification', 'getVerificationError']]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return config('app.register.disabled')
        ? redirect()->route('login')
        : view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        if (config('app.register.disabled')) {
            return redirect()->route('login');
        }

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
                ->route('register')
                ->withInput()
                ->withErrors($validator->errors());
        }

        $user = $this->create($request->all());
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

        return redirect()->route('login', ['type' => 'verify']);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $role = Role::where('name', $data['as'])->first();
        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => $data['password'],
            'languages' => [39], // english
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
}
