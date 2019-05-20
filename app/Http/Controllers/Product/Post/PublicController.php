<?php

namespace App\Http\Controllers\Product\Post;

use App\ProductPost;
use App\ProductCategory;
use App\ProductPostVisit;
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
        $products               = ProductPost::approved()->hasActivePackage();
        $this->data['category'] = null;

        if ($category = request()->input('category')) {
            $this->data['category'] = ProductCategory::find($category) or abort(404);
            $categories             = ProductCategory::whereDescendantOrSelf($this->data['category']->id)->get()->pluck('id');

            $products->whereIn('category_id', $categories);
        } else {
            $products->whereHas('owner.subscriptions', function ($q) {
                $q->whereIn('plan_id', [2, 3, 4]);
            });
        }

        switch (request()->input('sort')) {
            case 'featured':
                $products->with(['owner.subscriptions' => function ($q) {
                    $q->orderBy('plan_id', 'asc');
                }]);
                break;
            case 'popularity':
                $products->popularAllTime();
                break;
            default:
                $products->pimp(null, 'created_at,desc');
                break;
        }

        $this->data['products'] = $products->paginate(config('app.pagination'));

        return view('product.post.public.index', $this->data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->data['product'] = ProductPost::approved()->hasActivePackage()->find($id) or abort(404);

        $this->data['other_products'] = ProductPost::approved()->hasActivePackage()->where('user_id', $this->data['product']->user_id)
            ->whereNotIn('id', [$this->data['product']->id])
            ->limit(4)
            ->popularAllTime()
            ->get();

        $this->data['product']->visit();
        ProductPostVisit::insert(['product_id' => $id, 'created_at' => now(), 'updated_at' => now()]);

        if ($this->data['product']->owner->balance > 0) {
            $this->data['product']->owner->decrement('balance', 2000);
        }

        return view('product.post.public.show', $this->data);
    }
}
