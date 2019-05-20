@extends('_layouts.backend')
@section('title', __('user.import'))

@section('content')

<div class="block block-bordered">
    <div class="block-content block-content-full">
        <form id="form-upload" method="post" action="{{ route('admin.user.import.process') }}" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group{{ $errors->has('file') ? ' is-invalid' : '' }}">
                        <input id="upload-file" type="file" name="file" class="form-control" />
                        <div class="invalid-feedback">{{ $errors->first('file') }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary btn-block">
                        {{ __('user.import') }}
                    </button>
                </div>
            </div>
        </form>

        <hr>

        <a href="{{ route('admin.user.import', ['draft' => 1]) }}">Download Example CSV</a>
    </div>
</div>
@endsection
