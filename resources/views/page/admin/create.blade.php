@extends('_layouts.backend')
@section('title', __('page.add'))

@section('content')
<div class="block block-bordered">
	<form action="{{ route('admin.page.store') }}" method="post">
		{{ csrf_field() }}
		<div class="block-content block-content-full">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group{{ $errors->has('title') ? ' is-invalid' : '' }}">
						<label for="field-title">{{ __('page.title') }}</label>
						<input type="text" class="form-control" id="field-title" name="title" value="{{ old('title') }}">
						<div class="invalid-feedback">{{ $errors->first('title') }}</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group{{ $errors->has('slug') ? ' is-invalid' : '' }}">
						<label for="field-slug">{{ __('page.slug') }}</label>
						<div class="input-group">
							<span class="input-group-addon {{ $errors->has('slug') ? 'bg-danger text-white border-danger' : '' }}">{{ preg_replace("(^https?://)", "", url('/page')) }}/</span>
							<input type="text" class="form-control" id="field-slug" name="slug" value="{{ old('slug') }}">
						</div>
						<div class="invalid-feedback">{{ $errors->first('slug') }}</div>
					</div>
				</div>
				<div class="col-md-12" style="position: relative;">
					<div class="form-group{{ $errors->has('body') ? ' is-invalid' : '' }}">
						<label for="field-body">{{ __('page.body') }}</label>
						<textarea id="field-body" class="form-control" name="body" rows="6">{{ old('body') }}</textarea>
						<div class="invalid-feedback">{{ $errors->first('body') }}</div>
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

@push('script')
<script type="text/javascript" src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script type="text/javascript">
	$(function(){
		$('#field-body').summernote({
			height: 400,
			tooltip: false,
			toolbar: [
			    ['style', ['bold', 'italic', 'underline', 'clear']],
			    ['para', ['ul', 'ol']],
			    ['insert', ['picture', 'link', 'video', 'table', 'hr']]
		    ]
		});

	})
</script>
@endpush

@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
@endpush
