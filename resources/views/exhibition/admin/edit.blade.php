@extends('_layouts.backend')
@section('title', __('exhibition.edit'))

@section('content')
<div class="block-content block-content-full">
	<div class="row justify-content-md-center">
		<div class="col-md-10 text-center">
			<div class="row justify-content-md-center">
				<div class="col-md-3">
					<div class="options-container">

						@if($post->getFirstMediaUrl('featured_image'))
						<img id="company_logo" class="img-thumbnail options-item" src="{{ asset($post->getFirstMediaUrl('featured_image', 'thumb')) }}" alt="">
						<div class="options-overlay bg-black-op-75">
							<div class="options-overlay-content p-20">
								<a class="btn btn-sm btn-block btn-alt-secondary min-width-75" onclick="event.preventDefault(); document.getElementById('upload-featured_image').click()">
									{{ __('exhibition.change_image') }}
								</a>
								<a class="btn btn-sm btn-block btn-alt-danger min-width-75" onclick="event.preventDefault(); Codebase.loader('show'); document.getElementById('form-delete').submit();">
									{{ __('exhibition.delete_image') }}
								</a>
								<form id="form-delete" method="post" action="{{ route('admin.exhibition.media.destroy', $post->id) }}" class="d-none">
									{{ csrf_field() }}
									<input name="_method" type="hidden" value="DELETE">
								</form>
							</div>
						</div>
						@else
						<img id="company_logo" class="img-thumbnail options-item" src="{{ asset('img/noimage.png') }}" alt="">
						<div class="options-overlay bg-black-op-75">
							<div class="options-overlay-content p-20">
								<a class="btn btn-sm btn-block btn-alt-secondary min-width-75" onclick="event.preventDefault(); document.getElementById('upload-featured_image').click()">
									{{ __('exhibition.upload_image') }}
								</a>
							</div>
						</div>
						@endif

						<form id="form-upload" method="post" action="{{ route('admin.exhibition.media.store', $post->id) }}" class="d-none" enctype="multipart/form-data">
							{{ csrf_field() }}
							<input type="hidden" name="type" value="featured_image">
							<input id="upload-featured_image" type="file" name="featured_image" onchange="event.preventDefault(); Codebase.loader('show'); document.getElementById('form-upload').submit();" />
						</form>

					</div>
				</div>
			</div>
			<span class="text-muted d-block mt-10">{{ __('exhibition.image_placeholder') }}</span>
		</div>
	</div>
</div>

