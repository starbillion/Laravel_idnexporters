<?php

use App\User;
use App\Country;
use Carbon\Carbon;
use App\ProductCategory;
use App\ProductPost as Product;
use Illuminate\Database\Seeder;
use App\ProductCategory as Category;
use Gerardojbaez\LaraPlans\Models\Plan;

class OldSeederBu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $auth = User::withAnyStatus()->find(1);
        Auth::login($auth);

        $data = [];
        $old  = DB::connection('old')
            ->table('member')
            ->get();

        foreach ($old as $old) {
            $old  = (array) $old;
            $user = new User;
            $data = [
                'id'                  => $old['id'],
                'email'               => $this->email($old['email']),
                'password'            => $this->password($old['password']),
                'salutation'          => $this->salutation($old['salutation']),
                'name'                => $this->name($old['fname'], $old['lname']),
                'subscribe'           => $this->subscribe($old['newsletter']),
                'company'             => $this->company($old['company_name']),
                'business_types'      => $this->business_types($old['business']),
                'established'         => $this->established($old['established']),
                'city'                => $this->city($old['city']),
                'postal'              => $this->postal($old['postal']),
                'country_id'          => $this->country_id($old['country']),
                'mobile'              => $this->mobile($old['mobile']),
                'phone_1'             => $this->phone_1($old['phone1']),
                'phone_2'             => $this->phone_2($old['phone2']),
                'fax'                 => $this->fax($old['fax']),
                'company_email'       => $this->company_email($old['company_email']),
                'website'             => $this->website($old['website']),
                'address'             => $this->address($old['address']),
                'description'         => $this->description($old['company_description']),
                'additional_notes'    => $this->additional_notes($old['notes']),
                'halal'               => $this->halal($old['halal']),
                'main_exports'        => $this->main_exports($old['seller_main_exports']),
                'main_imports'        => $this->main_imports($old['buyer_main_imports']),
                'export_destinations' => $this->export_destinations($old['export_destinations']),
                'current_markets'     => $this->current_markets($old['current_market']),
                'annual_revenue'      => $this->annual_revenue($old['annual_revenue']),
                'product_interests'   => $this->product_interests($old['products_interested']),
                'languages'           => $this->languages($old['language_spoken']),
                'factory_address'     => $this->factory_address($old['factory_address']),
                'certifications'      => $this->certifications($old['certifications']),
                'active'              => $this->active($old['ready']),
                'verified'            => 1,
                'verified_member'     => $this->verified($old['verified']),
                'created_at'          => $this->created_at($old['timestamp']),
                'updated_at'          => $this->updated_at($old['timestamp']),

            ];
            $user->fill($data);

            /****** CATEGORIES ******/
            $categories = DB::connection('old')
                ->table('member_category')
                ->where('member', $old['id'])
                ->get();

            if (count($categories) > 0) {
                $cat_fix = [];
                foreach ($categories as $c) {
                    $get_new_c = ProductCategory::where('old_id', $c->category)->first();

                    if ($get_new_c) {
                        $cat_fix[] = (string) $get_new_c->id;
                    }
                }

                $user->categories = $cat_fix;
            }

            $user->save();

            if ($old['type'] == 0) {
                $user->attachRole('buyer');

                if ($old['approved'] == 1) {
                    $user->markApproved();
                }

            } else {
                $user->attachRole('seller');

                if ($old['approved'] == 1) {
                    $user->markApproved();
                }

                if ($old['membership'] == 1) {
                    $plan = Plan::where('name', 'option_1')->first();
                    $user->newSubscription('main', $plan)->create();
                } elseif ($old['membership'] == 2) {
                    $plan = Plan::where('name', 'option_2')->first();
                    $user->newSubscription('main', $plan)->create();
                } elseif ($old['membership'] == 3) {
                    $plan = Plan::where('name', 'option_3')->first();
                    $user->newSubscription('main', $plan)->create();
                } else {
                    $plan = Plan::where('name', 'regular')->first();
                    $user->newSubscription('main', $plan)->create();
                }

                $this->products($user);

                try {
                    if ($old['company_img']) {
                        $user
                            ->addMediaFromUrl('http://www.idnexporter.com/uploads/' . $old['id'] . '/company_img/' . $old['company_img'])
                            ->usingFileName(md5(time()))
                            ->toMediaCollection('logo');
                    }

                    if ($old['banner_img']) {
                        $user
                            ->addMediaFromUrl('http://www.idnexporter.com/uploads/' . $old['id'] . '/banner/' . $old['banner_img'])
                            ->usingFileName(md5(time()))
                            ->withCustomProperties(['id' => 1])
                            ->toMediaCollection('banner');
                    }
                } catch (Exception $e) {

                }
            }
        }
    }

    public function products($user)
    {
        $data = [];
        $old  = DB::connection('old')
            ->table('product')
            ->where('owner', $user->id)
            ->get();

        foreach ($old as $old) {
            $old                     = (array) $old;
            $product                 = new Product;
            $product->id             = $old['id'];
            $product->user_id        = $user->id;
            $category                = Category::where('old_id', $old['category'])->first();
            $product->category_id    = $category->id;
            $product->name           = $old['name'];
            $product->price          = $old['price'];
            $product->minimum_order  = $old['min_order'];
            $product->supply_ability = $old['supply_ability'];
            $product->fob_port       = $old['fob_port'];
            $product->payment_term   = $old['payment_term'];
            $product->minimum_order  = $old['min_order'];
            $product->description_en = preg_replace("/[\r\n]+/", "\n", strip_tags($old['description']));
            $product->publish        = $old['published'];

            if ($product->save()) {

                try {
                    if ($old['img']) {
                        $user->subscriptionUsage('main')->record('products');

                        if ($old['approved']) {
                            $product->markApproved();
                        }

                        $product
                            ->addMediaFromUrl('http://www.idnexporter.com/products/' . $old['id'] . '/' . $old['img'])
                            ->usingFileName(md5(time()))
                            ->toMediaCollection('product');
                    } else {
                        dd('product no');
                    }
                } catch (Exception $e) {

                }

            }
        }
    }

    /*************************/

    public function email()
    {
        $data   = trim(strtolower(func_get_arg(0)));
        $random = rand(1, 999999999);

        if (filter_var($data, FILTER_VALIDATE_EMAIL)) {
            $user = User::withAnyStatus()->whereEmail($data)->count();

            if ($user == 0) {
                return $data;
            } else {
                return 'duplicate_' . $random . '@needvalidation.com';
            }

        }

        return 'unknown_' . $random . '@needvalidation.com';
    }

    public function password()
    {
        $data = func_get_arg(0);

        return $data ? $data : 'password123456';
    }

    public function salutation()
    {
        $data = strtolower(str_replace('.', '', func_get_arg(0)));

        return $data ? $data : 'mr';
    }

    public function name()
    {
        return trim(ucwords(strtolower(func_get_arg(0) . ' ' . func_get_arg(1))));
    }

    public function subscribe()
    {
        return (bool) func_get_arg(0);
    }

    public function company()
    {
        return trim(ucwords(func_get_arg(0)));
    }

    public function business_types()
    {
        $data   = func_get_arg(0);
        $data   = explode(' ', $data);
        $return = [];
        $in     = ['manufacturer', 'wholesaler', 'distributor', 'retailer'];

        foreach ($data as $value) {
            $value = strtolower(trim($value));

            if (in_array($value, $in)) {
                $return[] = $value;
            }
        }

        return $return;
    }

    public function established()
    {
        return is_numeric(func_get_arg(0)) ? func_get_arg(0) : null;
    }

    public function city()
    {
        return trim(ucwords(func_get_arg(0)));
    }

    public function postal()
    {
        return is_numeric(func_get_arg(0)) ? func_get_arg(0) : null;
    }

    public function country_id()
    {
        if ($cid = func_get_arg(0)) {
            $old = DB::connection('old')
                ->table('country')
                ->find($cid);

            $new = Country::where('name', $old->country_name)->first();

            if ($new) {
                return $new->id;
            }

            return null;

        } else {
            return null;

        }
    }

    public function mobile()
    {
        return trim(strip_tags(func_get_arg(0)));
    }

    public function phone_1()
    {
        return trim(strip_tags(func_get_arg(0)));
    }

    public function phone_2()
    {
        return trim(strip_tags(func_get_arg(0)));
    }

    public function fax()
    {
        return trim(strip_tags(func_get_arg(0)));
    }

    public function company_email()
    {
        if (filter_var(trim(func_get_arg(0)), FILTER_VALIDATE_EMAIL)) {
            return strtolower(func_get_arg(0));
        }
    }

    public function website()
    {
        $website = trim(strtolower(func_get_arg(0)));

        if ($website) {
            if (strpos($website, 'http://') === false) {
                $website = 'http://' . $website;
            }

            if (filter_var($website, FILTER_VALIDATE_URL)) {
                return $website;
            }
        }

    }

    public function address()
    {
        return trim(ucwords(strtolower(strip_tags(func_get_arg(0)))));
    }

    public function description()
    {
        return trim(strip_tags(func_get_arg(0)));
    }

    public function additional_notes()
    {
        return trim(strip_tags(func_get_arg(0)));
    }

    public function halal()
    {
        return (bool) func_get_arg(0);
    }

    public function main_exports()
    {
        return trim(strip_tags(func_get_arg(0)));
    }

    public function main_imports()
    {
        return trim(strip_tags(func_get_arg(0)));
    }

    public function export_destinations()
    {
        return trim(ucwords(func_get_arg(0)));
    }

    public function current_markets()
    {
        return trim(ucwords(func_get_arg(0)));
    }

    public function annual_revenue()
    {
        return trim(ucwords(func_get_arg(0)));
    }

    public function product_interests()
    {
        return trim(ucwords(func_get_arg(0)));
    }

    public function languages()
    {
        return null;
    }

    public function factory_address()
    {
        return trim(ucwords(strtolower(strip_tags(func_get_arg(0)))));
    }

    public function certifications()
    {
        return trim(preg_replace("/[\r\n]+/", "\n", strip_tags(ucwords(func_get_arg(0)))));
    }

    public function active()
    {
        return (bool) func_get_arg(0);
    }

    public function verified()
    {
        return (bool) func_get_arg(0);
    }

    public function created_at()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', func_get_arg(0));
    }

    public function updated_at()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', func_get_arg(0));
    }
}
