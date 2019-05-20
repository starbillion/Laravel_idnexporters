@extends('_layouts.frontend')
@section('title', $post->title)

@section('content')
<div class="content content-full pt-50 pb-50">
	<div class="row">
		<div class="col-md-9">
			<div class="pb-20 block block-bordered">
				<div class="block-content">
					<div class="mb-20">
						<h3 class="mb-5">{{ $post->title }}</h3>
						<h4 class="text-muted mb-0">
							<small><i class="si si-calendar"></i>&nbsp;
								{{ $post->start_at ? $post->start_at->format('d-m-Y') : __('exhibition.date_not_found') }}
								{{ ($post->ending_at and $post->ending_at > $post->start_at) ? '- ' . $post->ending_at->format('d-m-Y') : '' }}
							</small>
						</h4>

						@if($post->country)
						<h4 class="text-muted mb-0">
							<small><i class="si si-map"></i>&nbsp;
								{{ $post->country->name }}
							</small>
						</h4>
						@endif

						@if($post->organizer)
						<h4 class="text-muted mb-0">
							<small><i class="si si-info"></i>&nbsp;
								{{ $post->organizer }}
							</small>
						</h4>
						@endif
					</div>

					@widget('ShareThis')

					{!! $post->body !!}
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<a href="{{ route('public.exhibition.calendar.index', ['position' => $post->start_at->format('Y-m')]) }}" class="btn btn-primary btn-block mb-20">
				<i class="si si-arrow-left mr-10"></i>
				Back to Calendar
			</a>

			@if($post->getFirstMediaUrl('featured_image', 'full'))
			<div class="border mb-20">
				<img class="img-fluid" src="{{ $post->getFirstMediaUrl('featured_image', 'full') }}">
			</div>
			@endif

			@if($post->venue)
			<div class="block block-bordered">
				<div class="block-header block-header-default">
					<h3 class="block-title"><i class="si si-map"></i>&nbsp; {{ __('exhibition.venue') }}</h3>
				</div>
				<div class="embed-responsive embed-responsive-1by1 m-0 p-0">
					<iframe width="600" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key={{ config('services.google_map.key') }}&q={{ trim(preg_replace('/\s+/', ' ', $post->venue)) }}">
					</iframe>
				</div>
			</div>
			@endif

			@widget('LatestExhibition')
		</div>
	</div>
</div>
@endsection
