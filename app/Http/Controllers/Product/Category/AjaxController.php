<?php

namespace App\Http\Controllers\Product\Category;

use App\ProductCategory;
use App\Http\Controllers\Controller;

class AjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ProductCategory::whereIsRoot()->get();

        return response()->json($data, 200);
    }

    public function show($id)
    {
        $data = ProductCategory::where('parent_id', $id)->get();

        return response()->json($data, 200);
    }
}
