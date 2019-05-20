@extends('_layouts.frontend')
@section('title', __('general.news'))

@section('content')
<div class="bg-pulse">
	<div class="content content-full content-top text-center overflow-hidden">
		<h1 class="h2 font-w700 text-white mb-30 js-appear-enabled animated fadeInDown" data-toggle="appear" data-class="animated fadeInDown">
			{{ __('general.news') }}
		</h1>
	</div>
</div>

<div class="content content-full pt-50 pb-50">
	<div class="row">
		<div class="col-md-9">
			<div class="row">

				@foreach($posts as $post)
				<div class="col-md-6">
					<a class="block block-bordered" href="{{ route('public.news.show', $post->slug) }}">
						<div class="bg-gray-light">
							@if($post->getFirstMediaUrl('featured_image', 'crop'))
		                    <img class="img-fluid" src="{{ $post->getFirstMediaUrl('featured_image', 'crop') }}">
		                    @else
		                    <img class="img-fluid" src="{{ asset('img/noimage-news.png') }}">
		                    @endif
						</div>
						<div class="block-content block-content-full">
							<h4 class="mb-0">{{ $post->title }}</h4>
							<span class="text-muted"><small>{{ $post->created_at->diffforhumans() }}</small></span>
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
			@widget('ExchangeRate')
			@widget('LatestNews')
		</div>
	</div>
</div>
@endsection
