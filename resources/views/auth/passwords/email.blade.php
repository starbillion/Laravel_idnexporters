@extends('_layouts.auth')
@section('title', __('general.reset_password'))

@section('content')
<div class="row justify-content-center px-5">
    <div class="col-sm-8 col-md-6 col-lg-4">
        <div class="block block-bordered">
            <div class="block-content block-content-full">

                @if (session('status'))
                <div class="alert alert-success">
                    <p>{{ session('status') }}</p>
                </div>
                @endif

                <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                        <label for="email" class="control-label">{{ __('general.email') }}</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                        @if ($errors->has('email'))
                        <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div class="border-t text-center mt-20 pt-20">
                        <button type="submit" class="btn btn-primary btn-block mb-10">
                            {{ __('general.send_password_link') }}
                        </button>

                        <a class="btn btn-link" href="{{ route('login') }}">
                            {{ __('general.login') }}
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
