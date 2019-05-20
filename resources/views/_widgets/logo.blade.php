<a href="{{ route($url) }}">
	@if($type == 'text')
	<span class="font-size-xl text-uppercase text-dual-primary-dark">{{ config('app.name') }}</span>
	@else
	<img style="height: 45px;" src="{{ asset($image_source) }}" alt="{{ config('app.name') }}">
	@endif
</a>
