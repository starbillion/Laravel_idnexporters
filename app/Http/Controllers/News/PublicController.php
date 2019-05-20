<?php

namespace App\Http\Controllers\News;

use App\News;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class PublicController extends Controller
{
    /**
     * Show the specified resource.
     * @return Response
     */
    public function index()
    {
        $this->data['posts'] = News::orderBy('id', 'desc')->paginate(config('app.pagination'));

        return view('news.public.index', $this->data);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($slug)
    {
        $this->data['post'] = News::whereSlug($slug)->first() or abort(404);

        return view('news.public.show', $this->data);
    }
}
