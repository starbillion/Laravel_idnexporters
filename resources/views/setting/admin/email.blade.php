@extends('_layouts.backend')
@section('title', __('general.settings'))

@section('content')
<div class="block block-bordered" id="block-wrapper">
    @include('setting.admin._tabs')

    <form action="{{ route('admin.setting.update') }}" method="post">
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PUT">


        @foreach(config('emails') as $section => $forms)
        <div class="block-content block-content-full tab-content border-b">
            <h5 class="text-danger">{{ __('setting.email_header.' . $section) }}</h5>

            @foreach($forms as $form => $field)
                <h6 class="text-danger">{{ __('setting.email_header.' . $section . '_' . $form) }}</h6>

                @if(isset($field['subject']))
                <div class="form-group row {{ $errors->first($section . '_' . $form . '_subject') ? 'is-invalid' : '' }}">
                    <label for="field-{{ $section }}_{{ $form }}_subject" class="col-sm-2 col-form-label">{{ __('setting.subject') }}</label>
                    <div class="col-sm-10">
                        <input
                            type="text"
                            class="form-control"
                            id="field-{{ $section }}_{{ $form }}_subject"
                            name="{{ $section }}_{{ $form }}_subject"
                            value="{{ old($section . '_' . $form . '_subject', config('emails.' . $section . '.' . $form . '.subject')) }}">

                        <div class="invalid-feedback">
                            {{ $errors->first($section . '_' . $form . '_subject') }}
                        </div>
                    </div>
                </div>
                @endif

                @if(isset($field['button']))
                <div class="form-group row {{ $errors->first($section . '_' . $form . '_button') ? 'is-invalid' : '' }}">
                    <label for="field-{{ $section }}_{{ $form }}_button" class="col-sm-2 col-form-label">{{ __('setting.button') }}</label>
                    <div class="col-sm-10">
                        <input
                            type="text"
                            class="form-control"
                            id="field-{{ $section }}_{{ $form }}_button"
                            name="{{ $section }}_{{ $form }}_button"
                            value="{{ old($section . '_' . $form . '_button', config('emails.' . $section . '.' . $form . '.button')) }}">

                        <div class="invalid-feedback">
                            {{ $errors->first($section . '_' . $form . '_button') }}
                        </div>
                    </div>
                </div>
                @endif

                @if(isset($field['recipients']))
                <div class="form-group row {{ $errors->first($section . '_' . $form . '_recipients') ? 'is-invalid' : '' }}">
                    <label for="field-{{ $section }}_{{ $form }}_recipients" class="col-sm-2 col-form-label">{{ __('setting.recipients') }}</label>
                    <div class="col-sm-10">
                        <input
                            type="text"
                            class="form-control"
                            id="field-{{ $section }}_{{ $form }}_recipients"
                            name="{{ $section }}_{{ $form }}_recipients"
                            value="{{ old($section . '_' . $form . '_recipients', config('emails.' . $section . '.' . $form . '.recipients')) }}">

                        <div class="invalid-feedback">
                            {{ $errors->first($section . '_' . $form . '_recipients') }}
                        </div>
                    </div>
                </div>
                @endif

                @if(isset($field['body']))
                <div class="form-group row {{ $errors->first($section . '_' . $form . '_body') ? 'is-invalid' : '' }}">
                    <label for="field-{{ $section }}_{{ $form }}_body" class="col-sm-2 col-form-label">{{ __('setting.body') }}</label>
                    <div class="col-sm-10">
                        <textarea
                            type="text"
                            class="form-control"
                            id="field-{{ $section }}_{{ $form }}_body"
                            name="{{ $section }}_{{ $form }}_body">{{ old($section . '_' . $form . '_body', config('emails.' . $section . '.' . $form . '.body')) }}
                            </textarea>

                        <div class="invalid-feedback">
                            {{ $errors->first($section . '_' . $form . '_body') }}
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
        @endforeach





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
