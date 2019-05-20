<?php

namespace App\Http\Controllers\Traffic;

use App\ProductPost;
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
        $posts = ProductPost::select('*');

        switch (request()->input('sort')) {
            case 'product':
                $posts->orderBy('name', 'asc');
                break;
            case 'company':
                $posts->join('users', 'product_posts.user_id', '=', 'users.id')
                    ->orderBy('users.company', 'asc');
                break;
            case 'hi-traffic':
                $posts->withCount('pageviews')->orderBy('pageviews_count', 'desc');
                break;
            case 'lo-traffic':
                $posts->withCount('pageviews')->orderBy('pageviews_count', 'asc');
                break;
        }

        $this->data['products'] = $posts->paginate(config('app.pagination'));

        return view('traffic.admin.index', $this->data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $year = date('Y');

        if ($y = (int) request()->input('year')) {
            if ($y >= 2015) {
                $year = $y;
            }
        }

        $this->data['year']    = $year;
        $this->data['product'] = ProductPost::find($id) or abort(404);

        return view('traffic.admin.show', $this->data);
    }
}
