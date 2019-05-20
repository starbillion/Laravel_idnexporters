@extends('_layouts.frontend')

@section('content')
<div class="bg-image bg-black-op-25" style="background-image: url('{{ asset('img/covers/home.jpg') }}');">
    <div class="">
        <div class="content content-full content-top text-center overflow-hidden">
            <h1 class="h2 font-w700 text-white mt-50 mb-30 js-appear-enabled animated fadeInDown" data-toggle="appear" data-class="animated fadeInDown" style="text-shadow: 4px 2px 25px #000;">
                {{ __('general.home_tagline') }}
            </h1>

            @if(Auth::check())
            <a class="btn btn-hero btn-noborder btn-rounded btn-success mr-5 mb-50" href="{{ route('dashboard') }}">
                {{ __('general.dashboard') }}
            </a>
            @else
            <a class="btn btn-hero btn-noborder btn-rounded btn-success mr-5 mb-50" href="#" data-toggle="modal" data-target="#modal-login-buyer">
                {{ __('general.buyer_login') }}
            </a>
            <a class="btn btn-hero btn-noborder btn-rounded btn-primary mr-5 mb-50" href="#" data-toggle="modal" data-target="#modal-login-seller">
                {{ __('general.seller_login') }}
            </a>
            @endif
        </div>
    </div>
</div>

<div class="content content-full pt-50 pb-50">
    <div class="row">
        <div class="col-md-9">
            <div class="pb-20">
                @widget('Product\FeaturedCategory')
            </div>
            <div class="pb-20">
                <h5>{{ __('general.featured_products') }}</h5>
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
                @else
                <div class="alert alert-info" role="alert">{{ __('product/category.no_products') }}</div>
                @endif
            </div>
            <div class="pb-20">
                <h5>{{ __('general.exhibition_featured') }}</h5>
                <div class="row">
                    @foreach($featured_exhibition as $post)
                    <div class="col-md-3">
                        <a class="block block-bordered ribbon" href="{{ route('public.exhibition.show', $post->slug) }}">
                            <div class="bg-gray-light border-b">
                                @if($post->getFirstMediaUrl('featured_image', 'crop'))
                                <img class="img-fluid" src="{{ $post->getFirstMediaUrl('featured_image', 'crop') }}">
                                @else
                                <img class="img-fluid" src="{{ asset('img/noimage-exhibition.png') }}">
                                @endif
                            </div>
                            <div class="block-content block-content-full">
                                <h6 class="mb-0 text-truncate">{{ $post->title }}</h6>
                                <span class="text-muted"><small><i class="si si-calendar"></i>&nbsp; {{ $post->start_at ? $post->start_at->format('d-m-Y') : __('exhibition.date_not_found') }}</small></span>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="pb-20">
                @widget('Endorsements')
            </div>
        </div>

        <div class="col-md-3">
            @widget('Wwtp')

            <div class="block block-bordered mb-20">
                <div class="block-content">
                    <p>
                        IDNexporters.com is designed to bring buyers to Indonesian exporters of goods and services in a wide variety of industry.
                    </p>

                    <h6>Services provided:</h6>
                    <ul>
                        <li>Business matching service</li>
                        <li>Face to face meeting</li>
                        <li>Factories visit</li>
                        <li>Market survey</li>
                    </ul>
                </div>
            </div>

            @widget('ExchangeRate')
            @widget('LatestNews')
        </div>
    </div>
</div>


