@extends('_layouts.backend')
@section('title', __('general.role') . ' - '. __('general.add'))

@section('content')
<div class="block block-bordered">
    <form action="{{ route('admin.role.store') }}" method="post">
        {{ csrf_field() }}
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                        <label for="field-name">{{ __('role.name') }}</label>
                        <input type="text" class="form-control" id="field-name" name="name" value="{{ old('name') }}">
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('display_name') ? ' is-invalid' : '' }}">
                        <label for="field-display_name">{{ __('role.display_name') }}</label>
                        <input type="text" class="form-control" id="field-display_name" name="display_name" value="{{ old('display_name') }}">
                        <div class="invalid-feedback">{{ $errors->first('display_name') }}</div>
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
