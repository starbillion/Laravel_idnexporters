<?php

namespace App\Http\Controllers\Traffic;

use Auth;
use App\ProductPost;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $year = date('Y');

        if ($y = (int) request()->input('year')) {
            if ($y >= 2015) {
                $year = $y;
            }
        }

        $this->data['year']         = (int) $year;
        $this->data['all_products'] = ProductPost::approved()->where('user_id', Auth::id())->get();
        $this->data['products']     = ProductPost::approved()->where('user_id', Auth::id())
            ->withCount('pageviews')
            ->orderBy('pageviews_count', 'desc')
            ->limit(5)
            ->get();

        return view('traffic.member.index', $this->data);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $year = date('Y');

        if ($y = (int) request()->input('year')) {
            if ($y >= 2015) {
                $year = $y;
            }
        }

        $this->data['year']         = $year;
        $this->data['product']      = ProductPost::approved()->where(['user_id' => Auth::id(), 'id' => $id])->first() or abort(404);
        $this->data['all_products'] = ProductPost::approved()->where('user_id', Auth::id())->get();

        return view('traffic.member.show', $this->data);
    }
}
