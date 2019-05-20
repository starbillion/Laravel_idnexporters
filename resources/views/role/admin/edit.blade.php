@extends('_layouts.backend')
@section('title', __('general.role') . ' - '. __('general.edit'))

@section('content')
<div class="block block-bordered">
    <form action="{{ route('admin.role.update', $role->id) }}" method="post">
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PUT">
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                        <label for="field-name">{{ __('role.name') }}</label>
                        <input type="text" class="form-control" id="field-name" name="name" value="{{ old('name', $role->name) }}">
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('display_name') ? ' is-invalid' : '' }}">
                        <label for="field-display_name">{{ __('role.display_name') }}</label>
                        <input type="text" class="form-control" id="field-display_name" name="display_name" value="{{ old('display_name', $role->display_name) }}">
                        <div class="invalid-feedback">{{ $errors->first('display_name') }}</div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                @php
                $modules = [
                    'user',
                    'product',
                    'message',
                    'traffic',
                    'search',
                    'faq',
                    'coupon',
                    'page',
                    'news',
                    'exhibition',
                    'endorsement',
                    'contact',
                    'setting',
                ];
                @endphp

                @foreach($modules as $module)
                <div class="col-md-3">
                    <div class="">
                        <label class="css-control css-control-primary css-checkbox">
                            <input type="checkbox" class="css-control-input" name="permissions[{{ $module }}]" {{ $role->permissions()->where('name', 'read-' . $module)->count() ? 'checked' : '' }}>
                            <span class="css-control-indicator"></span> {{ __('role.permissions.' . $module) }}
                        </label>
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
