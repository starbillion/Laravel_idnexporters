@foreach($posts as $post)
<a class="block mb-20 block-bordered" href="{{ route('public.exhibition.show', $post->slug) }}">
	<div class="bg-gray-light">
		@if($post->getFirstMediaUrl('featured_image', 'crop'))
		<img class="img-fluid" src="{{ $post->getFirstMediaUrl('featured_image', 'crop') }}">
		@else
		<img class="img-fluid" src="{{ asset('img/noimage-exhibition.png') }}">
		@endif
	</div>
	<div class="block-content block-content-full">
		<h6 class="mb-0">{{ $post->title }}</h6>
		<span class="text-muted"><small><i class="si si-calendar"></i>&nbsp; {{ $post->start_at ? $post->start_at->format('d-m-Y') : __('exhibition.date_not_found') }}</small></span>
	</div>
</a>

@endforeach
