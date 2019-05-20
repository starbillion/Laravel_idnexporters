@if($config['search']['status'] or $config['add']['status'] or $config['sorts'] or $config['filters'])
<div class="block border-t border-l border-r">

	@if($config['search']['status'] or $config['add']['status'])
	<div class="block-content border-b bg-white">
		<div class="d-flex flex-row">
			@if($config['search']['status'])
			<div class="{{ $config['add']['status'] ? 'w-75' : 'w-100' }}">
				<form method="get" class="mb-20" action="{{ $config['search']['route'] }}">
					<div class="input-group">
						<input type="text" class="form-control" name="q" placeholder="{{ __('general.search') }}.." value="{{ request()->input('q') }}">
						<span class="input-group-btn">
							<button class="btn btn-secondary" type="submit"><i class="si si-magnifier"></i></button>
						</span>
					</div>
				</form>
			</div>
			@endif
			@if($config['add']['status'])
			<div class="{{ $config['search']['status'] ? 'w-25' : 'w-100' }} text-right">
				<a class="btn btn-primary" href="{{ $config['add']['route'] }}">
					{{ __('general.add') }}
				</a>
			</div>
			@endif
		</div>
	</div>
	@endif

	@if($config['sorts'] or $config['filters'])
	<div class="block-content border-b block-content-full bg-gray-lighter">
		<div class="d-flex justify-content-start">
			@if($config['sorts'])
			<div class="btn-group mr-5">
				<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">{{ __('general.sort_by') }}</button>
				<div class="dropdown-menu">
					@if(request()->segment(5) =='edit')
						@foreach($config['sorts'] as $input => $lang)
						<a class="{{ request()->input('sort') == $input ? 'active' : '' }} dropdown-item"
							href="{{
								route(
									'admin.product.category.edit',
									array_merge(['id' => request()->segment(4)], request()->query(), ['sort' => $input, 'page' => null])
								)
							}}">
							{{ $lang }}
						</a>
						@endforeach
					@else
						@foreach($config['sorts'] as $input => $lang)
						<a class="{{ request()->input('sort') == $input ? 'active' : '' }} dropdown-item" href="{{ route(Route::currentRouteName(), array_merge(request()->query(), ['sort' => $input, 'page' => null])) }}">
							{{ $lang }}
						</a>
						@endforeach
					@endif
				</div>
			</div>
			@endif

			@if($config['filters'])
			<div class="btn-group">
				@foreach($config['filters'] as $filter)
				<div class="btn-group">
					<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">{{ $filter['name'] }}</button>
					<div class="dropdown-menu">
						@foreach($filter['data'] as $input => $lang)
						<a class="{{ request()->input($filter['input']) == $input ? 'active' : '' }} dropdown-item" href="{{ route(Route::currentRouteName(), array_merge(request()->query(), [$filter['input'] => $input, 'page' => null])) }}">
							{{ $lang }}
						</a>
						@endforeach
					</div>
				</div>
				@endforeach
			</div>
			@endif

			@if(request()->query())
			<div class="ml-auto">
				@if(request()->segment(5) =='edit')
				<a class="btn btn-outline-danger" href="{{ route('admin.product.category.edit', request()->segment(4)) }}">
					{{ __('general.reset') }}
				</a>
				@else
				<a class="btn btn-outline-danger" href="{{ route(Route::currentRouteName()) }}">
					{{ __('general.reset') }}
				</a>
				@endif
			</div>
			@endif
		</div>
	</div>
	@endif

</div>
@endif
