@extends('_layouts.auth')

@section('title', __('general.register'))

@section('content')
<div class="row justify-content-center px-5">
    <div class="col-sm-8 col-md-6 col-lg-4">
        <div class="block block-bordered">
            <div class="block-content block-content-full">

                <form method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

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

                    <div class="border-t text-center mt-20 pt-20">
                        <button type="submit" class="btn btn-primary btn-block mb-10">
                            {{ __('general.register') }}
                        </button>

                        <a class="btn btn-link" href="{{ route('login') }}">
                            {{ __('general.login') }}
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
