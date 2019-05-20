@extends('_layouts.backend')
@section('title', __('user.profile_tab_company'))

@section('content')
<div class="block block-bordered">
    @include('user.member._tabs')

    <form method="post" action="{{ route('member.profile.update') }}">
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PUT">
        <div class="block-content block-content-full">

            <div class="row">
                <div class="col-md-5">
                    <div class="form-group{{ $errors->has('company') ? ' is-invalid' : '' }}">
                        <div class="form-group{{ $errors->has('company') ? ' is-invalid' : '' }}">
                            <label for="field-company">{{ __('user.company') }}</label>
                            <input type="text" class="form-control" id="field-company" name="company" value="{{ old('company', $user->company) }}">
                            <div class="invalid-feedback">{{ $errors->first('company') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group{{ $errors->has('business_types') ? ' is-invalid' : '' }}">
                        <label for="field-business_types">{{ __('user.business_types') }}</label>
                        <select class="js-select2 form-control" id="field-business_types" name="business_types[]" style="width: 100%;" data-placeholder="{{ __('general.choose') }}" multiple="multiple">
                            <option></option>
                            @foreach(['manufacturer', 'wholesaler', 'distributor', 'retailer'] as $type)
                            <option value="{{ $type }}" {{ (collect(old('business_types', $user->business_types))->contains($type)) ? 'selected':'' }}>{{ __('user.business_types_data.' . $type) }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">{{ $errors->first('business_types') }}</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group{{ $errors->has('established') ? ' is-invalid' : '' }}">
                        <div class="form-group{{ $errors->has('established') ? ' is-invalid' : '' }}">
                            <label for="field-established">{{ __('user.established') }}</label>
                            <input type="text" class="form-control" id="field-established" name="established" value="{{ old('established', $user->established) }}">
                            <div class="invalid-feedback">{{ $errors->first('established') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('city') ? ' is-invalid' : '' }}">
                        <div class="form-group{{ $errors->has('city') ? ' is-invalid' : '' }}">
                            <label for="field-city">{{ __('user.city') }}</label>
                            <input type="text" class="form-control" id="field-city" name="city" value="{{ old('city', $user->city) }}">
                            <div class="invalid-feedback">{{ $errors->first('city') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('postal') ? ' is-invalid' : '' }}">
                        <div class="form-group{{ $errors->has('postal') ? ' is-invalid' : '' }}">
                            <label for="field-postal">{{ __('user.postal') }}</label>
                            <input type="text" class="form-control" id="field-postal" name="postal" value="{{ old('postal', $user->postal) }}">
                            <div class="invalid-feedback">{{ $errors->first('postal') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('country_id') ? ' is-invalid' : '' }}">
                        <label for="field-country_id">{{ __('user.country') }}</label>
                        <select class="js-select2 form-control" id="field-country_id" name="country_id" style="width: 100%;" data-placeholder="{{ __('general.choose') }}">
                            <option></option>
                            @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ old('country_id', $user->country_id) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">{{ $errors->first('country_id') }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('mobile') ? ' is-invalid' : '' }}">
                        <div class="form-group{{ $errors->has('mobile') ? ' is-invalid' : '' }}">
                            <label for="field-mobile">{{ __('user.mobile') }}</label>
                            <input type="text" class="form-control" id="field-mobile" name="mobile" value="{{ old('mobile', $user->mobile) }}" placeholder="{{ __('user.phone_placeholder') }}">
                            <div class="invalid-feedback">{{ $errors->first('mobile') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('phone_1') ? ' is-invalid' : '' }}">
                        <div class="form-group{{ $errors->has('phone_1') ? ' is-invalid' : '' }}">
                            <label for="field-phone_1">{{ __('user.phone_1') }}</label>
                            <input type="text" class="form-control" id="field-phone_1" name="phone_1" value="{{ old('phone_1', $user->phone_1) }}" placeholder="{{ __('user.phone_placeholder') }}">
                            <div class="invalid-feedback">{{ $errors->first('phone_1') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('phone_2') ? ' is-invalid' : '' }}">
                        <div class="form-group{{ $errors->has('phone_2') ? ' is-invalid' : '' }}">
                            <label for="field-phone_2">{{ __('user.phone_2') }}</label>
                            <input type="text" class="form-control" id="field-phone_2" name="phone_2" value="{{ old('phone_2', $user->phone_2) }}" placeholder="{{ __('user.phone_placeholder') }}">
                            <div class="invalid-feedback">{{ $errors->first('phone_2') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('fax') ? ' is-invalid' : '' }}">
                        <div class="form-group{{ $errors->has('fax') ? ' is-invalid' : '' }}">
                            <label for="field-fax">{{ __('user.fax') }}</label>
                            <input type="text" class="form-control" id="field-fax" name="fax" value="{{ old('fax', $user->fax) }}" placeholder="{{ __('user.phone_placeholder') }}">
                            <div class="invalid-feedback">{{ $errors->first('fax') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('company_email') ? ' is-invalid' : '' }}">
                        <div class="form-group{{ $errors->has('company_email') ? ' is-invalid' : '' }}">
                            <label for="field-company_email">{{ __('user.company_email') }}</label>
                            <input type="text" class="form-control" id="field-company_email" name="company_email" value="{{ old('company_email', $user->company_email) }}">
                            <div class="invalid-feedback">{{ $errors->first('company_email') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('website') ? ' is-invalid' : '' }}">
                        <div class="form-group{{ $errors->has('website') ? ' is-invalid' : '' }}">
                            <label for="field-website">{{ __('user.website') }}</label>
                            <input type="text" class="form-control" id="field-website" name="website" value="{{ old('website', $user->website) }}" placeholder="{{ __('user.website_placeholder') }}">
                            <div class="invalid-feedback">{{ $errors->first('website') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group{{ $errors->has('languages') ? ' is-invalid' : '' }}">
                        <label for="field-languages">{{ __('user.languages') }}</label>
                        <select class="js-select2 form-control" id="field-languages" name="languages[]" style="width: 100%;" data-placeholder="{{ __('general.choose') }}" multiple="multiple">
                            <option></option>
                            @foreach($languages as $language)
                            <option value="{{ $language->id }}" {{ (collect(old('languages', $user->languages))->contains($language->id)) ? 'selected':'' }}>{{ $language->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">{{ $errors->first('languages') }}</div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group{{ $errors->has('address') ? ' is-invalid' : '' }}">
                        <label for="field-address">{{ __('user.address') }}</label>
                        <textarea class="form-control" name="address" rows="6">{{ old('address', $user->address) }}</textarea>
                        <div class="invalid-feedback">{{ $errors->first('address') }}</div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group{{ $errors->has('description') ? ' is-invalid' : '' }}">
                        <label for="field-description">{{ __('user.description') }}</label>
                        <textarea class="form-control" name="description" rows="6">{{ old('description', $user->description) }}</textarea>
                        <div class="invalid-feedback">{{ $errors->first('description') }}</div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group{{ $errors->has('additional_notes') ? ' is-invalid' : '' }}">
                        <label for="field-additional_notes">{{ __('user.additional_notes') }}</label>
                        <textarea class="form-control" name="additional_notes" rows="6">{{ old('additional_notes', $user->additional_notes) }}</textarea>
                        <div class="invalid-feedback">{{ $errors->first('additional_notes') }}</div>
                    </div>
                </div>
            </div>
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
