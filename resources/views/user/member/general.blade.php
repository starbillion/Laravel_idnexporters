@extends('_layouts.backend')
@section('title', __('user.profile_tab_general'))

@section('content')
<div class="block block-bordered">
    @include('user.member._tabs')

    <form method="post" action="{{ route('member.profile.update') }}">
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PUT">
        <div class="block-content block-content-full">

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
            </div>

            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('old_password') ? ' is-invalid' : '' }}">
                        <div class="form-group{{ $errors->has('old_password') ? ' is-invalid' : '' }}">
                            <label for="field-old_password">{{ __('user.old_password') }}</label>
                            <input type="password" class="form-control" id="field-old_password" name="old_password" placeholder="{{ __('user.old_password') }}">
                            <div class="invalid-feedback">{{ $errors->first('old_password') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('password') ? ' is-invalid' : '' }}">
                        <div class="form-group{{ $errors->has('password') ? ' is-invalid' : '' }}">
                            <label for="field-password">{{ __('user.password') }}</label>
                            <input type="password" class="form-control" id="field-password" name="password" placeholder="{{ __('user.password') }}">
                            <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}">
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}">
                            <label for="field-password_confirmation">{{ __('user.password_confirmation') }}</label>
                            <input type="password" class="form-control" id="field-password_confirmation" name="password_confirmation" placeholder="{{ __('user.password_confirmation') }}">
                            <div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
                        </div>
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
