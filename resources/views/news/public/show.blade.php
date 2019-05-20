@extends('_layouts.frontend')
@section('title', $post->title)

@section('content')
<div class="content content-full pt-50 pb-50">
	<div class="row">
		<div class="col-md-9">
			<div class="pb-20 block block-bordered">
				@if($post->getFirstMediaUrl('featured_image', 'full'))
				<img class="img-fluid" src="{{ $post->getFirstMediaUrl('featured_image', 'full') }}">
				@endif
				<div class="block-content">
					<div class="mb-20">
						<h4 class="mb-0">{{ $post->title }}</h4>
						<span class="text-muted"><small>{{ $post->created_at->diffforhumans() }}</small></span>
					</div>
					@widget('ShareThis')

					{!! $post->body !!}
				</div>
			</div>
		</div>

		<div class="col-md-3">
			@widget('Wwtp')
			@widget('ExchangeRate')
			@widget('LatestNews')
		</div>
	</div>
</div>
@endsection
