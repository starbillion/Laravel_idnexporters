@extends('_layouts.backend')
@section('title', __('news.edit'))

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
									{{ __('news.change_image') }}
								</a>
								<a class="btn btn-sm btn-block btn-alt-danger min-width-75" onclick="event.preventDefault(); Codebase.loader('show'); document.getElementById('form-delete').submit();">
									{{ __('news.delete_image') }}
								</a>
								<form id="form-delete" method="post" action="{{ route('admin.news.media.destroy', $post->id) }}" class="d-none">
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
									{{ __('news.upload_image') }}
								</a>
							</div>
						</div>
						@endif

						<form id="form-upload" method="post" action="{{ route('admin.news.media.store', $post->id) }}" class="d-none" enctype="multipart/form-data">
							{{ csrf_field() }}
							<input type="hidden" name="type" value="featured_image">
							<input id="upload-featured_image" type="file" name="featured_image" onchange="event.preventDefault(); Codebase.loader('show'); document.getElementById('form-upload').submit();" />
						</form>

					</div>
				</div>
			</div>
			<span class="text-muted d-block mt-10">{{ __('news.image_placeholder') }}</span>
		</div>
	</div>
</div>

<div class="block block-bordered">
	<form action="{{ route('admin.news.update', $post->id) }}" method="post">
		{{ csrf_field() }}
		<input name="_method" type="hidden" value="PUT">
		<div class="block-content block-content-full">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group{{ $errors->has('title') ? ' is-invalid' : '' }}">
						<label for="field-title">{{ __('news.title') }}</label>
						<input type="text" class="form-control" id="field-title" name="title" value="{{ old('title', $post->title) }}">
						<div class="invalid-feedback">{{ $errors->first('title') }}</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group{{ $errors->has('slug') ? ' is-invalid' : '' }}">
						<label for="field-slug">{{ __('news.slug') }}</label>
						<div class="input-group">
  							<span class="input-group-addon {{ $errors->has('slug') ? 'bg-danger text-white border-danger' : '' }}">{{ preg_replace("(^https?://)", "", url('/news')) }}/</span>
							<input type="text" class="form-control" id="field-slug" name="slug" value="{{ old('slug', $post->slug) }}">
						</div>
						<div class="invalid-feedback">{{ $errors->first('slug') }}</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group{{ $errors->has('body') ? ' is-invalid' : '' }}">
						<label for="field-body">{{ __('news.body') }}</label>
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
