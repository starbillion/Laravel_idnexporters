@extends('_layouts.auth')
@section('title', __('laravel-user-verification::user-verification.verification_error_header'))


@section('content')
<div class="row justify-content-center px-5">
    <div class="col-sm-8 col-md-6 col-lg-4">

        <div class="block block-bordered text-center">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('laravel-user-verification::user-verification.verification_error_header') }}</h3>
            </div>

            <div class="block-content block-content-full">
                <strong class="d-block mb-20">{!! trans('laravel-user-verification::user-verification.verification_error_message') !!}</strong>

                <a class="btn btn-primary" href="{{ route('public.index') }}">{{ __('general.home') }}</a>
            </div>
        </div>

    </div>
</div>
@endsection
