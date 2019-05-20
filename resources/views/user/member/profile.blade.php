@extends('_layouts.backend')
@section('title', Auth::user()->hasRole('seller') ? __('user.profile_tab_seller') : __('user.profile_tab_buyer'))

@section('content')
<div class="block block-bordered" id="block-wrapper">
 @include('user.member._tabs')

@role('seller')
 @if(Auth::user()->subscription('main')->ability()->canUse('company_banners'))
 <div class="block-content block-content-full">
    <div class="row justify-content-md-center">
        <div class="col-md-10 text-center">
            <div class="row justify-content-md-center">
                <div class="col-md-3">
                    <div class="options-container">

                        @if($user->getFirstMediaUrl('logo'))
                        <img id="company_logo" class="img-thumbnail options-item" src="{{ asset($user->getFirstMediaUrl('logo', 'thumb')) }}" alt="">
                        <div class="options-overlay bg-black-op-75">
                            <div class="options-overlay-content p-20">
                                <a class="btn btn-sm btn-block btn-alt-secondary min-width-75" onclick="event.preventDefault(); document.getElementById('upload-logo').click()">
                                    {{ __('user.change_image') }}
                                </a>
                                <a class="btn btn-sm btn-block btn-alt-danger min-width-75" onclick="event.preventDefault(); Codebase.loader('show'); document.getElementById('form-delete').submit();">
                                    {{ __('user.delete_image') }}
                                </a>
                                <form id="form-delete" method="post" action="{{ route('member.profile.media.destroy', $user->getMedia('logo')[0]->id) }}" class="d-none">
                                    {{ csrf_field() }}
                                    <input name="_method" type="hidden" value="DELETE">
                                </form>
                            </div>
                        </div>
                        @else
                        <img id="company_logo" class="img-thumbnail options-item" src="{{ asset('img/noimage.png') }}" alt="">
                        <div class="options-overlay bg-black-op-75">
                            <div class="options-overlay-content p-20">
                                <a class="btn btn-sm btn-block btn-alt-secondary min-width-75" onclick="event.preventDefault(); document.getElementById('upload-logo').click()">
                                    {{ __('user.upload_image') }}
                                </a>
                            </div>
                        </div>
                        @endif

                        <form id="form-upload" method="post" action="{{ route('member.profile.media.store') }}" class="d-none" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="type" value="logo">
                            <input id="upload-logo" type="file" name="logo" onchange="event.preventDefault(); Codebase.loader('show'); document.getElementById('form-upload').submit();" />
                        </form>

                    </div>
                </div>
            </div>
            <span class="text-muted d-block mt-10">{{ __('user.logo_placeholder') }}</span>
        </div>
    </div>
</div>

<hr>
@endif
@endrole

<form method="post" action="{{ route('member.profile.update') }}">
    {{ csrf_field() }}
    <input name="_method" type="hidden" value="PUT">
    <div class="block-content block-content-full">
        <div class="row">

            @role('seller')
            <div class="col-md-12">
                <div class="form-group{{ $errors->has('main_exports') ? ' is-invalid' : '' }}">
                    <div class="form-group{{ $errors->has('main_exports') ? ' is-invalid' : '' }}">
                        <label for="field-main_exports">{{ __('user.main_exports') }}</label>
                        <input type="text" class="form-control" id="field-main_exports" name="main_exports" value="{{ old('main_exports', $user->main_exports) }}">
                        <div class="invalid-feedback">{{ $errors->first('main_exports') }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('export_destinations') ? ' is-invalid' : '' }}">
                    <div class="form-group{{ $errors->has('export_destinations') ? ' is-invalid' : '' }}">
                        <label for="field-export_destinations">{{ __('user.export_destinations') }}</label>
                        <input type="text" class="form-control" id="field-export_destinations" name="export_destinations" value="{{ old('export_destinations', $user->export_destinations) }}">
                        <div class="invalid-feedback">{{ $errors->first('export_destinations') }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('current_markets') ? ' is-invalid' : '' }}">
                    <label for="field-current_markets">{{ __('user.current_markets') }}</label>
                    <input type="text" class="form-control" id="field-current_markets" name="current_markets" value="{{ old('current_markets', $user->current_markets) }}" placeholder="{{ __('user.current_markets_placeholder') }}">
                    <div class="invalid-feedback">{{ $errors->first('current_markets') }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('annual_revenue') ? ' is-invalid' : '' }}">
                    <div class="form-group{{ $errors->has('annual_revenue') ? ' is-invalid' : '' }}">
                        <label for="field-annual_revenue">{{ __('user.annual_revenue') }}</label>
                        <input type="text" class="form-control" id="field-annual_revenue" name="annual_revenue" value="{{ old('annual_revenue', $user->annual_revenue) }}">
                        <div class="invalid-feedback">{{ $errors->first('annual_revenue') }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('product_interests') ? ' is-invalid' : '' }}">
                    <div class="form-group{{ $errors->has('product_interests') ? ' is-invalid' : '' }}">
                        <label for="field-product_interests">{{ __('user.product_interests') }}</label>
                        <input type="text" class="form-control" id="field-product_interests" name="product_interests" value="{{ old('product_interests', $user->product_interests) }}" placeholder="{{ __('user.product_interests_placeholder') }}">
                        <div class="invalid-feedback">{{ $errors->first('product_interests') }}</div>
                    </div>
                </div>
            </div>
            @endrole

            @role('buyer')
            <div class="col-md-12">
                <div class="form-group{{ $errors->has('main_imports') ? ' is-invalid' : '' }}">
                    <div class="form-group{{ $errors->has('main_imports') ? ' is-invalid' : '' }}">
                        <label for="field-main_imports">{{ __('user.main_imports') }}</label>
                        <input type="text" class="form-control" id="field-main_imports" name="main_imports" value="{{ old('main_imports', $user->main_imports) }}">
                        <div class="invalid-feedback">{{ $errors->first('main_imports') }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group{{ $errors->has('product_interests') ? ' is-invalid' : '' }}">
                    <div class="form-group{{ $errors->has('product_interests') ? ' is-invalid' : '' }}">
                        <label for="field-product_interests">{{ __('user.product_interests') }}</label>
                        <input type="text" class="form-control" id="field-product_interests" name="product_interests" value="{{ old('product_interests', $user->product_interests) }}" placeholder="{{ __('user.product_interests_placeholder') }}">
                        <div class="invalid-feedback">{{ $errors->first('product_interests') }}</div>
                    </div>
                </div>
            </div>
            @endrole
        </div>
        @role('seller')
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group{{ $errors->has('factory_address') ? ' is-invalid' : '' }}">
                    <label for="field-factory_address">{{ __('user.factory_address') }}</label>
                    <textarea class="form-control" name="factory_address" rows="6">{{ old('factory_address', $user->factory_address) }}</textarea>
                    <div class="invalid-feedback">{{ $errors->first('factory_address') }}</div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group{{ $errors->has('certifications') ? ' is-invalid' : '' }}">
                    <label for="field-certifications">{{ __('user.certifications') }}</label>
                    <textarea class="form-control" name="certifications" rows="6">{{ old('certifications', $user->certifications) }}</textarea>
                    <div class="invalid-feedback">{{ $errors->first('certifications') }}</div>
                </div>
            </div>
        </div>
        @endrole
    </div>

    <div class="block-content block-content-full bg-gray-lighter">
        <div class="row">
            <div class="col-auto mr-auto">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">{{ __('general.save') }}</button>
            </div>
        </div>
    </div>
</form>
</div>
@endsection
