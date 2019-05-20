<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Index
     */
    public function index()
    {
        if (Auth::user()->hasRole('seller') or Auth::user()->hasRole('buyer')) {
            return redirect()->route('member.index');
        }

        return redirect()->route('admin.index');
    }
}
