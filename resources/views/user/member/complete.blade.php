@extends('_layouts.frontend')
@section('title', __('user.complete_profile'))

@section('content')
<div class="content content-full pt-50 pb-50">
    <div class="row justify-content-md-center">
        <div class="col-md-9">

            <div class="block block-bordered" id="complete1">
                <div class="block-content block-content-full">
                    <div class="row">
                        <div class="njd col-sm-4 text-center">
                            <div class="rnd">
                                <img src="http://foxel.id/web/icons/002-online-shop.svg" class="img-responsive center-block">
                            </div>
                        </div>

                        <div class="njd col-sm-8 text-left">
                            <h3>Complete your buyer profile</h3>
                            <p>A complete, accurate and correct information will increase your credibility to other Buyers and Sellers. It also helps others know your products and interest faster. A complete profile have 50-70% more engagement in trade deals.</p>
                            <a id="scroll" class="" href="javascript:;">Complete the form</a>
                        </div>
                    </div>
                </div>
            </div>

            @push('style')
            <style type="text/css">
            #complete1 .row {
                padding: 40px 20px;
            }
            #complete1 .row .njd .rnd {
                transition: all 0.1s ease 0s;
            }
            #complete1 .row .njd:hover .rnd {
                transform: scale(1.05);
            }
            #complete1 .row h2 {
                margin-bottom: 30px;
            }
            #complete1 .row h3 {
                margin-top: 30px;
            }
            #complete1 .row .rnd {
                border-radius: 50%;
                overflow: hidden;
                border: 3px dashed #cecece;
                padding: 40px;
            }
            #complete1 .row p {
                min-height: 70px;
            }
            </style>
            @endpush

            @push('script')
            <script type="text/javascript">
                $(function(){
                    $("#scroll").click(function() {
                        $('html, body').animate({
                            scrollTop: $("#block-wrapper").offset().top
                        }, 1000);
                    });
                })
            </script>
            @endpush


            <div class="block block-bordered" id="block-wrapper">
                <form method="post" action="{{ route('member.profile.update') }}">
                    {{ csrf_field() }}
                    <input name="_method" type="hidden" value="PUT">
                    <div class="block-content block-content-full">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('company') ? ' is-invalid' : '' }}">
                                    <div class="form-group{{ $errors->has('company') ? ' is-invalid' : '' }}">
                                        <label for="field-company">{{ __('user.company') }}</label>
                                        <input type="text" class="form-control" id="field-company" name="company" value="{{ old('company', $user->company) }}">
                                        <div class="invalid-feedback">{{ $errors->first('company') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('company_email') ? ' is-invalid' : '' }}">
                                    <div class="form-group{{ $errors->has('company_email') ? ' is-invalid' : '' }}">
                                        <label for="field-company_email">{{ __('user.company_email') }}</label>
                                        <input type="text" class="form-control" id="field-company_email" name="company_email" value="{{ old('company_email', $user->company_email) }}">
                                        <div class="invalid-feedback">{{ $errors->first('company_email') }}</div>
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
                                <div class="form-group{{ $errors->has('business_types') ? ' is-invalid' : '' }}">
                                    <label for="field-business_types">{{ __('user.business_types') }}</label>
                                    <select class="js-select2 form-control" id="field-business_types" name="business_types[]" style="width: 100%;" data-placeholder="{{ __('general.choose') }}"  multiple="multiple">
                                        <option></option>
                                        @foreach(['manufacturer', 'wholesaler', 'distributor', 'retailer'] as $type)
                                        <option value="{{ $type }}" {{ (collect(old('business_types', $user->business_types))->contains($type)) ? 'selected':'' }}>{{ __('user.business_types_data.' . $type) }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">{{ $errors->first('business_types') }}</div>
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
                                        <label for="field-phone_1">{{ __('user.office_phone') }}</label>
                                        <input type="text" class="form-control" id="field-phone_1" name="phone_1" value="{{ old('phone_1', $user->phone_1) }}" placeholder="{{ __('user.phone_placeholder') }}">
                                        <div class="invalid-feedback">{{ $errors->first('phone_1') }}</div>
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
        </div>
    </div>
</div>
@endsection

@push('script')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
@endpush

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
@endpush
