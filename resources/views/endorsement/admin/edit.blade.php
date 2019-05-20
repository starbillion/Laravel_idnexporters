@extends('_layouts.backend')
@section('title', __('endorsement.edit'))

@section('content')

<div class="block-content block-content-full">
	<div class="row justify-content-md-center">
		<div class="col-md-10 text-center">
			<div class="row justify-content-md-center">
				<div class="col-md-3">
					<div class="options-container">

						@if($post->getFirstMediaUrl('logo'))
						<img id="company_logo" class="img-thumbnail options-item" src="{{ asset($post->getFirstMediaUrl('logo', 'thumb')) }}" alt="">
						<div class="options-overlay bg-black-op-75">
							<div class="options-overlay-content p-20">
								<a class="btn btn-sm btn-block btn-alt-secondary min-width-75" onclick="event.preventDefault(); document.getElementById('upload-logo').click()">
									{{ __('endorsement.change_image') }}
								</a>
								<a class="btn btn-sm btn-block btn-alt-danger min-width-75" onclick="event.preventDefault(); Codebase.loader('show'); document.getElementById('form-delete').submit();">
									{{ __('endorsement.delete_image') }}
								</a>
								<form id="form-delete" method="post" action="{{ route('admin.endorsement.media.destroy', $post->getMedia('logo')[0]->id) }}" class="d-none">
									{{ csrf_field() }}
									<input name="_method" type="hidden" value="DELETE">
								</form>
							</div>
						</div>
						@else
						<img id="company_logo" class="img-thumbnail options-item" src="{{ asset('img/noimage.png') }}" alt="">
						<div class="options-overlay bg-black-op-75">
							<div class="options-overlay-content p-20">
								<a class="btn btn-sm btn-block btn-alt-secondary min-width-75" onclick="event.preventDefault(); document.getElementById('upload-logo').click()">
									{{ __('endorsement.upload_image') }}
								</a>
							</div>
						</div>
						@endif

						<form id="form-upload" method="post" action="{{ route('admin.endorsement.media.store', $post->id) }}" class="d-none" enctype="multipart/form-data">
							{{ csrf_field() }}
							<input type="hidden" name="type" value="logo">
							<input id="upload-logo" type="file" name="logo" onchange="event.preventDefault(); Codebase.loader('show'); document.getElementById('form-upload').submit();" />
						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="block block-bordered">
	<form action="{{ route('admin.endorsement.update', $post->id) }}" method="post">
		{{ csrf_field() }}
		<input name="_method" type="hidden" value="PUT">
		<div class="block-content block-content-full">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
						<label for="field-name">{{ __('endorsement.name') }}</label>
						<input type="text" class="form-control" id="field-name" name="name" value="{{ old('name', $post->name) }}">
						<div class="invalid-feedback">{{ $errors->first('name') }}</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group{{ $errors->has('body') ? ' is-invalid' : '' }}">
						<label for="field-body">{{ __('exhibition.body') }}</label>
						<textarea id="field-body" class="form-control" name="body" rows="6">{{ old('body', $post->body) }}</textarea>
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
