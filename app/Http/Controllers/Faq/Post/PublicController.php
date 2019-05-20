<?php

namespace App\Http\Controllers\Faq\Post;

use App\FaqCategory;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class PublicController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $this->data['faq'] = FaqCategory::with('posts')->get();

        return view('faq.post.public.index', $this->data);
    }
}
