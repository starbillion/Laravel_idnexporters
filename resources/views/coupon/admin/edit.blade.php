@extends('_layouts.backend')
@section('title', __('coupon.edit'))

@section('content')
<div class="block block-bordered">
	<form action="{{ route('admin.coupon.update', $post->id) }}" method="post">
		{{ csrf_field() }}
		<input name="_method" type="hidden" value="PUT">
		<div class="block-content block-content-full">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group{{ $errors->has('code') ? ' is-invalid' : '' }}">
						<label for="field-code">{{ __('coupon.code') }}</label>
						<input type="text" class="form-control" id="field-code" name="code" value="{{ old('code', $post->code) }}">
						<div class="invalid-feedback">{{ $errors->first('code') }}</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group{{ $errors->has('nominal') ? ' is-invalid' : '' }}">
						<label for="field-nominal">{{ __('coupon.nominal') }}</label>
						<input type="text" class="form-control" id="field-nominal" name="nominal" value="{{ old('nominal', $post->nominal) }}">
						<div class="invalid-feedback">{{ $errors->first('nominal') }}</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group{{ $errors->has('note') ? ' is-invalid' : '' }}">
						<label for="field-note">{{ __('coupon.note') }}</label>
						<input type="text" class="form-control" id="field-note" name="note" value="{{ old('note', $post->note) }}">
						<div class="invalid-feedback">{{ $errors->first('note') }}</div>
					</div>
				</div>
			</div>
		</div>
		<div class="block-content block-content-full bg-gray-lighter border-t">
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
