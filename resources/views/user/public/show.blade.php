@extends('_layouts.frontend')
@section('title', $user->company ? $user->company : __('general.seller'))

@section('content')
<div class="content content-full mb-20">
    <div class="row">
        <div class="col-md-3">
            @if($user->getFirstMediaUrl('logo'))
            <img id="company_logo" class="img-fluid mb-20" src="{{ asset($user->getFirstMediaUrl('logo', 'full')) }}" alt="">
            @else
            <img id="company_logo" class="img-fluid mb-20" src="{{ asset('img/noimage.png') }}" alt="">
            @endif

            <div class="h3 font-w300">{{ $user->company ? $user->company : __('general.seller') }}</div>
            @if($user->address)
            <p>{!! nl2br(e($user->address)) !!}</p>
            @endif

            @if(Auth::check())
            @role('seller|buyer')
            @if($user->id != Auth::id())
            <a href="#" data-toggle="modal" data-target="#modal-message-{{ $user->id }}" class="btn btn-danger btn-block mb-20">{{ __('message.contact_seller') }}</a>

            <div class="modal fade text-left" id="modal-message-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-message-{{ $user->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <form action="{{ $exists ? route('member.message.update', $exists->id) : route('member.message.store') }}" method="post">
                            {{ csrf_field() }}

                            @if($exists)
                            {{ method_field('put') }}
                            @endif

                            <input type="hidden" name="recipient" value="{{ $user->id }}">

                            <div class="block block-themed block-transparent mb-0">
                                <div class="block-header bg-pulse text-white">
                                    <h3 class="block-title">{{ __('message.contact_seller') }}</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                            <i class="si si-close"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="block-content bg-gray-lighter border-b block-content-full clearfix">
                                    <div class="">
                                        @if(isset($user))
                                        <div class="font-w600">{{ $user->company }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="block-content block-content-full">
                                    <textarea name="body" class="form-control" rows="8" placeholder="{{ __('message.body_placeholder') }}" required>{{ old('body') }}</textarea>
                                </div>
                                <div class="block-content bg-gray-lighter border-t block-content-full text-right">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('general.close') }}</button>
                                    <button type="submit" class="btn btn-danger">{{ __('message.send') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            @endrole
            @else
            <a href="#" data-toggle="modal" data-target="#modal-login" class="btn btn-danger btn-block mb-20">{{ __('message.login_to_contact_seller') }}</a>
            @endif

            <div class="block block-bordered">
                <div class="block-content">
                    @if($user->factory_address)
                    <div class="mb-10">
                        <div class="font-w700">{{ __('user.factory_address') }}</div>
                        <p>{!! nl2br(e($user->factory_address)) !!}</p>
                    </div>
                    @endif

                    @if($user->established)
                    <div class="mb-10">
                        <div class="font-w700">{{ __('user.established') }}</div>
                        <p>{{ $user->established }}</p>
                    </div>
                    @endif

                    @if($user->annual_revenue)
                    <div class="mb-10">
                        <div class="font-w700">{{ __('user.annual_revenue') }}</div>
                        <p>{{ $user->annual_revenue }}</p>
                    </div>
                    @endif

                    @if($user->main_exports)
                    <div class="mb-10">
                        <div class="font-w700">{{ __('user.main_exports') }}</div>
                        <p>{{ $user->main_exports }}</p>
                    </div>
                    @endif

                    @if($user->export_destinations)
                    <div class="mb-10">
                        <div class="font-w700">{{ __('user.xport_destinations') }}</div>
                        <p>{{ $user->xport_destinations }}</p>
                    </div>
                    @endif

                    @if($user->certifications)
                    <div class="mb-10">
                        <div class="font-w700">{{ __('user.certifications') }}</div>
                        <p>{!! nl2br(e($user->certifications)) !!}</p>
                    </div>
                    @endif

                    @if($user->languages)
                    <div class="mb-10">
                        <div class="font-w700">{{ __('user.languages') }}</div>
                        <p>
                            @php
                            $languages = \App\Language::whereIn('id', $user->languages)->pluck('name')->toArray();

                            array_walk($languages, function (&$value) {
                                $value = trim($value);
                            });

                            echo implode(', ', $languages);
                            @endphp
                        </p>
                    </div>
                    @endif

                    @if(!$user->hide_contact)
                    @if($user->company_email)
                    <div class="mb-10">
                        <div class="font-w700">{{ __('user.email') }}</div>
                        <p>{!! nl2br(e($user->company_email)) !!}</p>
                    </div>
                    @endif
                    @if($user->phone_1 or $user->phone_2)
                    <div class="mb-10">
                        <div class="font-w700">{{ __('user.phone') }}</div>
                        <p>
                            {!! nl2br(e($user->phone_1)) !!}
                            {!! '<br>' . nl2br(e($user->phone_2)) !!}
                        </p>
                    </div>
                    @endif
                    @if($user->fax)
                    <div class="mb-10">
                        <div class="font-w700">{{ __('user.fax') }}</div>
                        <p>{!! nl2br(e($user->fax)) !!}</p>
                    </div>
                    @endif
                    @if($user->website)
                    <div class="mb-10">
                        <div class="font-w700">{{ __('user.website') }}</div>
                        <p><a href="{!! nl2br(e($user->website)) !!}" target="_blank">{!! nl2br(e($user->website)) !!}</a></p>
                    </div>
                    @endif
                    @endif
                </div>
            </div>

            @if($user->address)
            <div class="block block-bordered  mb-20">
            <div class="embed-responsive embed-responsive-16by9">
                <iframe width="600" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key={{ config('services.google_map.key') }}&q={{ trim(preg_replace('/\s+/', ' ', $user->address)) }}">
                </iframe>
            </div>
            </div>
            @endif

            <img src="{{ getQrCode($user->id) }}" class="img-thumbnail mb-20">

            @widget('ShareThis')

            @widget('App\Widgets\Product\UserCategories', ['user' => $user->id, 'category' => request()->input('category')])
        </div>

        <div class="col-md-9">

            @if($medias = $user->getMedia('banner'))
            @if(count($medias) > 0)
            <div class="js-slider slick-nav-white slick-nav-hover mb-30"  data-arrows="true">
                @foreach($medias as $media)
                    <div>
                        <img class="img-fluid" src="{{ $media->getUrl() }}">
                    </div>
                @endforeach
            </div>
            @endif
            @endif

            <div class="block block-bordered">
                <div class="block-header block-header-default">
                 <h3 class="block-title">{{ isset($category) ? $category->name : __('product/category.all') }}</h3>
                    <div class="block-options">
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                                @if(request()->input('sort') == 'popularity')
                                <i class="si si-graph"></i>&nbsp; {{ __('product/post.popularity') }}
                                @else
                                <i class="si si-clock"></i>&nbsp; {{ __('product/post.latest') }}
                                @endif
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="{{ (request()->input('sort') == 'latest' or request()->input('sort') == '') ? 'active' : '' }} dropdown-item"
                                    href="{{ route('public.user.show', array_merge(['id' => $user->id], request()->query(), ['sort' => 'latest', 'page' => null])) }}">
                                    <i class="si si-clock"></i>&nbsp; {{ __('product/post.latest') }}
                                </a>
                                <a class="{{ request()->input('sort') == 'popularity' ? 'active' : '' }} dropdown-item" href="{{ route('public.user.show', array_merge(['id' => $user->id], request()->query(), ['sort' => 'popularity', 'page' => null])) }}">
                                    <i class="si si-graph"></i>&nbsp; {{ __('product/post.popularity') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(count($products) > 0)
            <div>
                <div class="row">
                   @foreach($products as $product)
                    <div class="col-6 col-sm-4 col-md-4 col-xl-3">
                        <a href="{{ route('public.product.show', $product->id) }}" class="block block-link-pop">
                            <div class="block block-bordered bg-white mb-20">
                                <div class="card text-center">
                                    @if($product->getFirstMediaUrl('product'))
                                        <img class="card-img-top img-fluid" src="{{ $product->getFirstMediaUrl('product', 'thumb') }}">
                                    @else
                                        <img class="img-fluid" src="{{ asset('img/noimage.png') }}">
                                    @endif

                                    <div class="card-body text-left p-10">
                                        <h6 class="mb-10 text-truncate">{{ $product->name }}</h6>
                                        <span class="badge badge-secondary text-truncate" style="max-width: 100%;">{{ $product->category->name }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

                @if ($products->hasPages())
                <div class="block block-bordered">
                    <div class="block-content">
                        {!! $products->appends(request()->query())->render() !!}
                    </div>
                </div>
                @endif
            </div>
            @else
            <div class="alert alert-info" role="alert">
                {{ __('product/post.user_has_no_products') }}
            </div>
            @endif
        </div>
    </div>

    <p class="mt-20 text-center border-t pt-10">
        <small class="text-muted">
            <strong>{{ __('general.disclaimer') }} :</strong>
            {{ __('general.disclaimer_note') }}
        </small>
    </p>
</div>
@endsection

@push('script')
<script src="{{ asset('plugins/slick/slick.min.js') }}"></script>
<script>
    $(function () {
        Codebase.helpers('slick');
    });
</script>
@endpush

@push('style')
<link rel="stylesheet" href="{{ asset('plugins/slick/slick.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/slick/slick-theme.min.css') }}">
@endpush
