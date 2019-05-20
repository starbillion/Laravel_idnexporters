@extends('_layouts.backend')
@section('title', __('general.dashboard'))

@section('content')
@if(Auth::user()->isPending())
<div class="alert alert-info" role="alert">
    {{ Auth::user()->hasRole('seller') ? __('general.account_reviewed_seller') : __('general.account_reviewed_buyer') }}
</div>
@endif

@widget('RenewPackage')

<div class="block block-bordered" id="welcome">
    <div class="block-content text-right">
        <button type="button" class="btn-block-option" onclick="Codebase.blocks('#welcome', 'close');"><i class="si si-close"></i></button>
    </div>
    <div class="block-content block-content-full" id="dscover">
        <div class="row p-30">
            <div class="col-sm-12 text-center">
                <h2>Discover IDNexporters.com</h2>
            </div>

            @role('seller')
            <div class="dsco col-sm-3 text-center mb-20">
                <div class="rnd">
                    <img src="http://foxel.id/web/icons/002-organize.svg" class="img-responsive center-block">
                </div>
                <h3>Organize</h3>
                <p>Upload your products and complete the information so international buyers can see.</p>
                <a class="btn btn-default" href="{{ route('public.product.index') }}" role="button">Browse Products</a>
            </div>

            <div class="dsco col-sm-3 text-center mb-20">
                <div class="rnd">
                    <img src="http://foxel.id/web/icons/002-online-shop.svg" class="img-responsive center-block">
                </div>
                <h3>Search</h3>
                <p>If you are looking for a specific export, click search on the top.</p>
                <a class="btn btn-default" href="javascript:;" role="button" data-toggle="layout" data-action="header_search_on">Search Products</a>
            </div>

            <div class="dsco col-sm-3 text-center mb-20">
                <div class="rnd" style="padding: 50px;">
                    <img src="http://foxel.id/web/icons/003-customer-service.svg" class="img-responsive center-block">
                </div>
                <h3>Engage</h3>
                <p>Communicate and engage with prospective international buyers.</p>
                <a class="btn btn-default" href="{{ route('public.user.buyer.index') }}" role="button">Search Buyers</a>
            </div>

            <div class="dsco col-sm-3 text-center mb-20">
                <div class="rnd" style="padding: 50px;">
                    <img src="http://foxel.id/web/icons/001-stats.svg" class="img-responsive center-block">
                </div>
                <h3>Measure</h3>
                <p>Measure the performance of your products by heading over to the analytics page.</p>
                <a class="btn btn-default" href="{{ Auth::user()->subscription('main')->ability()->canUse('traffic') ? route('member.traffic.index') : '#' }}" {{ Auth::user()->subscription('main')->ability()->canUse('traffic') ? '' : 'data-toggle=modal data-target=#upgrade_required' }}>Products Analytics</a>
            </div>

            @endrole

            @role('buyer')
            <div class="dsco col-sm-4 text-center mb-20">
                <div class="rnd">
                    <img src="http://foxel.id/web/icons/004-online-shop-2.svg" class="img-responsive center-block">
                </div>
                <h3>Browse</h3>
                <p>Go to the products page and start browsing exports from Indonesia.</p>
                <a class="btn btn-default" href="{{ route('public.product.index') }}" role="button">Browse Products</a>
            </div>

            <div class="dsco col-sm-4 text-center mb-20">
                <div class="rnd">
                    <img src="http://foxel.id/web/icons/002-online-shop.svg" class="img-responsive center-block">
                </div>
                <h3>Search</h3>
                <p>If you are looking for a specific export, click search on the top.</p>
                <a class="btn btn-default" href="javascript:;" role="button" data-toggle="layout" data-action="header_search_on">Search IDN</a>
            </div>

            <div class="dsco col-sm-4 text-center mb-20">
                <div class="rnd" style="padding: 50px;">
                    <img src="http://foxel.id/web/icons/003-customer-service.svg" class="img-responsive center-block">
                </div>
                <h3>Engage</h3>
                <p>Communicate and engage with prospective sellers from Indonesia.</p>
                <a class="btn btn-default" href="{{ route('public.user.seller.index') }}" role="button">Learn More</a>
            </div>
            @endrole

        </div>
    </div>
</div>

@push('style')
<style type="text/css">
    .border-rnd{
        border: 3px dashed #cecece;
    }

    #dscover .row .dsco .rnd {
        transition: all 0.1s ease 0s;
    }
    #dscover .row .dsco:hover .rnd {
        transform: scale(1.05);
    }
    #dscover .row h2 {
        margin-bottom: 30px;
    }
    #dscover .row h3 {
        margin-top: 30px;
    }
    #dscover .row .rnd {
        border-radius: 50%;
        overflow: hidden;
        border: 3px dashed #cecece;
        padding: 40px;
    }

    @role('buyer')
    #dscover .row p {
        min-height: 70px;
    }
    @endrole

    @role('seller')
    #dscover .row p {
        min-height: 120px;
    }
    @endrole
</style>
@endpush

