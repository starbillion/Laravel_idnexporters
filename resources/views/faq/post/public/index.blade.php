@extends('_layouts.frontend')
@section('title', __('general.faqs'))

@section('content')
<div class="bg-pulse">
	<div class="content content-full content-top text-center overflow-hidden">
		<h1 class="h2 font-w700 text-white mb-30 js-appear-enabled animated fadeInDown" data-toggle="appear" data-class="animated fadeInDown">
			{{ __('general.faqs') }}
		</h1>
	</div>
</div>

<div class="content content-full pt-50 pb-50">
	<div class="row">
		<div class="col-md-9">

			@foreach($faq as $category)
			<div class="block">
				<div class="block-header block-header-default">
					<h3 class="block-title">
						<strong>{{ $category->name }}</strong>
					</h3>
				</div>
				<div class="block-content block-content-full">
					<div id="faq1" role="tablist" aria-multiselectable="true">

						@foreach($category->posts as $post)
						<div class="block block-bordered block-rounded mb-5">
							<div class="block-header" role="tab" id="faq1_h1">
								<a class="font-w600 text-body-color-dark" data-toggle="collapse" data-parent="#faq1" href="#faq-{{ $post->id }}">{{ $post->question }}</a>
							</div>
							<div id="faq-{{ $post->id }}" class="collapse" role="tabpanel">
								<div class="block-content block-content-full border-t">
									{!! $post->answer !!}
								</div>
							</div>
						</div>
						@endforeach

					</div>
				</div>
			</div>
			@endforeach
		</div>

		<div class="col-md-3">
			@widget('Wwtp')
			@widget('ExchangeRate')
		</div>
	</div>
</div>
@endsection
