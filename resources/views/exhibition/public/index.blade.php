@extends('_layouts.frontend')
@section('title', __('general.exhibition_featured'))

@section('content')
<div class="bg-pulse">
	<div class="content content-full content-top text-center overflow-hidden">
		<h1 class="h2 font-w700 text-white mb-30 js-appear-enabled animated fadeInDown" data-toggle="appear" data-class="animated fadeInDown">
			{{ __('general.exhibition_featured') }}
		</h1>
	</div>
</div>

<div class="content content-full pt-50 pb-50">
	<div class="row">
		<div class="col-md-9">
			<div class="row">

				@foreach($posts as $post)
				<div class="col-md-4">
					<a class="block block-bordered ribbon" href="{{ route('public.exhibition.show', $post->slug) }}">
						<div class="bg-gray-light border-b">
							@if($post->getFirstMediaUrl('featured_image', 'crop'))
		                    <img class="img-fluid" src="{{ $post->getFirstMediaUrl('featured_image', 'crop') }}">
		                    @else
		                    <img class="img-fluid" src="{{ asset('img/noimage-exhibition.png') }}">
		                    @endif
						</div>
						<div class="block-content block-content-full">
							<h6 class="mb-0 text-truncate">{{ $post->title }}</h6>
							<span class="text-muted"><small><i class="si si-calendar"></i>&nbsp; {{ $post->start_at ? $post->start_at->format('d-m-Y') : __('exhibition.date_not_found') }}</small></span>
						</div>
					</a>
				</div>
				@endforeach

			</div>

			@if($posts->hasPages())
			<div class="block block-bordered">
				<div class="block-content">
					{!! $posts->appends(request()->query())->render() !!}
				</div>
			</div>
			@endif
		</div>

		<div class="col-md-3">
			@widget('Wwtp')
			@widget('LatestExhibition')
		</div>
	</div>
</div>
@endsection
