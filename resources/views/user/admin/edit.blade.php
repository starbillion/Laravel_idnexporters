@extends('_layouts.backend')
@section('title', $user->company)

@section('content')
<nav class="breadcrumb bg-white push">
    <a class="breadcrumb-item" href="{{ route('admin.user.index') }}">{{ __('general.users') }}</a>
    <span class="breadcrumb-item active text-muted">{{ __('general.edit') }}</span>
</nav>

<div class="block block-bordered">
    <div class="block-content">
        <div class="row">
            <div class="col-md-6 mb-20">
                <div class="d-flex justify-content-start">
                    <div class="mr-5">
                        <form action="{{ route('admin.user.update', $user->id) }}" method="post">
                            {{ csrf_field() }}
                            <input name="_method" type="hidden" value="PUT">
                            <input type="hidden" name="status" value="pending">
                            <button type="submit" class="btn {{ $user->isPending() ? 'btn-primary' : 'btn-secondary' }}">{{ __('user.pending') }}</button>
                        </form>
                    </div>
                    <div class="mr-5">
                        <form action="{{ route('admin.user.update', $user->id) }}" method="post">
                            {{ csrf_field() }}
                            <input name="_method" type="hidden" value="PUT">
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="btn {{ $user->isApproved() ? 'btn-primary' : 'btn-secondary' }}">{{ __('user.approve') }}</button>
                        </form>
                    </div>
                    <div class="mr-5">
                        <form action="{{ route('admin.user.update', $user->id) }}" method="post">
                            {{ csrf_field() }}
                            <input name="_method" type="hidden" value="PUT">
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="btn {{ $user->isRejected() ? 'btn-primary' : 'btn-secondary' }}">{{ __('user.reject') }}</button>
                        </form>
                    </div>
                </div>
            </div>



            <div class="col-md-6 mb-20">
                <div class="d-flex justify-content-end">
                    @foreach($plans as $plan)
                    <div class="ml-5">
                        <form action="{{ route('admin.user.update', $user->id) }}" method="post">
                            {{ csrf_field() }}
                            <input name="_method" type="hidden" value="PUT">
                            <input type="hidden" name="membership" value="{{ $plan->id }}">
                            <button type="submit" class="btn {{ userPackage($user->id)->id == $plan->id ? 'btn-primary' : 'btn-secondary' }}">
                                {{ __('package.' . userPackage($user->id)->type . '.' . $plan->name . '.name') }}
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>





        </div>
    </div>
</div>

<div class="block block-bordered" id="block-wrapper">
    <form method="post" action="{{ route('admin.user.update', $user->id) }}">
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PUT">
        <div class="block-content block-content-full">
            <div class="h5 text-primary">General</div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('salutation') ? ' is-invalid' : '' }}">
                        <label for="field-salutation">{{ __('user.salutation') }}</label>
                        <select class="js-select2 form-control" id="field-salutation" name="salutation" style="width: 100%;" data-placeholder="{{ __('general.choose') }}">
                            <option></option>
                            <option value="mr" {{ old('salutation', $user->salutation) == 'mr' ? 'selected' : '' }}>{{ __('user.mr') }}</option>
                            <option value="mrs" {{ old('salutation', $user->salutation) == 'mrs' ? 'selected' : '' }}>{{ __('user.mrs') }}</option>
                            <option value="ms" {{ old('salutation', $user->salutation) == 'ms' ? 'selected' : '' }}>{{ __('user.ms') }}</option>
                            <option value="dr" {{ old('salutation', $user->salutation) == 'dr' ? 'selected' : '' }}>{{ __('user.dr') }}</option>
                            <option value="prof" {{ old('salutation', $user->salutation) == 'prof' ? 'selected' : '' }}>{{ __('user.prof') }}</option>
                        </select>
                        <div class="invalid-feedback">{{ $errors->first('salutation') }}</div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                        <label for="field-name">{{ __('user.name') }}</label>
                        <input type="text" class="form-control" id="field-name" name="name" value="{{ old('name', $user->name) }}">
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                        <label for="field-email">{{ __('user.email') }}</label>
                        <input type="text" class="form-control" id="field-email" name="email" value="{{ old('email', $user->email) }}">
                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('password') ? ' is-invalid' : '' }}">
                        <div class="form-group{{ $errors->has('password') ? ' is-invalid' : '' }}">
                            <label for="field-password">{{ __('user.password') }}</label>
                            <input type="password" class="form-control" id="field-password" name="password" placeholder="{{ __('user.password') }}">
                            <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group{{ $errors->has('halal') ? ' is-invalid' : '' }}">
                        <label for="field-halal">{{ __('user.halal') }}</label>
                        <select class="js-select2 form-control" id="field-halal" name="halal" style="width: 100%;" data-placeholder="{{ __('general.choose') }}">
                            <option></option>
                            <option value="1" {{ old('halal', $user->halal) == '1' ? 'selected' : '' }}>{{ __('user.halal') }}</option>
                            <option value="0" {{ old('halal', $user->halal) == '0' ? 'selected' : '' }}>{{ __('user.non_halal') }}</option>
                        </select>
                        <div class="invalid-feedback">{{ $errors->first('halal') }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group{{ $errors->has('verified_member') ? ' is-invalid' : '' }}">
                        <label for="field-verified_member">{{ __('user.verified_member') }}</label>
                        <select class="js-select2 form-control" id="field-verified_member" name="verified_member" style="width: 100%;" data-placeholder="{{ __('general.choose') }}">
                            <option></option>
                            <option value="0" {{ old('verified_member', $user->verified_member) == 0 ? 'selected' : '' }}>{{ __('general.no') }}</option>
                            <option value="1" {{ old('verified_member', $user->verified_member) == 1 ? 'selected' : '' }}>{{ __('general.yes') }}</option>
                        </select>
                        <div class="invalid-feedback">{{ $errors->first('verified_member') }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group{{ $errors->has('subscribe') ? ' is-invalid' : '' }}">
                        <label for="field-subscribe">{{ __('user.subscribe') }}</label>
                        <select class="js-select2 form-control" id="field-subscribe" name="subscribe" style="width: 100%;" data-placeholder="{{ __('general.choose') }}">
                            <option></option>
                            <option value="0" {{ old('subscribe', $user->subscribe) == 0 ? 'selected' : '' }}>{{ __('general.no') }}</option>
                            <option value="1" {{ old('subscribe', $user->subscribe) == 1 ? 'selected' : '' }}>{{ __('general.yes') }}</option>
                        </select>
                        <div class="invalid-feedback">{{ $errors->first('subscribe') }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group{{ $errors->has('hide_contact') ? ' is-invalid' : '' }}">
                        <label for="field-hide_contact">{{ __('user.hide_contact') }}</label>
                        <select class="js-select2 form-control" id="field-hide_contact" name="hide_contact" style="width: 100%;" data-placeholder="{{ __('general.choose') }}">
                            <option></option>
                            <option value="1" {{ old('hide_contact', $user->hide_contact) == '1' ? 'selected' : '' }}>{{ __('general.yes') }}</option>
                            <option value="0" {{ old('hide_contact', $user->hide_contact) == '0' ? 'selected' : '' }}>{{ __('general.no') }}</option>
                        </select>
                        <div class="invalid-feedback">{{ $errors->first('hide_contact') }}</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group{{ $errors->has('verified') ? ' is-invalid' : '' }}">
                        <label for="field-verified">{{ __('user.verified') }}</label>
                        <select class="js-select2 form-control" id="field-verified" name="verified" style="width: 100%;" data-placeholder="{{ __('general.choose') }}">
                            <option></option>
                            <option value="1" {{ old('verified', $user->verified) == '1' ? 'selected' : '' }}>{{ __('general.yes') }}</option>
                            <option value="0" {{ old('verified', $user->verified) == '0' ? 'selected' : '' }}>{{ __('general.no') }}</option>
                        </select>
                        <div class="invalid-feedback">{{ $errors->first('verified') }}</div>
                    </div>
                </div>
            </div>

            <div class="h5 text-primary mt-20">Company</div>
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

            <div class="h5 text-primary mt-20">Profile</div>
            <div class="row">
                @if($user->hasRole('seller'))
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
                @endif

                @if($user->hasRole('buyer'))
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
                @endif
            </div>
            @if($user->hasRole('seller'))
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
            @endif

            <div class="h5 text-primary mt-20">Category</div>
            <div id="c1" data-children=".c1_item">
                @foreach($categories as $c1)
                <div class="c1_item">
                    <a data-toggle="collapse" data-parent="#c1" href="#{{ $c1->id }}_accordion">
                        {{ $c1->name }}
                    </a>
                    <div id="{{ $c1->id }}_accordion" class="collapse" role="tabpanel">
                        <div class="pl-20">
                            <div id="c2{{ $c1->id }}" data-children=".c2_item">
                                @foreach($c1->children as $c2)
                                <div class="c2_item">
                                    <a data-toggle="collapse" data-parent="#c2{{ $c1->id }}" href="#{{ $c2->id }}_accordion">
                                        {{ $c2->name }}
                                    </a>
                                    <div id="{{ $c2->id }}_accordion" class="collapse" role="tabpanel">
                                        <div class="pl-20">
                                            @foreach($c2->children as $c3)
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input data-name="{{ trim($c3->name) }}" class="form-check-input" type="checkbox" name="categories[]" value="{{ $c3->id }}"
                                                    {{ (collect(old('categories', $user->categories))->contains($c3->id)) ? 'checked':'' }}
                                                    >
                                                    <span id="cat-{{ $c3->id }}">{{ $c3->name }}</span>
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
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

@push('script')
<script src="{{ asset('plugins/sweetalert2/es6-promise.auto.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script type="text/javascript">
    $(function(){

        $('input[type=checkbox].form-check-input').on('change', function (e) {
            if ($('input[type=checkbox].form-check-input:checked').length > 3) {
                $(this).prop('checked', false);
                swal ( "Oops" ,  "Allowed only 3" ,  "warning" )
            }

            updateMainExports();
            highlightSelected();
        });

        function updateMainExports(){
            var value = '';

            $('input[type=checkbox].form-check-input:checked').each(function(){
                value = value + $(this).attr('data-name') + ', '
            });

            $('#field-main_exports').val(value.slice(0,-2));
        }

        highlightSelected();

        function highlightSelected(){
            $('#c1 a').css({
                'font-weight': 'normal',
                'text-decoration': 'none'
            });

            $('input[type=checkbox].form-check-input:checked').each(function(){
                var c1 = $(this).parent().parent().parent().parent().parent().parent().parent().parent().siblings('a').css({
                    'font-weight': '700',
                    'text-decoration': 'underline'
                });

                var c2 = $(this).parent().parent().parent().parent().siblings('a').css({
                    'font-weight': '700',
                    'text-decoration': 'underline'
                });
            });
        }

    })
</script>
@endpush
