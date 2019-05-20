<?php

namespace App\Http\Middleware;

use Auth;
use Route;
use Closure;

class RedirectIfNotComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $complete = true;
        $data     = [
            'company',
            'company_email',
            'city',
            'country_id',
            'mobile',
            'phone_1',
            'business_types',
        ];

        if (Auth::user()->hasRole('seller')) {
            $data[] = 'main_exports';
        } elseif (Auth::user()->hasRole('buyer')) {
            $data[] = 'main_imports';
            $data[] = 'product_interests';
        }

        foreach ($data as $field) {
            if (Auth::user()->{$field} == null) {
                $complete = false;
            }
        }

        if (Route::currentRouteName() == 'member.profile.complete') {
            if ($complete) {
                return redirect(route('dashboard'));
            } else {
                return $next($request);
            }
        } elseif (Route::currentRouteName() == 'member.profile.update') {
            return $next($request);
        } else {
            if ($complete) {
                return $next($request);
            } else {
                return redirect(route('member.profile.complete'));
            }
        }
    }
}
