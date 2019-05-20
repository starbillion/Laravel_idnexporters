@extends('_layouts.frontend')
@section('title', __('general.packages'))

@section('content')
<div class="content mt-50 mb-50">

    <div class="text-center mb-50">
        <h1 class="h2 font-w700 js-appear-enabled animated fadeInDown" data-toggle="appear" data-class="animated fadeInDown">
            {{ __('general.pricing') }}
        </h1>
    </div>

    @if($requested)
    <div class="alert alert-info text-center" role="alert">
        {{ __('package.notification_store_success') }}<br>
        {!! __('package.notification_cancel') !!}
    </div>
    @endif

    <div class="row justify-content-md-center d-flex align-items-stretch gutters-tiny">
        @foreach($plans as $plan)
        <div class="col-md-3">
            <div class="block block-link-pop block-rounded block-bordered text-center h-100 d-flex flex-column align-items-end flex-column">
                <div class="block-content">
                    <div class="h2 font-w300">{{ __('package.' . $type . '.' . $plan->name . '.name') }}</div>
                </div>
                <div class="block-content bg-gray-lighter border-t border-b">
                    <div class="h5 font-w700 mb-10">
                        @if($plan->name != 'regular')
                        <a class="text-danger" href="#" data-toggle="modal" data-target="#package-{{ $plan->id }}">
                            {{ __('package.' . $type . '.' . $plan->name . '.description') }}
                        </a>
                        @else
                            {{ __('package.' . $type . '.' . $plan->name . '.description') }}
                        @endif
                    </div>
                </div>

                <div class="block-content">
                    @foreach(__('package.' . $type . '.' . $plan->name . '.features') as $key => $feature)
                        @if($plan->features->where('code', $key)->first())
                            @if($plan->features->where('code', $key)->first()->value and $plan->features->where('code', $key)->first()->value != 'N')
                            <p class="font-w700">
                                @php
                                $modals = ['company_logo', 'company_banners', 'discounts'];
                                @endphp

                                @if(in_array($key, $modals))
                                <a href="#" data-target="#package-{{ $key }}" data-toggle="modal">
                                    {{ __('package.' . $type . '.' . $plan->name . '.features.' . $key) }}
                                </a>
                                @else
                                {{ __('package.' . $type . '.' . $plan->name . '.features.' . $key) }}
                                @endif
                            </p>
                            @else
                            <p class="text-muted">
                                {{ __('package.' . $type . '.' . $plan->name . '.features.' . $key) }}
                            </p>
                            @endif
                        @else
                        <p class="font-w700">
                            {{ __('package.' . $type . '.' . $plan->name . '.features.' . $key) }}
                        </p>
                        @endif
                    @endforeach
                </div>

                <div class="block-content block-content-full bg-gray-lighter border-t mt-auto">
                    @if(userPackage()->id == $plan->id)
                        <span class="btn btn-hero btn-sm btn-block btn-secondary">{{ __('general.current_account') }}</span>
                    @else
                        @if($requested)
                            @if($requested->plan_id == $plan->id)
                                <button class="btn btn-hero btn-sm btn-block btn-primary" disabled>{{ __('package.requested') }}</button>
                            @else
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#package-process">
                                    <span class="btn btn-hero btn-sm btn-block btn-danger">{{ __('general.apply') }}</span>
                                </a>
                            @endif
                        @else
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#package-{{ $plan->id }}-request">
                            <span class="btn btn-hero btn-sm btn-block btn-danger">{{ __('general.apply') }}</span>
                        </a>
                        @endif
                    @endif
                </div>
            </div>

            <div class="modal fade" id="package-{{ $plan->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="block block-themed block-transparent mb-0">
                            <div class="block-header bg-primary-dark">
                                <h3 class="block-title">{{ __('package.' . $type . '.' . $plan->name . '.modal_title') }}</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                        <i class="si si-close"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="block-content block-content-full">
                                {!! __('package.' . $type . '.' . $plan->name . '.detail') !!}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('general.close') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="modal fade" id="package-company_logo" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">{{ __('package.company_logo') }}</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content block-content-full">
                        <img src="{{ asset('img/packages/logo.jpg') }}" class="img-fluid">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('general.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="package-company_banners" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">{{ __('package.company_logo') }}</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content block-content-full">
                        <img src="{{ asset('img/packages/banners.jpg') }}" class="img-fluid">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('general.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    @widget('SponsoredExhibitions')
    @widget('ChangePackage')
</div>
@endsection
