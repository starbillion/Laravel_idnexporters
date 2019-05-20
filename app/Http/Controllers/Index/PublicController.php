<?php

namespace App\Http\Controllers\Index;

use App\User;
use Carbon\Carbon;
use App\Exhibition;
use App\ProductPost;
use App\ProductCategory;
use App\Http\Controllers\Controller;

class PublicController extends Controller
{
    /**
     * Index
     */
    public function index()
    {
        $this->data['products'] = ProductPost::with('category')
            ->whereHas('owner.subscriptions', function ($q) {
                $q->whereIn('plan_id', [2, 3, 4]);
            })
            ->inRandomOrder()
            ->limit(20)
            ->get();
        $this->data['featured_exhibition'] = Exhibition::where('featured', true)
            ->where('start_at', '>=', Carbon::now())
            ->limit(8)
            ->orderBy('start_at')
            ->get();
        $this->data['count'] = [
            'sellers'    => User::whereRoleIs(['seller'])->count(),
            'buyers'     => User::whereRoleIs(['buyer'])->count(),
            'products'   => ProductPost::count(),
            'categories' => ProductCategory::count(),
        ];

        return view('index.public.index', $this->data);
    }
}