<div class="block block-bordered">
	<form action="{{ route('admin.exhibition.update', $post->id) }}" method="post">
		{{ csrf_field() }}
		<input name="_method" type="hidden" value="PUT">

		<div class="block-header block-header-default border-b">
			<h3 class="block-title">{{ __('general.detail') }}</h3>
			<div class="block-options">
				<a href="{{ route('admin.exhibition_assign.index', [$post->id]) }}" class="btn btn-sm btn-alt-primary">
					Manage Exhibitors
				</a>
			</div>
		</div>
		<div class="block-content block-content-full mb-20">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group{{ $errors->has('title') ? ' is-invalid' : '' }}">
						<label for="field-title">{{ __('exhibition.title') }}</label>
						<input type="text" class="form-control" id="field-title" name="title" value="{{ old('title', $post->title) }}">
						<div class="invalid-feedback">{{ $errors->first('title') }}</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group{{ $errors->has('slug') ? ' is-invalid' : '' }}">
						<label for="field-slug">{{ __('exhibition.slug') }}</label>
						<div class="input-group">
  							<span class="input-group-addon {{ $errors->has('slug') ? 'bg-danger text-white border-danger' : '' }}">{{ preg_replace("(^https?://)", "", url('/exhibition')) }}/</span>
							<input type="text" class="form-control" id="field-slug" name="slug" value="{{ old('slug', $post->slug) }}">
						</div>
						<div class="invalid-feedback">{{ $errors->first('slug') }}</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group{{ ($errors->has('start_at') or $errors->has('ending_at')) ? ' is-invalid' : '' }}">
						<label for="field-date">{{ __('exhibition.date') }}</label>
						<div class="input-group">
							<input type="text" class="js-datepicker form-control" id="field-start_at" name="start_at" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="{{ old('start_at', $post->start_at ? $post->start_at->format('d-m-Y') : null) }}">
							<span class="input-group-addon {{ ($errors->has('start_at') or $errors->has('ending_at')) ? 'bg-danger border-danger text-white' : '' }}">Until</span>
							<input type="text" class="js-datepicker form-control" id="field-ending_at" name="ending_at" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="{{ old('ending_at', $post->ending_at ? $post->ending_at->format('d-m-Y') : null) }}">
						</div>
						<div class="invalid-feedback">
							{{ $errors->first('start_at') }}
							{{ $errors->first('ending_at') }}
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group{{ $errors->has('organizer') ? ' is-invalid' : '' }}">
						<label for="field-organizer">{{ __('exhibition.organizer') }}</label>
						<input type="text" class="form-control" id="field-organizer" name="organizer" value="{{ old('organizer', $post->organizer) }}">
						<div class="invalid-feedback">{{ $errors->first('organizer', $post->organizer) }}</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group{{ $errors->has('venue') ? ' is-invalid' : '' }}">
						<label for="field-venue">{{ __('exhibition.venue') }}</label>
						<input type="text" class="form-control" id="field-venue" name="venue" value="{{ old('venue', $post->venue) }}">
						<div class="invalid-feedback">{{ $errors->first('venue') }}</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group{{ $errors->has('country_id') ? ' is-invalid' : '' }}">
						<label for="field-country_id">{{ __('general.country') }}</label>
						<select class="js-select2 form-control" id="field-country_id" name="country_id" style="width: 100%;" data-placeholder="{{ __('general.choose') }}">
							<option></option>
							@foreach($countries as $country)
							<option value="{{ $country->id }}" {{ old('country_id', $post->country_id) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
							@endforeach
						</select>
						<div class="invalid-feedback">{{ $errors->first('country_id') }}</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group{{ $errors->has('featured') ? ' is-invalid' : '' }}">
						<label for="field-featured">{{ __('exhibition.featured') }}</label>
						<div>
							<label class="css-control css-control-primary css-checkbox">
								<input type="hidden" class="css-control-input" name="featured" value="0">
								<input type="checkbox" class="css-control-input" id="field-featured" value="1" name="featured" {{ old('featured', $post->featured) == 1 ? 'checked' : '' }}>
								<span class="css-control-indicator"></span> {{ __('exhibition.featured_detail') }}
							</label>
						</div>
						<div class="invalid-feedback">{{ $errors->first('featured') }}</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group{{ $errors->has('calendar') ? ' is-invalid' : '' }}">
						<label for="field-calendar">{{ __('exhibition.calendar') }}</label>
						<div>
							<label class="css-control css-control-primary css-checkbox">
								<input type="hidden" class="css-control-input" name="calendar" value="0">
								<input type="checkbox" class="css-control-input" id="field-calendar" value="1" name="calendar" {{ old('calendar', $post->calendar) == 1 ? 'checked' : '' }}>
								<span class="css-control-indicator"></span> {{ __('exhibition.calendar') }}
							</label>
						</div>
						<div class="invalid-feedback">{{ $errors->first('featured') }}</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group{{ $errors->has('directory') ? ' is-invalid' : '' }}">
						<label for="field-directory">{{ __('exhibition.directory') }}</label>
						<div>
							<label class="css-control css-control-primary css-checkbox">
								<input type="hidden" class="css-control-input" name="directory" value="0">
								<input type="checkbox" class="css-control-input" id="field-directory" value="1" name="directory" {{ old('directory', $post->directory) == 1 ? 'checked' : '' }}>
								<span class="css-control-indicator"></span> {{ __('exhibition.directory') }}
							</label>
						</div>
						<div class="invalid-feedback">{{ $errors->first('directory') }}</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group{{ $errors->has('color') ? ' is-invalid' : '' }}">
						<label for="field-color">{{ __('exhibition.color') }}</label>
						<div class="js-colorpicker input-group">
							<input type="text" class="form-control" name="color" value="{{ old('color', $post->color) }}">
							<span class="input-group-addon"><i></i></span>
						</div>
						<div class="invalid-feedback">{{ $errors->first('color') }}</div>
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
<script type="text/javascript" src="{{ asset('plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script type="text/javascript">
	$(function(){
		Codebase.helpers(['datepicker', 'colorpicker']);

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
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
@endpush
