@extends('_layouts.backend')
@section('title', __('faq.category_data.add'))

@section('content')
<div class="block block-bordered">
	<form action="{{ route('admin.faq.category.store') }}" method="post">
		{{ csrf_field() }}
		<div class="block-content block-content-full">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
						<label for="field-name">{{ __('faq.category_data.name') }}</label>
						<input type="text" class="form-control" id="field-name" name="name" value="{{ old('name') }}">
						<div class="invalid-feedback">{{ $errors->first('name') }}</div>
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
