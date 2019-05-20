@extends('_layouts.backend')
@section('title', __('user.profile_tab_media'))

@section('content')
<div class="block block-bordered">
    @include('user.member._tabs')

    <form method="post" action="{{ route('member.profile.update') }}">
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PUT">
        <div class="block-content block-content-full">

            <div class="row">
                <div class="col-md-7">
                    <div class="form-group{{ $errors->has('video_1') ? ' is-invalid' : '' }}">
                        <div class="form-group{{ $errors->has('video_1') ? ' is-invalid' : '' }}">
                            <label for="field-video_1">{{ __('user.video_1') }}</label>
                            <input type="text" class="form-control" id="field-video_1" name="video_1" value="{{ old('video_1', $user->video_1) }}" placeholder="{{ __('user.video_placeholder') }}">
                            <div class="invalid-feedback">{{ $errors->first('video_1') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form-group{{ $errors->has('video_2') ? ' is-invalid' : '' }}">
                        <div class="form-group{{ $errors->has('video_2') ? ' is-invalid' : '' }}">
                            <label for="field-video_2">{{ __('user.video_2') }}</label>
                            <input type="text" class="form-control" id="field-video_2" name="video_2" value="{{ old('video_2', $user->video_2) }}" placeholder="{{ __('user.video_placeholder') }}">
                            <div class="invalid-feedback">{{ $errors->first('video_2') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form-group{{ $errors->has('video_3') ? ' is-invalid' : '' }}">
                        <div class="form-group{{ $errors->has('video_3') ? ' is-invalid' : '' }}">
                            <label for="field-video_3">{{ __('user.video_3') }}</label>
                            <input type="text" class="form-control" id="field-video_3" name="video_3" value="{{ old('video_3', $user->video_3) }}" placeholder="{{ __('user.video_placeholder') }}">
                            <div class="invalid-feedback">{{ $errors->first('video_3') }}</div>
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
