<?php

namespace App\Http\Controllers\Search;

use App\User;
use App\Search;
use App\ProductPost;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class PublicController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $q      = request()->input('q');
        $search = '%' . $q . '%';

        if ($q) {
            $this->data['products'] = ProductPost::approved()->hasActivePackage()->where('name', 'like', $search)->hasActivePackage()->get();
            $this->data['sellers']  = User::where('company', 'like', $search)
                ->whereRoleIs('seller')
                ->where('status', 1)
                ->hasActivePackage()
                ->get();
            $this->data['buyers'] = User::where('company', 'like', $search)
                ->orWhere('product_interests', 'like', $search)
                ->whereRoleIs('buyer')
                ->where('status', 1)
                ->get();

            Search::create([
                'q' => $q,
            ]);
        }

        $this->data['count'] = [
            'products' => ProductPost::where('name', 'like', $search)->count(),
            'sellers'  => User::where('company', 'like', $search)
                ->orWhere('main_exports', 'like', $search)
                ->whereRoleIs('seller')
                ->where('status', 1)
                ->count(),
            'buyers'   => User::where('company', 'like', $search)
                ->orWhere('product_interests', 'like', $search)
                ->whereRoleIs('buyer')
                ->where('status', 1)
                ->count(),
        ];

        return view('search.public.index', $this->data);
    }

}
