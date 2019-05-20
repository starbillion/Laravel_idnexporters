<?php

namespace App\Widgets\Product;

use App\ProductCategory;
use Arrilot\Widgets\AbstractWidget;

class FeaturedCategory extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $return     = [];
        $categories = ProductCategory::whereHas('posts', function ($q) {
            $q->where('status', 1)->hasActivePackage()->groupBy('category_id');
        })
            ->withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->pluck('id');

        foreach ($categories as $category) {
            $return[] = ProductCategory::ancestorsAndSelf($category)[0];
        }

        $data['categories'] = collect($return)->unique()->take(4);

        return view('_widgets.featured_categories', $data);
    }
}
