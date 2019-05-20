@extends('_layouts.frontend')
@section('title', $product->name)

@section('content')
<div class="content content-full pt-50 pb-50">
    <div class="row">
        <div class="col-md-3">
            @widget('App\Widgets\Product\Categories', ['category' => $product->category_id])
            @widget('ExchangeRate')
        </div>

        <div class="col-md-9">
            <div class="block block-bordered mb-20">
                <div class="block-content js-gallery ">
                    <div class="d-flex justify-content-between">
                        <h3 class="text-truncate">{{ $product->name }}</h3>
                        @if($product->price)
                        <h3 class="text-truncate text-primary">
                            @if($product->currency)
                                {{ $product->currency->code }}
                            @endif
                            {{ $product->price }}
                        </h3>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-20">
                            @if($product->getFirstMediaUrl('product'))
                            <a class="img-link img-link-zoom-in img-thumb img-lightbox" href="{{ $product->getFirstMediaUrl('product', 'large') }}">
                                <img class="img-fluid" src="{{ $product->getFirstMediaUrl('product', 'medium') }}">
                            </a>
                            @else
                                <img class="img-fluid" src="{{ asset('img/noimage.png') }}">
                            @endif
                        </div>

                        <div class="col-md-6 mb-20">
                            <dl class="row">
                                <dt class="col-sm-4">{{ __('product/post.seller') }}</dt>
                                <dd class="col-sm-6">
                                    @if ($product->owner->subscription('main')->ability()->canUse('public_page'))
                                    <a href="{{ route('public.user.show', $product->owner->id) }}">{{ $product->owner->company ? $product->owner->company : __('general.seller') }}</a>
                                    @else
                                    {{ $product->owner->company ? $product->owner->company : __('general.seller') }}
                                    @endif
                                </dd>

                                <dt class="col-sm-4">{{ __('product/post.idncode') }}</dt>
                                <dd class="col-sm-6">{{ Hashids::encode($product->id) }}</dd>

                                <dt class="col-sm-4">{{ __('product/post.minimum_order') }}</dt>
                                <dd class="col-sm-6">{{ $product->minimum_order ? $product->minimum_order : '-' }}</dd>

                                <dt class="col-sm-4">{{ __('product/post.supply_ability') }}</dt>
                                <dd class="col-sm-6">{{ $product->supply_ability ? $product->supply_ability : '-' }}</dd>

                                <dt class="col-sm-4">{{ __('product/post.fob_port') }}</dt>
                                <dd class="col-sm-6">{{ $product->fob_port ? $product->fob_port : '-' }}</dd>

                                <dt class="col-sm-4">{{ __('product/post.payment_term') }}</dt>
                                <dd class="col-sm-6">{{ $product->payment_term ? $product->payment_term : '-' }}</dd>

                                <dt class="col-sm-4">{{ __('product/post.created') }}</dt>
                                <dd class="col-sm-6">{{ $product->created_at->format('M d, Y')  }}</dd>
                            </dl>

                            @widget('SendMessage', [
                                'type' => 'buyer',
                                'user' => $product->owner,
                                'product' => $product
                            ])
                        </div>
                    </div>
                </div>
            </div>

            @if($product->description_en != '' or $product->description_id != '' or $product->description_zh != '')
            <div class="block block-bordered mb-20">

                <ul class="nav nav-tabs nav-tabs-block justify-content-end align-items-center" data-toggle="tabs" role="tablist">
                <li class="nav-item mr-auto">
                        <div class="block-options mr-15">
                            <a class="btn-block-option">{{ __('product/post.description') }}</a>
                        </div>
                    </li>
<?php
$active = '';

if ($product->description_zh) {$active = 'zh';}
if ($product->description_id) {$active = 'id';}
if ($product->description_en) {$active = 'en';}

?>

                    @if($product->description_en)
                    <li class="nav-item">
                        <a class="nav-link {{ $active == 'en' ? 'active' : '' }}" href="#description_en">{{ __('general.en') }}</a>
                    </li>
                    @endif

                    @if($product->description_id)
                    <li class="nav-item">
                        <a class="nav-link {{ $active == 'id' ? 'active' : '' }}" href="#description_id">{{ __('general.id') }}</a>
                    </li>
                    @endif

                    @if($product->description_zh)
                    <li class="nav-item">
                        <a class="nav-link {{ $active == 'zh' ? 'active' : '' }}" href="#description_zh">{{ __('general.zh') }}</a>
                    </li>
                    @endif
                </ul>
                <div class="block-content block-content-full tab-content">
                    @if($product->description_en)
                    <div class="tab-pane  {{ $active == 'en' ? 'active' : '' }}" id="description_en" role="tabpanel">
                        {!! $product->description_en !!}
                    </div>
                    @endif

                    @if($product->description_id)
                    <div class="tab-pane  {{ $active == 'id' ? 'active' : '' }}" id="description_id" role="tabpanel">
                        {!! $product->description_id !!}
                    </div>
                    @endif

                    @if($product->description_zh)
                    <div class="tab-pane  {{ $active == 'zh' ? 'active' : '' }}" id="description_zh" role="tabpanel">
                        {!! $product->description_zh !!}
                    </div>
                    @endif
                </div>
            </div>
            @endif

            @if(count($other_products))
            <div>
                <div class="block-header block-header-default">
                    <h3 class="block-title">{{ __('product/post.other_product_from_seller', ['seller' => $product->owner->company ? $product->owner->company : __('general.seller')]) }}</h3>
                </div>

                <div class="row mt-20">
                   @foreach($other_products as $product)
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
<script type="text/javascript" src="{{ asset('plugins/magnific-popup/magnific-popup.min.js') }}"></script>
<script type="text/javascript">
    $(function(){
        Codebase.helper('magnific-popup');
    });
</script>
@endpush

@push('style')
<link rel="stylesheet" href="{{ asset('plugins/magnific-popup/magnific-popup.min.css') }}">
@endpush
