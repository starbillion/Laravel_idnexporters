<?php

namespace App\Http\Controllers\Exhibition;

use App\Country;
use App\Continent;
use App\Exhibition;
use App\ProductCategory;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class PublicController extends Controller
{
    /**
     * Show the specified resource.
     * @return Response
     */
    public function index()
    {
        $this->data['posts'] = Exhibition::where('featured', true)
            ->orderBy('start_at', 'asc')
            ->paginate(config('app.pagination'));

        return view('exhibition.public.index', $this->data);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($slug)
    {
        $this->data['post'] = Exhibition::whereSlug($slug)->first() or abort(404);

        return view('exhibition.public.show', $this->data);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function catalogue_index()
    {
        $posts = Exhibition::where('directory', true)->withCount('exhibitors')->orderBy('start_at', 'asc');

        if ($continent = request()->input('continent')) {
            $continent = Continent::where('code', strtoupper($continent))->first();

            if (!$continent) {
                return redirect()->route('public.exhibition.catalogue.index');
            }

            $this->data['continent'] = $continent;

            $posts->whereHas('country.continent', function ($q) use ($continent) {
                $q->where('id', $continent->id);
            });
        }

        $this->data['continents'] = Continent::get();
        $this->data['posts']      = $posts->paginate(config('app.pagination'));

        return view('exhibition.public.catalogue.index', $this->data);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function catalogue_show($slug)
    {
        $this->data['post']       = Exhibition::where('directory', true)->withCount('exhibitors')->whereSlug($slug)->first() or abort(404);
        $this->data['continents'] = Continent::get();

        return view('exhibition.public.catalogue.show', $this->data);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function catalogue_exhibitors($slug)
    {
        $this->data['post']       = Exhibition::where('directory', true)->withCount('exhibitors')->whereSlug($slug)->first() or abort(404);
        $this->data['continents'] = Continent::get();
        $this->data['countries']  = Country::orderBy('name')->get();
        $this->data['categories'] = ProductCategory::whereIsRoot()->get();
        $exhibitors               = $this->data['post']->exhibitors()->withPivot('booth');

        if ($identity = request()->input('identity')) {
            if ($identity == 'number') {
                $exhibitors->whereRaw('name REGEXP \'^[^A-Za-z]\'');
            } else {
                $exhibitors->where('name', 'like', $identity . '%');
            }
        }

        if ($country = request()->input('country')) {
            $exhibitors->whereHas('country', function ($q) use ($country) {
                $q->where('id', $country);
            });
        }

        if ($category = request()->input('category')) {
            $exhibitors->where(function ($query) use ($category) {
                $query->whereRaw(
                    'JSON_CONTAINS(categories, \'["' . $category . '"]\')'
                );

                return $query;
            });
        }

        if ($search = request()->input('q')) {
            $exhibitors->wherePivot('booth', 'like', '%' . $search . '%');
        }

        $this->data['exhibitors'] = $exhibitors->orderBy('name', 'asc')->paginate(config('app.pagination'));

        return view('exhibition.public.catalogue.exhibitors', $this->data);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function calendar_index()
    {
        $posts = Exhibition::where('calendar', true)
            ->where('start_at', '!=', null)->orderBy('start_at', 'asc');
        $this->data['posts'] = $posts->get();

        return view('exhibition.public.calendar.index', $this->data);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function calendar_show($slug)
    {
        $this->data['post'] = Exhibition::whereSlug($slug)->first() or abort(404);

        return view('exhibition.public.calendar.show', $this->data);
    }
}
