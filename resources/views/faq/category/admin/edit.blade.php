@extends('_layouts.backend')
@section('title', __('faq.category_data.edit'))

@section('content')
<div class="block block-bordered">
	<form action="{{ route('admin.faq.category.update', $category->id) }}" method="post">
		{{ csrf_field() }}
		<input name="_method" type="hidden" value="PUT">
		<div class="block-content block-content-full">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
						<label for="field-name">{{ __('product/post.name') }}</label>
						<input type="text" class="form-control" id="field-name" name="name" value="{{ old('name', $category->name) }}">
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
