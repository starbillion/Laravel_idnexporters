<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Index
     */
    public function index()
    {
        return view('index.admin.index', $this->data);
    }
}
