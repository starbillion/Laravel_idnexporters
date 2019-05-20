<?php

namespace App\Http\Controllers\Page;

use App\Page;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class PublicController extends Controller
{
    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($slug)
    {
        $this->data['page'] = Page::whereSlug($slug)->first() or abort(404);

        return view('page.public.show', $this->data);
    }
}
