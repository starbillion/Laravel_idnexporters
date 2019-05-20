<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    /**
     * Index
     */
    public function index()
    {
        return view('index.member.index', $this->data);
    }
}
