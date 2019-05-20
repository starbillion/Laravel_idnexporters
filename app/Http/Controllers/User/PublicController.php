<?php

namespace App\Http\Controllers\User;

use Auth;
use App\User;
use App\ProductPost;
use App\MessengerThread;
use App\ProductCategory;
use App\Http\Controllers\Controller;

class PublicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        switch (request()->segment(2)) {
            case 'seller':
                if (request()->input('splash') == 1) {
                    return view('user.public.seller_spash', $this->data);
                }

                $users = User::approved();

                if ($category = request()->input('category')) {
                    $this->data['category'] = ProductCategory::find($category) or abort(404);
                    $categories             = ProductCategory::whereDescendantOrSelf($this->data['category']->id)->get()->pluck('id');

                    $users->where(function ($query) use ($categories) {
                        $categories = $categories->toArray();
                        $firstId    = array_shift($categories);

                        $query->whereRaw(
                            'JSON_CONTAINS(categories, \'["' . $firstId . '"]\')'
                        );

                        foreach ($categories as $id) {
                            $query->orWhereRaw(
                                'JSON_CONTAINS(categories, \'["' . $id . '"]\')'
                            );
                        }

                        return $query;
                    });
                } else {
                    $users->whereHas('subscriptions', function ($q) {
                        $q->whereIn('plan_id', [2, 3, 4]);
                    });
                }

                $this->data['users'] = $users->paginate(config('app.pagination'));

                return view('user.public.seller', $this->data);
                break;

            case 'buyer':
                if (request()->input('splash') == 1) {
                    return view('user.public.buyer_spash', $this->data);
                }

                $buyers         = User::approved()->whereRoleIs(['buyer']);
                $buyers_counter = User::approved()->whereRoleIs(['buyer']);

                if ($country = request()->input('country')) {
                    $buyers->where('country_id', $country);
                    $buyers_counter->where('country_id', $country);
                }

                if ($q = request()->input('q')) {
                    $buyers->where('product_interests', 'like', '%' . $q . '%');
                    $buyers_counter->where('product_interests', 'like', '%' . $q . '%');
                }

                $this->data['buyers']       = $buyers->paginate(config('app.pagination'));
                $this->data['buyers_count'] = $buyers_counter->count();

                return view('user.public.buyer', $this->data);
                break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->data['user'] = User::whereRoleIs('seller')->hasActivePackage()->find($id) or abort(404);

        if (!$this->data['user']->subscription('main')->ability()->canUse('public_page')) {
            return abort(404);
        }

        $products               = ProductPost::with('category')->where('user_id', $this->data['user']->id);
        $this->data['category'] = null;

        if ($category = request()->input('category')) {
            $this->data['category'] = ProductCategory::find($category) or abort(404);
            $categories             = ProductCategory::whereDescendantOrSelf($this->data['category']->id)->get()->pluck('id');

            $products->whereIn('category_id', $categories);
        }

        switch (request()->input('sort')) {
            case 'popularity':
                $products->popularMonth();
                break;

            default:
                $products->pimp(null, 'created_at,desc');
                break;
        }

        $this->data['products'] = $products->withAnyStatus()->paginate(config('app.pagination'));
        $this->data['exists']   = MessengerThread::between([Auth::id(), $id])
            ->latest('updated_at')
            ->first();

        return view('user.public.show', $this->data);
    }

    public function qr($id)
    {
        return response()->download(getQrCode($id, true), 'QR Code.png');
    }
}
