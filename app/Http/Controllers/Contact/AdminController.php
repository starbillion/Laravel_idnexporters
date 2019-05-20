<?php

namespace App\Http\Controllers\Contact;

use App\Contact;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q       = '%' . request()->input('q') . '%';
        $filters = [
            'mode'   => 'or',
            'name'   => $q,
            'email'  => $q,
            'mobile' => $q,
        ];
        $filter = request()->input('q') ? $filters : null;
        $sort   = request()->input('sort') ? request()->input('sort') . ',asc' : null;
        $posts  = Contact::pimp($filter, $sort);

        $this->data['posts'] = $posts->paginate(config('app.pagination'));

        return view('contact.admin.index', $this->data);
    }
}