<div class="bg-image" style="background-image: url('{{ asset('img/covers/photo26.jpg') }}');">
    <div class="bg-black-op-75">
        <div class="content content-full">
            <div class="row text-center py-30">
                <div class="col-sm-6 col-md-3 py-30">
                    <div class="mb-20">
                        <i class="si si-people fa-3x text-primary"></i>
                    </div>
                    <div class="font-size-h1 font-w700 text-white mb-5 count-to" data-toggle="countTo" data-to="{{ $count['sellers'] }}">0</div>
                    <div class="font-w600 text-muted text-uppercase">{{ __('general.sellers') }}</div>
                </div>
                <div class="col-sm-6 col-md-3 py-30">
                    <div class="mb-20">
                        <i class="si si-people fa-3x text-info"></i>
                    </div>
                    <div class="font-size-h1 font-w700 text-white mb-5 count-to" data-toggle="countTo" data-to="{{ $count['buyers'] }}">0</div>
                    <div class="font-w600 text-muted text-uppercase">{{ __('general.buyers') }}</div>
                </div>
                <div class="col-sm-6 col-md-3 py-30">
                    <div class="mb-20">
                        <i class="si si-list fa-3x text-warning"></i>
                    </div>
                    <div class="font-size-h1 font-w700 text-white mb-5 count-to" data-toggle="countTo" data-to="{{ $count['products'] }}">0</div>
                    <div class="font-w600 text-muted text-uppercase">{{ __('general.products') }}</div>
                </div>
                <div class="col-sm-6 col-md-3 py-30">
                    <div class="mb-20">
                        <i class="si si-layers fa-3x text-success"></i>
                    </div>
                    <div class="font-size-h1 font-w700 text-white mb-5 count-to" data-toggle="countTo" data-to="{{ $count['categories'] }}">0</div>
                    <div class="font-w600 text-muted text-uppercase">{{ __('general.categories') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-login-seller" tabindex="-1" role="dialog" aria-labelledby="modal-login" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block mb-0">
                <div class="block-header block-header-default pt-0 pb-0 pl-0">
                    <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tab-login-seller">{{ __('general.login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab-register-seller">{{ __('general.register') }}</a>
                        </li>
                    </ul>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>

                <div class="block-content tab-content p-0">
                    <div class="tab-pane active" id="tab-login" role="tabpanel">
                        <form method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="p-20">
                                <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                                    <label for="email" class="control-label">{{ __('general.email') }}</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' is-invalid' : '' }}">
                                    <label for="password" class="control-label">{{ __('general.password') }}</label>
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">{{ __('general.remember_me') }}</span>
                                    </label>
                                </div>
                            </div>

                            <div class="p-20 bg-gray-lighter border-t">
                                <div class="row">
                                    <div class="col-auto mr-auto">
                                        <a class="btn btn-link pl-0" href="{{ route('password.request') }}">
                                            {{ __('general.forgot_password') }}
                                        </a>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-danger">
                                            {{ __('general.login') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="tab-register-seller" role="tabpanel">
                        <form method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}

                            <div class="p-20">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="control-label">Name</label>
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                                    <label for="email" class="control-label">{{ __('general.email') }}</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' is-invalid' : '' }}">
                                    <label for="password" class="control-label">{{ __('general.password') }}</label>
                                    <input id="password" type="password" class="form-control" name="password" required>
                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm" class="control-label">{{ __('general.password_confirmation') }}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>

                                <div class="form-group{{ $errors->has('as') ? ' is-invalid' : '' }}">
                                    <label for="as-confirm" class="control-label">{{ __('auth.register_as') }}</label>
                                    <div class="">
                                        <label class="css-control css-control-primary css-radio">
                                            <input type="radio" class="css-control-input" name="as" value="seller" checked>
                                            <span class="css-control-indicator"></span> {{ __('auth.seller_account') }}
                                        </label>
                                    </div>
                                    @if ($errors->has('as'))
                                    <span class="invalid-feedback">{{ $errors->first('as') }}</span>
                                    @endif
                                </div>

                                <div class="alert alert-warning border-warning" role="alert">
                                    {{ __('general.register_note') }}
                                </div>

                                <div class="text-muted">
                                    <small>{!! __('auth.agreement') !!}</small>
                                </div>
                            </div>

                            <div class="p-20 bg-gray-lighter border-t">
                                <div class="row">
                                    <div class="col-auto mr-auto">
                                        <a class="btn btn-link pl-0" href="{{ route('login') }}">
                                            {{ __('general.login') }}
                                        </a>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-danger">
                                            {{ __('general.register') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-login-buyer" tabindex="-1" role="dialog" aria-labelledby="modal-login" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block mb-0">
                <div class="block-header block-header-default pt-0 pb-0 pl-0">
                    <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tab-login-buyer">{{ __('general.login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab-register-buyer">{{ __('general.register') }}</a>
                        </li>
                    </ul>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>

                <div class="block-content tab-content p-0">
                    <div class="tab-pane active" id="tab-login-buyer" role="tabpanel">
                        <form method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="p-20">
                                <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                                    <label for="email" class="control-label">{{ __('general.email') }}</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' is-invalid' : '' }}">
                                    <label for="password" class="control-label">{{ __('general.password') }}</label>
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">{{ __('general.remember_me') }}</span>
                                    </label>
                                </div>
                            </div>

                            <div class="p-20 bg-gray-lighter border-t">
                                <div class="row">
                                    <div class="col-auto mr-auto">
                                        <a class="btn btn-link pl-0" href="{{ route('password.request') }}">
                                            {{ __('general.forgot_password') }}
                                        </a>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-danger">
                                            {{ __('general.login') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="tab-register-buyer" role="tabpanel">
                        <form method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}

                            <div class="p-20">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="control-label">Name</label>
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                                    <label for="email" class="control-label">{{ __('general.email') }}</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' is-invalid' : '' }}">
                                    <label for="password" class="control-label">{{ __('general.password') }}</label>
                                    <input id="password" type="password" class="form-control" name="password" required>
                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm" class="control-label">{{ __('general.password_confirmation') }}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>

                                <div class="form-group{{ $errors->has('as') ? ' is-invalid' : '' }}">
                                    <label for="as-confirm" class="control-label">{{ __('auth.register_as') }}</label>
                                    <div class="">
                                        <label class="css-control css-control-primary css-radio">
                                            <input type="radio" class="css-control-input" name="as" value="buyer" checked>
                                            <span class="css-control-indicator"></span> {{ __('auth.buyer_account') }}
                                        </label>
                                    </div>
                                    @if ($errors->has('as'))
                                    <span class="invalid-feedback">{{ $errors->first('as') }}</span>
                                    @endif
                                </div>
                                <div class="text-muted">
                                    <small>{!! __('auth.agreement') !!}</small>
                                </div>
                            </div>

                            <div class="p-20 bg-gray-lighter border-t">
                                <div class="row">
                                    <div class="col-auto mr-auto">
                                        <a class="btn btn-link pl-0" href="{{ route('login') }}">
                                            {{ __('general.login') }}
                                        </a>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-danger">
                                            {{ __('general.register') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script type="text/javascript">
    $(function(){
        $('.count-to').countTo({
            formatter: function (value, options) {
                value = value.toFixed(options.decimals);
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                return value;
            },
        });
    })
</script>
@endpush
