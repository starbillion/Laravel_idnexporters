<?php

namespace App\Http\Controllers\Search;

use DB;
use App\Search;
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
        $this->data['searches'] = Search::select('q', DB::raw('count(*) as total'))
            ->groupBy('q')
            ->orderBy('total', 'desc')
            ->paginate(config('app.pagination'));

        return view('search.admin.index', $this->data);
    }
}
