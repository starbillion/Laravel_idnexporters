@extends('_layouts.frontend')
@section('title', isset($category) ? $category->name : __('product/category.all'))

@section('content')
<div class="content content-full pt-50 pb-50">
    <div class="row">
        <div class="col-md-3">
            @widget('App\Widgets\Product\Categories', ['category' => request()->input('category')])
        </div>

        <div class="col-md-9">
            <div class="block block-bordered">
                <div class="block-header block-header-default">
                 <h3 class="block-title">{{ isset($category) ? $category->name : __('product/category.all') }}</h3>
                    <div class="block-options">
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                                @if(request()->input('category'))
                                    @if(request()->input('sort') == 'featured')
                                    <i class="si si-star"></i>&nbsp; {{ __('product/post.featured') }}
                                    @elseif(request()->input('sort') == 'popularity')
                                    <i class="si si-graph"></i>&nbsp; {{ __('product/post.popularity') }}
                                    @else
                                    <i class="si si-clock"></i>&nbsp; {{ __('product/post.latest') }}
                                    @endif
                                @else
                                    @if(request()->input('sort') == 'popularity')
                                    <i class="si si-graph"></i>&nbsp; {{ __('product/post.popularity') }}
                                    @else
                                    <i class="si si-clock"></i>&nbsp; {{ __('product/post.latest') }}
                                    @endif
                                @endif
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="{{ (request()->input('sort') == 'latest' or request()->input('sort') == '') ? 'active' : '' }} dropdown-item" href="{{ route('public.product.index', array_merge(request()->query(), ['sort' => 'latest', 'page' => null])) }}">
                                    <i class="si si-clock"></i>&nbsp; {{ __('product/post.latest') }}
                                </a>

                                @if(request()->input('category'))
                                <a class="{{ request()->input('sort') == 'featured' ? 'active' : '' }} dropdown-item" href="{{ route('public.product.index', array_merge(request()->query(), ['sort' => 'featured', 'page' => null])) }}">
                                    <i class="si si-star"></i>&nbsp; {{ __('product/post.featured') }}
                                </a>
                                @endif

                                <a class="{{ request()->input('sort') == 'popularity' ? 'active' : '' }} dropdown-item" href="{{ route('public.product.index', array_merge(request()->query(), ['sort' => 'popularity', 'page' => null])) }}">
                                    <i class="si si-graph"></i>&nbsp; {{ __('product/post.popularity') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                @if(count($products) > 0)
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

                    @if($products->hasPages())
                    <div class="block block-bordered">
                        <div class="block-content">
                            {!! $products->appends(request()->query())->render() !!}
                        </div>
                    </div>
                    @endif
                @else
                <div class="alert alert-info" role="alert">{{ __('product/category.no_products') }}</div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
