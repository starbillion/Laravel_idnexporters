@extends('_layouts.auth')
@section('title', __('general.reset_password'))

@section('content')
<div class="row justify-content-center px-5">
    <div class="col-sm-8 col-md-6 col-lg-4">
        <div class="block block-bordered">
            <div class="block-content block-content-full">

                <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                    {{ csrf_field() }}

                    <input type="hidden" name="token" value="{{ $token }}">

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
                        <label for="password-confirm" class="control-label">{{ __('general.password_confirmation') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    </div>

                    <div class="border-t text-center mt-20 pt-20">
                        <button type="submit" class="btn btn-primary btn-block mb-10">
                            {{ __('general.reset_password') }}
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
