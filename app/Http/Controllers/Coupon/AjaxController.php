<?php

namespace App\Http\Controllers\Coupon;

use App\Coupon;
use App\Http\Controllers\Controller;

class AjaxController extends Controller
{
    public function show($id)
    {
        $data = Coupon::where('code', $id)->first();

        return $data
        ? response()->json($data, 200)
        : response()->json(['error' => 'true'], 400);
    }
}