<div class="block block-bordered block-link-shadow">
    <div class="block-content block-content-full clearfix">
        <div class="float-right">
            @if(Auth::user()->getFirstMediaUrl('logo'))
            <img class="img-avatar" src="{{ asset(Auth::user()->getFirstMediaUrl('logo', 'thumb')) }}" alt="">
            @else
            <img class="img-avatar" src="{{ asset('img/noimage.png') }}" alt="">
            @endif
        </div>
        <div class="float-left mt-10">
            <div class="font-w600 mb-5">{{ Auth::user()->company }}</div>

            <div class="font-size-sm text-muted">
                <i class="si si-badge"></i>&nbsp;
                {{ __('package.' . userPackage()->type . '.' . userPackage()->name . '.name') }}
            </div>

            @role('seller')
            @if(Auth::user()->subscriptions()->where('canceled_at', null)->first()->plan->name == 'option_2')
            <div class="font-size-sm text-muted">
                <i class="si si-wallet"></i>&nbsp; Rp {{ number_format(Auth::user()->balance) }}
            </div>
            @endif
            @endrole
        </div>
    </div>
</div>

<div class="row gutters-tiny">
    <div class="col-6 col-md-3">
        <a class="block block-link-shadow block-bordered text-center" href="{{ route('member.profile.general') }}">
            <div class="block-content">
                <p class="mt-5">
                    <i class="si si-user fa-4x"></i>
                </p>
                <p class="font-w600 text-truncate">{{ __('general.my_profile') }}</p>
            </div>
        </a>
    </div>
    @role('seller')
    <div class="col-6 col-md-3">
        <a class="block block-link-shadow block-bordered text-center" href="{{ route('member.product.post.index') }}">
            <div class="block-content">
                <p class="mt-5">
                    <i class="si si-layers fa-4x text-success"></i>
                </p>
                <p class="font-w600 text-truncate">{{ __('general.my_products') }}</p>
            </div>
        </a>
    </div>
    @endrole
    <div class="col-6 col-md-3">
        <a class="block block-link-shadow block-bordered text-center" href="{{ route('member.message.index') }}">
            <div class="block-content">
                <p class="mt-5">
                    <i class="si si-envelope-letter fa-4x text-danger"></i>
                </p>
                <p class="font-w600 text-truncate">{{ __('general.messages') }}</p>
            </div>
        </a>
    </div>
    @role('seller')
    <div class="col-6 col-md-3">
        <a class="block block-link-shadow block-bordered text-center" href="#" data-toggle="modal" data-target="#sponsored_exhibitions">
            <div class="block-content">
                <p class="mt-5">
                    <i class="si si-event fa-4x text-corporate"></i>
                </p>
                <p class="font-w600 text-truncate">{{ __('general.sponsored_exhibitions') }}</p>
            </div>
        </a>
    </div>
    @endrole
    @role('seller')
    <div class="col-6 col-md-3">
        <a class="block block-link-shadow block-bordered text-center" href="{{ Auth::user()->subscription('main')->ability()->canUse('exhibition_directories') ? route('public.exhibition.catalogue.index') : '#' }}" {{ Auth::user()->subscription('main')->ability()->canUse('exhibition_directories') ? '' : 'data-toggle=modal data-target=#upgrade_required' }}>
            <div class="block-content">
                <p class="mt-5">
                    <i class="si si-organization fa-4x text-pulse"></i>
                </p>
                <p class="font-w600 text-truncate">{{ __('general.exhibitions_directories') }}</p>
            </div>
        </a>
    </div>
    @endrole
    @role('seller')
    <div class="col-6 col-md-3">
        <a class="block block-link-shadow block-bordered text-center" href="{{ Auth::user()->subscription('main')->ability()->canUse('traffic') ? route('member.traffic.index') : '#' }}" {{ Auth::user()->subscription('main')->ability()->canUse('traffic') ? '' : 'data-toggle=modal data-target=#upgrade_required' }}>
            <div class="block-content">
                <p class="mt-5">
                    <i class="si si-graph fa-4x text-elegance"></i>
                </p>
                <p class="font-w600 text-truncate">{{ __('general.traffic') }}</p>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a class="block block-link-shadow block-bordered text-center" href="#" data-toggle="modal" data-target="#feature_development">
            <div class="block-content">
                <p class="mt-5">
                    <i class="si si-plane fa-4x text-flat"></i>
                </p>
                <p class="font-w600 text-truncate">{{ __('general.travel_deal') }}</p>
            </div>
        </a>
    </div>
    @endrole
    <div class="col-6 col-md-3">
        <a class="block block-link-shadow block-bordered block-transparent text-center bg-gd-pulse" href="{{ route('member.package.index') }}">
            <div class="block-content">
                <p class="mt-5">
                    <i class="si si-badge fa-4x text-white"></i>
                </p>
                <p class="font-w600 text-truncate text-white">{{ __('general.upgrade_options') }}</p>
            </div>
        </a>
    </div>

</div>

@widget('SponsoredExhibitions')

<div class="modal fade" id="feature_development" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('general.feature_development') }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ __('general.feature_development_content') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('general.close') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection
