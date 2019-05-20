<?php

namespace App\Widgets\Product;

use App\User;
use App\ProductPost;
use App\ProductCategory;
use Arrilot\Widgets\AbstractWidget;

class CategoriesUser extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'category' => null,
        'route'    => false,
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $categories_from_users = User::where('status', 1)->whereRoleIs('seller')->hasActivePackage()->get()->pluck('categories');
        $categories_from_users = array_filter(array_unique(array_flatten((array) $categories_from_users)));
        $data                  = [];
        $return                = [];
        $request               = $this->config['category'];
        $categories            = ProductCategory::whereIn('id', $categories_from_users)->get();

        foreach ($categories as $category) {
            $ancestors = ProductCategory::ancestorsAndSelf($category);

            if (!isset($return[$ancestors[0]->id])) {
                $return[$ancestors[0]->id]['category'] = $ancestors[0];

                $descendants                        = ProductCategory::descendantsAndSelf($ancestors[0]->id)->pluck('id');
                $return[$ancestors[0]->id]['count'] = ProductPost::approved()
                    ->hasActivePackage()
                    ->whereIn('category_id', $descendants)
                    ->count();

            }

            if ($request) {
                $c = ProductCategory::ancestorsAndSelf($request);

                if (isset($c[0])) {
                    if ($c[0]->id == $ancestors[0]->id) {
                        if (!isset($return[$ancestors[0]->id]['children'][$ancestors[1]->id])) {
                            $return[$ancestors[0]->id]['children'][$ancestors[1]->id]['category'] = $ancestors[1];

                            $descendants                                                       = ProductCategory::descendantsAndSelf($ancestors[1]->id)->pluck('id');
                            $return[$ancestors[0]->id]['children'][$ancestors[1]->id]['count'] = ProductPost::approved()
                                ->hasActivePackage()
                                ->whereIn('category_id', $descendants)
                                ->count();
                        }
                    }
                }

                if (isset($c[1])) {
                    if ($c[1]->id == $ancestors[1]->id) {
                        if (!isset($return[$ancestors[0]->id]['children'][$ancestors[1]->id]['children'][$ancestors[2]->id])) {
                            $return[$ancestors[0]->id]['children'][$ancestors[1]->id]['children'][$ancestors[2]->id]['category'] = $ancestors[2];

                            $descendants                                                                                      = ProductCategory::descendantsAndSelf($ancestors[2]->id)->pluck('id');
                            $return[$ancestors[0]->id]['children'][$ancestors[1]->id]['children'][$ancestors[2]->id]['count'] = ProductPost::approved()
                                ->hasActivePackage()
                                ->whereIn('category_id', $descendants)
                                ->count();
                        }
                    }
                }
            }
        }

        $data['categories'] = $return;
        $data['selected']   = $this->config['category'];
        $data['route']      = $this->config['route'];

        return view('product.post.public.widgets.categories_user', $data);
    }
};
