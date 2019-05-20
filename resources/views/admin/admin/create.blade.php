@extends('_layouts.backend')
@section('title', __('general.admin'))

@section('content')
<nav class="breadcrumb bg-white push">
    <a class="breadcrumb-item" href="{{ route('admin.admin.index') }}">{{ __('general.users') }}</a>
    <span class="breadcrumb-item active text-muted">{{ __('general.add') }}</span>
</nav>

<div class="block block-bordered" id="block-wrapper">
    <form method="post" action="{{ route('admin.admin.store') }}">
        {{ csrf_field() }}
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="control-label">Name</label>
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                        <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                        <label for="field-email">{{ __('user.email') }}</label>
                        <input type="text" class="form-control" id="field-email" name="email" value="{{ old('email') }}">
                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('password') ? ' is-invalid' : '' }}">
                        <label for="field-password">{{ __('user.password') }}</label>
                        <input type="password" class="form-control" id="field-password" name="password">
                        <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}">
                        <label for="field-password_confirmation">{{ __('user.password_confirmation') }}</label>
                        <input type="password" class="form-control" id="field-password_confirmation" name="password_confirmation">
                        <div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('role_id') ? ' is-invalid' : '' }}">
                        <label for="field-role_id">{{ __('general.role') }}</label>
                        <select class="js-select2 form-control" id="field-role_id" name="role_id" style="width: 100%;" data-placeholder="{{ __('general.choose') }}">
                            <option></option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->display_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">{{ $errors->first('role_id') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="block-content block-content-full bg-gray-lighter">
            <div class="row">
                <div class="col-auto mr-auto">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">{{ __('general.add') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
