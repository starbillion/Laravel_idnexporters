@extends('_layouts.backend')
@section('title', __('endorsement.add'))

@section('content')
<div class="block block-bordered">
	<form action="{{ route('admin.endorsement.store') }}" method="post">
		{{ csrf_field() }}
		<div class="block-content block-content-full">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
						<label for="field-name">{{ __('endorsement.name') }}</label>
						<input type="text" class="form-control" id="field-name" name="name" value="{{ old('name') }}">
						<div class="invalid-feedback">{{ $errors->first('name') }}</div>
					</div>
				</div>
				<div class="col-md-12" style="position: relative;">
					<div class="form-group{{ $errors->has('body') ? ' is-invalid' : '' }}">
						<label for="field-body">{{ __('exhibition.body') }}</label>
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
<script type="text/javascript" src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
	$(function(){
		Codebase.helpers('datepicker');

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
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@endpush
