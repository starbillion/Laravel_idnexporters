@extends('_layouts.backend')
@section('title', __('exhibition.add'))

@section('content')
<div class="block block-bordered">
	<form action="{{ route('admin.exhibition.store') }}" method="post">
		{{ csrf_field() }}
		<div class="block-content block-content-full">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group{{ $errors->has('title') ? ' is-invalid' : '' }}">
						<label for="field-title">{{ __('exhibition.title') }}</label>
						<input type="text" class="form-control" id="field-title" name="title" value="{{ old('title') }}">
						<div class="invalid-feedback">{{ $errors->first('title') }}</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group{{ $errors->has('slug') ? ' is-invalid' : '' }}">
						<label for="field-slug">{{ __('exhibition.slug') }}</label>
						<div class="input-group">
							<span class="input-group-addon {{ $errors->has('slug') ? 'bg-danger text-white border-danger' : '' }}">{{ preg_replace("(^https?://)", "", url('/exhibition')) }}/</span>
							<input type="text" class="form-control" id="field-slug" name="slug" value="{{ old('slug') }}">
						</div>
						<div class="invalid-feedback">{{ $errors->first('slug') }}</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group{{ ($errors->has('start_at') or $errors->has('ending_at')) ? ' is-invalid' : '' }}">
						<label for="field-date">{{ __('exhibition.date') }}</label>
						<div class="input-group">
							<input type="text" class="js-datepicker form-control" id="field-start_at" name="start_at" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="{{ old('start_at') }}">
							<span class="input-group-addon {{ ($errors->has('start_at') or $errors->has('ending_at')) ? 'bg-danger border-danger text-white' : '' }}">Until</span>
							<input type="text" class="js-datepicker form-control" id="field-ending_at" name="ending_at" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="{{ old('ending_at') }}">
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
						<input type="text" class="form-control" id="field-organizer" name="organizer" value="{{ old('organizer') }}">
						<div class="invalid-feedback">{{ $errors->first('organizer') }}</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group{{ $errors->has('venue') ? ' is-invalid' : '' }}">
						<label for="field-venue">{{ __('exhibition.venue') }}</label>
						<input type="text" class="form-control" id="field-venue" name="venue" value="{{ old('venue') }}">
						<div class="invalid-feedback">{{ $errors->first('venue') }}</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group{{ $errors->has('country_id') ? ' is-invalid' : '' }}">
						<label for="field-country_id">{{ __('general.country') }}</label>
						<select class="js-select2 form-control" id="field-country_id" name="country_id" style="width: 100%;" data-placeholder="{{ __('general.choose') }}">
							<option></option>
							@foreach($countries as $country)
							<option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
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
								<input type="checkbox" class="css-control-input" id="field-featured" name="featured" value="1" {{ old('featured') == 1 ? 'checked' : '' }}>
								<span class="css-control-indicator"></span> {{ __('exhibition.featured') }}
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
								<input type="checkbox" class="css-control-input" id="field-calendar" name="calendar" value="1" {{ old('calendar') == 1 ? 'checked' : '' }}>
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
								<input type="checkbox" class="css-control-input" id="field-directory" name="directory" value="1" {{ old('directory') == 1 ? 'checked' : '' }}>
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
							<input type="text" class="form-control" name="color" value="{{ old('color', '#91c2f7') }}">
							<span class="input-group-addon"><i></i></span>
						</div>
						<div class="invalid-feedback">{{ $errors->first('color') }}</div>
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
