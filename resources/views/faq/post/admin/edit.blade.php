@extends('_layouts.backend')
@section('title', __('faq.post_data.edit'))

@section('content')
<div class="block block-bordered">
	<form action="{{ route('admin.faq.post.update', $post->id) }}" method="post">
		{{ csrf_field() }}
		<input name="_method" type="hidden" value="PUT">
		<div class="block-content block-content-full">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group{{ $errors->has('question') ? ' is-invalid' : '' }}">
						<label for="field-question">{{ __('faq.post_data.question') }}</label>
						<input type="text" class="form-control" id="field-question" name="question" value="{{ old('question', $post->question) }}">
						<div class="invalid-feedback">{{ $errors->first('question') }}</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group{{ $errors->has('category_id') ? ' is-invalid' : '' }}">
						<label for="field-category_id">{{ __('product/post.currency') }}</label>
						<select class="js-select2 form-control" id="field-category_id" name="category_id" style="width: 100%;" data-placeholder="{{ __('general.choose') }}">
							<option></option>
							@foreach($categories as $category)
							<option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
							@endforeach
						</select>
						<div class="invalid-feedback">{{ $errors->first('category_id') }}</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group{{ $errors->has('answer') ? ' is-invalid' : '' }}">
						<label for="field-answer">{{ __('faq.post_data.answer') }}</label>
						<textarea id="field-answer" class="form-control" name="answer" rows="6">{{ old('answer', $post->answer) }}</textarea>
						<div class="invalid-feedback">{{ $errors->first('answer') }}</div>
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
		$('#field-answer').summernote({
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
