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
                    <div class="form-group{{ $errors->has('admin_path') ? ' is-invalid' : '' }}">
                        <label for="field-admin_path">{{ __('setting.admin_path') }}</label>
                        <input type="text" class="form-control" id="field-admin_path" name="admin_path" value="{{ old('admin_path', config('app.admin_path')) }}">
                        <div class="invalid-feedback">{{ $errors->first('admin_path') }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('pagination') ? ' is-invalid' : '' }}">
                        <label for="field-pagination">{{ __('setting.pagination') }}</label>
                        <input type="text" class="form-control" id="field-pagination" name="pagination" value="{{ old('pagination', config('app.pagination')) }}">
                        <div class="invalid-feedback">{{ $errors->first('pagination') }}</div>
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
