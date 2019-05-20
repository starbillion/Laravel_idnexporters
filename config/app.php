<?php

return [

    'name'              => 'IDNExporters',
    'tagline'           => 'Your next sourcing solutions from Indonesia',
    'admin_path'        => 'admin',
    'theme'             => 'pulse', // default, elegance, pulse, flat, corporate, earth
    'locale'            => 'en',
    'timezone'          => 'Asia/Jakarta',
    'pagination'        => '20',
    'calendar_min_year' => 2,
    'calendar_max_year' => 2,
    'register'          => [
        'disabled' => false,
        'role'     => 'seller',
    ],

    'company'           => [
        'name'      => 'PT. Aremgo Grafindo',
        'address_1' => 'Jl. Batu Jajar, No. 4B',
        'address_2' => 'Jakarta - 10120',
        'address_3' => 'Indonesia',
        'phone'     => '+62213854348',
        'fax'       => '+62213852892',
    ],

    'billing_info'      => '<table class="table table-bordered">
            <tbody>
                <tr>
                    <td><b>PT. Aremgo Grafindo</b><br>Jl. Batu Jajar, No. 4B&nbsp;
                        <br>Jakarta - 10120
                        <br>Indonesia&nbsp;
                        <br>Tel : +62213854348&nbsp;
                        <br>Fax : +62213852892
                        <br>Email : billing@idnexporters.com
                        <br>
                    </td>
                    <td>
                        <p><span style="font-weight: bolder;">Pay To :</span></p>
                        <p><span style="font-weight: bolder; background-color: transparent; font-family: -apple-system, system-ui, BlinkMacSystemFont, " segoe="" ui",="" roboto,="" "helvetica="" neue",="" arial,="" sans-serif;"="">Bank : BCA : 284-3002773<br></span><span style="font-weight: bolder; background-color: transparent; font-family: -apple-system, system-ui, BlinkMacSystemFont, " segoe="" ui",="" roboto,="" "helvetica="" neue",="" arial,="" sans-serif;"="">Name :&nbsp;PT. Aremgo Grafindo</span></p>
                        <p>Please email or fax copy of transfer to activate your account option.</p></td></tr></tbody></table>',

    'billing_info_intl' => '<table class="table table-bordered" style="width: 796px;"><tbody><tr><td><span style="font-weight: bolder;">PT. Aremgo Grafindo</span> <br>Jl. Batu Jajar, No. 4B  <br>Jakarta - 10120 <br>Indonesia  <br>Tel : +62213854348  <br>Fax : +62213852892 <br>Email : billing@idnexporters.com <br></td><td><p><span style="font-weight: bolder;">Pay To :</span></p><p><span segoe="" ui",="" roboto,="" "helvetica="" neue",="" arial,="" sans-serif;"="" style="background-color: transparent;"><b>USD : 0902307737 <br>Bank : Bank Permata Cab Hayam Wuruk Jakarta <br>Swift : BBBAIDJA</b><br></span></p><p>Please email or fax copy of transfer to activate your account option.</p><div><br></div></td></tr></tbody></table>',

    /****************************/

    'version'           => '2.0.0',
    'env'               => 'local',
    'debug'             => true,
    'url'               => 'http://idnexporters.dev',
    'fallback_locale'   => 'en',
    'key'               => 'base64:xACa1wWY8f4ceAOOupIHEh1GTFpCiNDbi/E0uxMLaoA=',
    'cipher'            => 'AES-256-CBC',
    'log'               => 'single',
    'log_level'         => 'debug',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
     */

    'providers'         => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,
        Gerardojbaez\LaraPlans\LaraPlansServiceProvider::class,

        /*
         * Package Service Providers...
         */
        Jrean\UserVerification\UserVerificationServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        Thomaswelton\LaravelGravatar\LaravelGravatarServiceProvider::class,
        Fadion\Fixerio\ExchangeServiceProvider::class,
        Hootlex\Moderation\ModerationServiceProvider::class,
        Orangehill\Iseed\IseedServiceProvider::class,
        Cmgmyr\Messenger\MessengerServiceProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
     */

    'aliases'           => [

        'App'          => Illuminate\Support\Facades\App::class,
        'Artisan'      => Illuminate\Support\Facades\Artisan::class,
        'Auth'         => Illuminate\Support\Facades\Auth::class,
        'Blade'        => Illuminate\Support\Facades\Blade::class,
        'Broadcast'    => Illuminate\Support\Facades\Broadcast::class,
        'Bus'          => Illuminate\Support\Facades\Bus::class,
        'Cache'        => Illuminate\Support\Facades\Cache::class,
        // 'Config'       => Illuminate\Support\Facades\Config::class,
        'Config'       => Larapack\ConfigWriter\Facade::class,
        'Cookie'       => Illuminate\Support\Facades\Cookie::class,
        'Crypt'        => Illuminate\Support\Facades\Crypt::class,
        'DB'           => Illuminate\Support\Facades\DB::class,
        'Eloquent'     => Illuminate\Database\Eloquent\Model::class,
        'Event'        => Illuminate\Support\Facades\Event::class,
        'File'         => Illuminate\Support\Facades\File::class,
        'Gate'         => Illuminate\Support\Facades\Gate::class,
        'Hash'         => Illuminate\Support\Facades\Hash::class,
        'Lang'         => Illuminate\Support\Facades\Lang::class,
        'Log'          => Illuminate\Support\Facades\Log::class,
        'Mail'         => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password'     => Illuminate\Support\Facades\Password::class,
        'Queue'        => Illuminate\Support\Facades\Queue::class,
        'Redirect'     => Illuminate\Support\Facades\Redirect::class,
        'Redis'        => Illuminate\Support\Facades\Redis::class,
        'Request'      => Illuminate\Support\Facades\Request::class,
        'Response'     => Illuminate\Support\Facades\Response::class,
        'Route'        => Illuminate\Support\Facades\Route::class,
        'Schema'       => Illuminate\Support\Facades\Schema::class,
        'Session'      => Illuminate\Support\Facades\Session::class,
        'Storage'      => Illuminate\Support\Facades\Storage::class,
        'URL'          => Illuminate\Support\Facades\URL::class,
        'Validator'    => Illuminate\Support\Facades\Validator::class,
        'View'         => Illuminate\Support\Facades\View::class,
        'Gravatar'     => Thomaswelton\LaravelGravatar\Facades\Gravatar::class,
        'Exchange'     => Fadion\Fixerio\Facades\Exchange::class,

    ],

];
