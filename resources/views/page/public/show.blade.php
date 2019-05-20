@extends('_layouts.frontend')
@section('title', $page->title)

@section('content')
<div class="bg-pulse">
	<div class="content content-full content-top text-center overflow-hidden">
		<h1 class="h2 font-w700 text-white mb-30 js-appear-enabled animated fadeInDown" data-toggle="appear" data-class="animated fadeInDown">
			{{ $page->title }}
		</h1>
	</div>
</div>

<div class="content content-full pt-50 pb-50">
	<div class="row">
		<div class="col-md-9">
			<div class="pb-20 block block-bordered">
				<div class="block-content">
					{!! $page->body !!}
				</div>
			</div>
		</div>

		<div class="col-md-3">
			@widget('Wwtp')
			@widget('ExchangeRate')
		</div>
	</div>
</div>
@endsection
