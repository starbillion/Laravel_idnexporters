@extends('_layouts.backend')
@section('title', __('general.register'))

@section('content')
<nav class="breadcrumb bg-white push">
    <a class="breadcrumb-item" href="{{ route('admin.user.index') }}">{{ __('general.users') }}</a>
    <span class="breadcrumb-item active text-muted">{{ __('general.add') }}</span>
</nav>

<div class="block block-bordered" id="block-wrapper">
    <form method="post" action="{{ route('admin.user.store') }}">
        {{ csrf_field() }}
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="control-label">Name</label>
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                        <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                        <label for="field-email">{{ __('user.email') }}</label>
                        <input type="text" class="form-control" id="field-email" name="email" value="{{ old('email') }}">
                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('password') ? ' is-invalid' : '' }}">
                        <label for="field-password">{{ __('user.password') }}</label>
                        <input type="password" class="form-control" id="field-password" name="password">
                        <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}">
                        <label for="field-password_confirmation">{{ __('user.password_confirmation') }}</label>
                        <input type="password" class="form-control" id="field-password_confirmation" name="password_confirmation">
                        <div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group{{ $errors->has('as') ? ' is-invalid' : '' }}">
                        <label for="as-confirm" class="control-label">{{ __('auth.register_as') }}</label>
                        <div class="">
                            <label class="css-control css-control-primary css-radio">
                                <input type="radio" class="css-control-input" name="as" value="seller" {{ old('as') == 'seller' ? 'checked' : '' }}>
                                <span class="css-control-indicator"></span> {{ __('auth.seller_account') }}
                            </label>
                        </div>
                        <div class="">
                            <label class="css-control css-control-primary css-radio">
                                <input type="radio" class="css-control-input" name="as" value="buyer" {{ old('as') == 'buyer' ? 'checked' : '' }}>
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
            </div>
        </div>

        <div class="block-content block-content-full bg-gray-lighter">
            <div class="row">
                <div class="col-auto mr-auto">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">{{ __('general.register') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
