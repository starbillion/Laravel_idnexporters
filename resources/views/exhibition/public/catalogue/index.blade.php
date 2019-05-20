@extends('_layouts.frontend')
@section('title', __('general.exhibition_catalogue'))

@section('content')
<div class="bg-pulse">
	<div class="content content-full content-top text-center overflow-hidden">
		<h1 class="h2 font-w700 text-white mb-10 js-appear-enabled animated fadeInDown" data-toggle="appear" data-class="animated fadeInDown">
			{{ __('general.exhibition_catalogue') }}
		</h1>

		@if(request()->input('continent'))
		<h3 class="h4 font-w700 text-white mb-30 js-appear-enabled animated fadeInDown" data-toggle="appear" data-class="animated fadeInDown">
			{{ $continent->name }}
		</h3>
		@else
		<h3 class="h4 font-w700 text-white mb-30 js-appear-enabled animated fadeInDown" data-toggle="appear" data-class="animated fadeInDown">
			{{ __('general.global') }}
		</h3>
		@endif
	</div>
</div>

<div class="content content-full pt-50 pb-50">

	<div class="block block-bordered">
		<div class="block-content">
			<ul class="nav nav-pills nav-fill push">
				<li class="nav-item">
					<a class="nav-link {{ request()->input('continent') == '' ? 'active' : '' }}" href="{{ route('public.exhibition.catalogue.index') }}">{{ __('general.global') }}</a>
				</li>
				@foreach($continents as $continent)
				<li class="nav-item">
					<a class="nav-link {{ request()->input('continent') == $continent->code ? 'active' : '' }}" href="{{ route('public.exhibition.catalogue.index', ['continent' => $continent->code]) }}">{{ $continent->name }}</a>
				</li>
				@endforeach
			</ul>
		</div>
	</div>

	<hr class="mb-20">

	@if(count($posts))
		<div class="row">
			@foreach($posts as $post)
			<div class="col-md-4">
				<a class="block block-bordered ribbon" href="{{ route('public.exhibition.catalogue.show', $post->slug) }}">
					<div class="bg-gray-light border-b">
						@if($post->getFirstMediaUrl('featured_image', 'crop'))
						<img class="img-fluid" src="{{ $post->getFirstMediaUrl('featured_image', 'crop') }}">
						@else
						<img class="img-fluid" src="{{ asset('img/noimage-exhibition.png') }}">
						@endif
					</div>
					<div class="block-content block-content-full">
						<h6 class="mb-0 text-truncate">{{ $post->title }}</h6>

						<div class="row justify-content-between">
							<div class="col-md-6">
								<small class="text-muted">
									<i class="si si-calendar"></i>&nbsp;
									{{ $post->start_at ? $post->start_at->format('d-m-Y') : __('exhibition.date_not_found') }}
								</small>
							</div>
							<div class="col-md-6 text-right">
								<small class="text-muted">
									<i class="si si-people"></i>&nbsp;
									{{ $post->exhibitors_count }} {{ str_plural(__('exhibition.participant'), $post->exhibitors_count) }}
								</small>
							</div>
						</div>
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
	@else
	<div class="alert alert-info" role="alert">
		{{ __('exhibition.empty') }}
	</div>
	@endif

</div>
@endsection
