@extends('_layouts.frontend')
@section('title', $post->title)

@section('content')
<div class="content content-full pt-50 pb-50">
	<div class="block block-bordered">
		<div class="block-content">
			<ul class="nav nav-pills nav-fill push">
				<li class="nav-item">
					<a class="nav-link" href="{{ route('public.exhibition.catalogue.index') }}">{{ __('general.global') }}</a>
				</li>
				@foreach($continents as $continent)
				<li class="nav-item">
					<a class="nav-link {{ $post->country->continent->code == $continent->code ? 'active' : '' }}" href="{{ route('public.exhibition.catalogue.index', ['continent' => $continent->code]) }}">{{ $continent->name }}</a>
				</li>
				@endforeach
			</ul>
		</div>
	</div>

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
				</div>

				<div class="block-content">
					@widget('Exhibition\Navigation', ['post' => $post])
				</div>

				<div class="block-content px-30">
					{!! $post->body !!}
				</div>
			</div>
		</div>

		<div class="col-md-3">

			@if($post->getFirstMediaUrl('featured_image', 'full'))
			<img class="img-fluid mb-20" src="{{ $post->getFirstMediaUrl('featured_image', 'full') }}">
			@endif

			@if($post->exhibitors_count > 0)
			<div class="block block-bordered bg-danger text-white">
				<div class="block-content">
					<div class="text-white h5">
						{{ $post->exhibitors_count }} {{ str_plural(__('exhibition.participant'), $post->exhibitors_count) }}
					</div>
				</div>
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
		</div>
	</div>
</div>
@endsection
