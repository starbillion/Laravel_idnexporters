@extends('_layouts.frontend')
@section('title', __('search.title'))

@section('content')
<div class="bg-image bg-black-op-25" style="background-image: url('{{ asset('img/covers/home.jpg') }}');">
    <div class="bg-primary-dark-op">
        <div class="content content-full content-top text-center overflow-hidden">
            <div class="row justify-content-center mb-20">
                <div class="col-md-6">
                    <form method="get" action="{{ route('public.search.index') }}">
                        <div class="input-group input-group-lg">
                            <input type="text" name="q" class="form-control" value="{{ request()->input('q') }}" placeholder="{{ __('general.search') }}...">
                            <input type="hidden" name="type" value="product">
                            <span class="input-group-btn">
                                <button class="btn btn-danger" type="submit">
                                    <i class="si si-magnifier font-w600"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content content-full pt-50 pb-50">
    <div class="row">
        <div class="col-md-9">


            @if(count($products) > 0)
                <h5 class="mb-0">Product Results</h5>
                <h6 class="font-w300">Matching search: <span class="font-w600">{!! e(request()->input('q')) !!}</span></h6>

                <div class="row mb-50">
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
            @endif


            @if(count($sellers) > 0)
                <h5 class="mb-0">Seller Results</h5>
                <h6 class="font-w300">Matching search: <span class="font-w600">{!! e(request()->input('q')) !!}</span></h6>

                <div class="block mb-50">
                    <div class="block-content block-content-full">
                        <table class="table">
                            <?php $i = 0;?>
                            @foreach($sellers as $item)
                            <tr>
                                <td class="text-center {{ $i == 0 ? 'border-0' : '' }}" style="width: 100px;">
                                    <div>
                                        <a href="be_pages_generic_profile.html">
                                            @if($item->getFirstMediaUrl('logo'))
                                            <img id="company_logo" class="img-fluid" src="{{ asset($item->getFirstMediaUrl('logo', 'thumb')) }}" alt="">
                                            @else
                                            <img id="company_logo" class="img-fluid" src="{{ asset('img/noimage.png') }}" alt="">
                                            @endif
                                        </a>
                                    </div>
                                </td>
                                <td class="{{ $i == 0 ? 'border-0' : '' }}">
                                    <a class="clearfix" data-toggle="collapse" href="#detail-{{ $i }}">
                                        {{ $item->company }}&nbsp;

                                        @if($item->verified_member)
                                        <span class="badge badge-primary">{{ __('user.verified') }}</span>
                                        @endif

                                        @if($item->halal)
                                        <img src="{{ asset('img/icons/halal.png') }}" style="width: 28px;"></i>
                                        @endif
                                    </a>

                                    @if($item->main_exports)
                                    <span class="font-size-sm text-muted">
                                        {{ $item->main_exports }}
                                    </span>
                                    @endif

                                    <div id="detail-{{ $i }}" class="collapse my-10">
                                        <div class="row mb-20">
                                            <div class="col">
                                                <h6 class="mb-0">{{ __('user.address') }}</h6>
                                                <div>{{ $item->address ? $item->address : '-' }}</div>
                                            </div>
                                            <div class="col">
                                                <h6 class="mb-0">{{ __('user.location') }}</h6>
                                                <div>{{ $item->city }}, {{ $item->country->name }}</div>
                                            </div>
                                        </div>

                                        @widget('SendMessage', [
                                            'type' => 'seller',
                                            'user' => $item
                                        ])

                                        @if ($item->subscription('main')->ability()->canUse('public_page'))
                                         <a href="{{ route('public.user.show', $item->id) }}" class="btn btn-secondary">{{ __('user.view_seller') }}</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <?php $i++;?>
                            @endforeach
                        </table>
                    </div>
                </div>
            @endif

            @if(count($buyers) > 0)
                <h5 class="mb-0">Buyer Results</h5>
                <h6 class="font-w300">Matching search: <span class="font-w600">{!! e(request()->input('q')) !!}</span></h6>

                <div class="block mb-50">
                    <div class="block-content block-content-full">
                        <table class="table">
                            <?php $i = 0;?>
                            @foreach($buyers as $buyer)
                            <tr>
                                <td class="{{ $i == 0 ? 'border-0' : '' }}">
                                    <a class="clearfix" data-toggle="collapse" href="#detail-buyer-{{ $i }}">
                                        {{ $buyer->company }}
                                    </a>
                                    <span class="font-size-sm text-muted">
                                        {{ __('user.product_interests') }}: {{ $buyer->product_interests }}
                                    </span>

                                    <div id="detail-buyer-{{ $i }}" class="collapse my-10">
                                        <div class="row mb-20">
                                            <div class="col">
                                                <h6 class="mb-0">{{ __('user.address') }}</h6>
                                                <div>{{ $buyer->address ? $buyer->address : '-' }}</div>
                                            </div>
                                            <div class="col">
                                                <h6 class="mb-0">{{ __('user.location') }}</h6>
                                                <div>
                                                    {{ $buyer->city }}
                                                    {{ $buyer->country_id ? ', ' . $buyer->country->name : '' }}
                                                </div>
                                            </div>
                                        </div>

                                        @widget('SendMessage', [
                                            'type' => 'buyer',
                                            'user' => $buyer
                                        ])
                                    </div>
                                </td>
                            </tr>
                            <?php $i++;?>
                            @endforeach
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
