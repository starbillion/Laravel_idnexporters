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
								{{ $post->date ? $post->date->format('d-m-Y') : __('exhibition.date_not_found') }}
							</small>
						</h4>

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
					<div id="participants" role="tablist" aria-multiselectable="true">

						<ul class="list-inline mb-20 py-0">
							<li class="list-inline-item border-r pr-10 mr-5">
								<a class="" href="{{ route('public.exhibition.catalogue.exhibitors', ['slug' => $post->slug]) }}">
									<small class="{{ request()->input('identity') == '' ? 'font-weight-bold text-danger' : '' }}">{{ __('general.all') }}</small>
								</a>
							</li>

							@foreach(range('A', 'Z') as $char)
							<li class="list-inline-item border-r pr-10 mr-5">
								<a href="{{ route('public.exhibition.catalogue.exhibitors', ['slug' => $post->slug, 'identity' => ucfirst($char)]) }}">
									<small class="{{ request()->input('identity') == ucfirst($char) ? 'font-weight-bold text-danger' : '' }}">{{ ucfirst($char) }}</small>
								</a>
							</li>
							@endforeach

							<li class="list-inline-item">
								<a href="{{ route('public.exhibition.catalogue.exhibitors', ['slug' => $post->slug, 'identity' => 'number']) }}">
									<small class="{{ request()->input('identity') == 'number' ? 'font-weight-bold text-danger' : '' }}">0-9</small>
								</a>
							</li>
						</ul>

						<div class="mb-20">
							<form method="get">
								<div class="row gutters-tiny">
									<div class="col-md-4">
		                                <div class="form-group{{ $errors->has('category') ? ' is-invalid' : '' }}">
		                                    <div class="form-group{{ $errors->has('category') ? ' is-invalid' : '' }}">
		                                        <select class="form-control" id="field-category" name="category" style="width: 100%;" data-allow-clear="true">
		                                            <option></option>
		                                            @if($ca = request()->input('category'))
		                                                <option value="{{ $ca }}" selected>
		                                                    @php
		                                                    $s = \App\ProductCategory::ancestorsAndSelf($ca)->pluck('name');

		                                                    echo $s[0] . ' / ' . $s[1] . ' / ' . $s[2];
		                                                    @endphp
		                                                </option>
		                                            @endif
		                                        </select>

		                                        @push('script')
		                                        <script type="text/javascript">
		                                            $(function () {
		                                                pageSize = 50
		                                                items = [
		                                                    @foreach($categories as $c1)
		                                                        @foreach($c1->children as $c2)
		                                                            @foreach($c2->children as $c3)
		                                                                {
		                                                                    id: {{ $c3->id }},
		                                                                    text : "{!! $c1->name !!} / {!! $c2->name !!} / {!! $c3->name !!}"
		                                                                },
		                                                            @endforeach
		                                                        @endforeach
		                                                    @endforeach
		                                                ]

		                                                $.fn.select2.amd.require(["select2/data/array", "select2/utils"], function (ArrayData, Utils) {
		                                                    function CustomData($element, options) {
		                                                        CustomData.__super__.constructor.call(this, $element, options);
		                                                    }

		                                                    Utils.Extend(CustomData, ArrayData);

		                                                    CustomData.prototype.query = function (params, callback) {
		                                                        params.page = params.page || 1;
		                                                        var data = {};
		                                                        data.results = items.slice((params.page - 1) * pageSize, params.page * pageSize);
		                                                        data.pagination = {};
		                                                        data.pagination.more = params.page * pageSize < items.length;
		                                                        callback(data, params);
		                                                    };

		                                                    $(document).ready(function () {
		                                                        var me = $("#field-category").select2({
		                                                            ajax: {},
		                                                            dataAdapter: CustomData,
		                                                            placeholder: '{{ __('general.category') }}',
		                                                        });
		                                                        me.on('select2:selecting', function(){
		                                                            if($("#field-category").val().length>2){
		                                                                $("#field-category").val($("#field-category").val().slice(0,2));

		                                                                console.log($("#field-category").val())
		                                                            }
		                                                        });
		                                                    });
		                                                });
		                                            });
		                                        </script>
		                                        @endpush
		                                        <div class="invalid-feedback">{{ $errors->first('category') }}</div>
		                                    </div>
		                                </div>
		                            </div>
									<div class="col-md-3">
										<div class="form-group">
											<select class="js-select2 form-control" name="country" style="width: 100%;" data-placeholder="Country" data-allow-clear="true">
												<option></option>
												@foreach($countries as $country)
												<option value="{{ $country->id }}" {{ request()->input('country') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<input type="text" class="form-control" placeholder="Booth" name="q" value="{{ request()->input('q') }}">
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<button type="submit" class="btn btn-primary btn-block text-truncate">{{ __('general.search') }}</button>
										</div>
									</div>
								</div>
							</form>
						</div>

						<hr>

						@foreach($exhibitors as $exhibitor)
						<div class="block block-bordered block-rounded mb-5">
							<div class="block-header d-flex justify-content-between" role="tab" id="faq1_h1">
								<a class="w-25 text-truncate font-w600 text-body-color-dark" data-toggle="collapse" data-parent="#participants" href="#participant-{{ $exhibitor->id }}">
									<span>{{ $exhibitor->name }}</span>
								</a>
								<span class="w-25 text-center">{{ $exhibitor->country->name }}</span>
								<span class="w-25 text-center">Booth : {{ $exhibitor->pivot->booth }}</span>
								<a class="w-25 font-w600 text-body-color-dark text-right" data-toggle="collapse" data-parent="#participants" href="#participant-{{ $exhibitor->id }}">
									<span><i class="si si-arrow-down"></i></span>
								</a>
							</div>
							<div id="participant-{{ $exhibitor->id }}" class="collapse" role="tabpanel">
								<div class="block-content block-content-full border-t">
									{!! $exhibitor->description !!}

									<div class="m-10 text-right">
										<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal-exhibitor-{{ $exhibitor->id }}">{{ __('exhibitor.view_profile') }}</a>

										@push('modal')
										<div class="modal fade" id="modal-exhibitor-{{ $exhibitor->id }}" tabindex="-1" role="dialog" aria-hidden="true">
											<div class="modal-dialog modal-lg" role="document">
												<div class="modal-content">
													<div class="block block-themed block-transparent mb-0">
														<div class="block-header bg-primary-dark">
															<h3 class="block-title">{{ __('general.exhibitor') }}</h3>
															<div class="block-options">
																<button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
																	<i class="si si-close"></i>
																</button>
															</div>
														</div>
														<div class="block-content block-content-full">
															<div class="row">
																<div class="col-md-4">
																	@if($exhibitor->getFirstMediaUrl('logo'))
																		<img class="img-thumbnail" src="{{ asset($exhibitor->getFirstMediaUrl('logo', 'thumb')) }}" alt="{{ $exhibitor->name }}">
																	@else
																		<img class="img-thumbnail" src="{{ asset('img/noimage.png') }}" alt="{{ $exhibitor->name }}">
																	@endif
																</div>
																<div class="col-md-8">
																	<div class="h5">{{ $exhibitor->name }}</div>

																	{!! $exhibitor->description !!}

																	<span class="d-block mt-20">Booth : {{ $exhibitor->pivot->booth }}</span>
																</div>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
													</div>
												</div>
											</div>
										</div>
										@endpush

									</div>
								</div>
							</div>
						</div>
						@endforeach
					</div>
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
