@extends('_layouts.auth')
@section('title', __('general.login'))

@section('content')
<div class="row justify-content-center px-5">
    <div class="col-sm-8 col-md-6 col-lg-4">
        <div class="block block-bordered">
            <div class="block-content block-content-full">

                @if(request()->input('type') == 'verify')
                <div class="alert alert-info" role="alert">{{ __('auth.check_email_verification') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

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

                    <div class="border-t text-center mt-20 pt-20">
                        <button type="submit" class="btn btn-primary btn-block mb-10">
                            {{ __('general.login') }}
                        </button>

                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('general.forgot_password') }}
                        </a>

                        <a class="btn btn-link" href="{{ route('register') }}">
                            {{ __('general.register_here') }}
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
