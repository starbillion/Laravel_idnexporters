@foreach($posts as $post)
<a class="block mb-20 block-bordered" href="{{ route('public.news.show', $post->slug) }}">
	<div class="bg-gray-light">
		@if($post->getFirstMediaUrl('featured_image', 'crop'))
		<img class="img-fluid" src="{{ $post->getFirstMediaUrl('featured_image', 'crop') }}">
		@else
		<img class="img-fluid" src="{{ asset('img/noimage-news.png') }}">
		@endif
	</div>
	<div class="block-content block-content-full">
		<h6 class="mb-0">{{ $post->title }}</h6>
		<span class="text-muted"><small>{{ $post->created_at->diffforhumans() }}</small></span>
	</div>
</a>

@endforeach
