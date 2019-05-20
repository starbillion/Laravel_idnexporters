@extends('_layouts.backend')
@section('title', __('general.settings'))

@section('content')
<div class="block block-bordered" id="block-wrapper">
    @include('setting.admin._tabs')

    <form action="{{ route('admin.setting.update') }}" method="post">
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PUT">
        <div class="block-content block-content-full tab-content">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                        <label for="field-name">{{ __('setting.name') }}</label>
                        <input type="text" class="form-control" id="field-name" name="name" value="{{ old('name', config('app.name')) }}">
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('company.name') ? ' is-invalid' : '' }}">
                        <label for="field-company_name">{{ __('setting.company.name') }}</label>
                        <input type="text" class="form-control" id="field-company_name" name="company[name]" value="{{ old('company.name', config('app.company.name')) }}">
                        <div class="invalid-feedback">{{ $errors->first('company.name') }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('company.phone') ? ' is-invalid' : '' }}">
                        <label for="field-company_phone">{{ __('setting.company.phone') }}</label>
                        <input type="text" class="form-control" id="field-company_phone" name="company[phone]" value="{{ old('company.phone', config('app.company.phone')) }}">
                        <div class="invalid-feedback">{{ $errors->first('company.phone') }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('company.fax') ? ' is-invalid' : '' }}">
                        <label for="field-company_fax">{{ __('setting.company.fax') }}</label>
                        <input type="text" class="form-control" id="field-company_fax" name="company[fax]" value="{{ old('company.fax', config('app.company.fax')) }}">
                        <div class="invalid-feedback">{{ $errors->first('company.fax') }}</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('company.address_1') ? ' is-invalid' : '' }}">
                        <label for="field-company_address_1">{{ __('setting.company.address_1') }}</label>
                        <input type="text" class="form-control" id="field-company_address_1" name="company[address_1]" value="{{ old('company.address_1', config('app.company.address_1')) }}">
                        <div class="invalid-feedback">{{ $errors->first('company.address_1') }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('company.address_2') ? ' is-invalid' : '' }}">
                        <label for="field-company_address_2">{{ __('setting.company.address_2') }}</label>
                        <input type="text" class="form-control" id="field-company_address_2" name="company[address_2]" value="{{ old('company.address_2', config('app.company.address_2')) }}">
                        <div class="invalid-feedback">{{ $errors->first('company.address_2') }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('company.address_3') ? ' is-invalid' : '' }}">
                        <label for="field-company_address_3">{{ __('setting.company.address_3') }}</label>
                        <input type="text" class="form-control" id="field-company_address_3" name="company[address_3]" value="{{ old('company.address_3', config('app.company.address_3')) }}">
                        <div class="invalid-feedback">{{ $errors->first('company.address_3') }}</div>
                    </div>
                </div>
                <div class="col-md-12" style="position: relative;">
                    <div class="form-group{{ $errors->has('billing_info') ? ' is-invalid' : '' }}">
                        <label for="field-billing_info">Billing Info</label>
                        <textarea id="field-billing_info" class="form-control" name="billing_info" rows="6">{{ old('billing_info', config('app.billing_info')) }}</textarea>
                        <div class="invalid-feedback">{{ $errors->first('billing_info') }}</div>
                    </div>
                </div>
                <div class="col-md-12" style="position: relative;">
                    <div class="form-group{{ $errors->has('billing_info_intl') ? ' is-invalid' : '' }}">
                        <label for="field-billing_info_intl">Billing Info International</label>
                        <textarea id="field-billing_info_intl" class="form-control" name="billing_info_intl" rows="6">{{ old('billing_info_intl', config('app.billing_info_intl')) }}</textarea>
                        <div class="invalid-feedback">{{ $errors->first('billing_info_intl') }}</div>
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


@push('script')
<script type="text/javascript" src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script type="text/javascript">
    $(function(){
        $('#field-billing_info, #field-billing_info_intl').summernote({
            height: 400,
            tooltip: false,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol']],
                ['insert', ['picture', 'link', 'video', 'table', 'hr']]
            ]
        });

    })
</script>
@endpush

@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
@endpush
