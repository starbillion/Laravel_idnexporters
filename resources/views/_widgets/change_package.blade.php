@php
$requested 	= \App\PlanRequest::where('user_id', Auth::id())->first();
$current    = userPackage();
@endphp

@push('script')
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
@endpush

@if($requested)
<div class="modal fade" id="package-process" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="block mb-0">
				<div class="block-header bg-gray-lighter">
					<h3 class="block-title">General</h3>
					<div class="block-options">
						<button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
							<i class="si si-close"></i>
						</button>
					</div>
				</div>
				<div class="block-content block-content-full">
					{{ __('package.notification_store_success') }}<br>
        			{!! __('package.notification_cancel') !!}
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
@else


@foreach($plans as $plan)
<div class="modal fade" id="package-{{ $plan->id }}-request" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="block mb-0">
                <div class="block-header bg-gray-lighter">
                    <h3 class="block-title">{{ __('package.' . $type . '.' . $plan->name . '.name') }}</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>

                <form action="{{ route('member.package.store') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{ $plan->id }}" name="package">
                    @if($plan->promo)
                    <input type="hidden" class="field-promocode" name="promo">
                    @endif
                    <div class="block-content block-content-full">
                        <div class="row ">
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>Product</th>
                                                <th class="text-center">Unit Price</th>
                                                <th class="text-center">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>
                                                    {{ __('package.' . $type . '.' . $plan->name . '.name') }}
                                                    @if($plan->interval_count != 20)
                                                    <span class="d-block font-w400">{{ $plan->interval_count }} {{ str_plural(__('package.' . $plan->interval), $plan->interval_count) }}</span>
                                                    @endif
                                                </th>
                                                <th class="text-right">
                                                    {{ $plan->currency->code }}
                                                    {{ number_format($plan->price) }}
                                                </th>
                                                <th class="text-right">
                                                    {{ $plan->currency->code }}
                                                    {{ number_format($plan->price) }}
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                @if($plan->promo)
                                <div id="promo-{{ $plan->name }}" data-children=".p-item">
                                    <div class="p-item">
                                        <a data-toggle="collapse" data-parent="#promo-{{ $plan->name }}" href="#promo-{{ $plan->name }}-content">
                                            Have a promotional code?
                                        </a>
                                        <div id="promo-{{ $plan->name }}-content" class="collapse">
                                            <div class="mb-3">
                                                <div id="form-{{ $plan->name }}-check" class="input-group">
                                                    <input id="pc-{{ $plan->name }}" type="text" class="form-control" placeholder="Enter promocode here">
                                                    <span class="input-group-btn">
                                                        <button id="pc-{{ $plan->name }}-submit" class="btn btn-secondary" type="button">Submit</button>
                                                    </span>
                                                </div>
                                                <div id="form-{{ $plan->name }}-clear" class="input-group d-none">
                                                    <input type="text" class="form-control" disabled>
                                                    <span class="input-group-btn">
                                                        <button id="pc-{{ $plan->name }}-clear" class="btn btn-secondary" type="button">Remove</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @push('script')
                                    <script type="text/javascript">
                                        $(function(){
                                            $('#pc-{{ $plan->name }}-submit').click(function(){
                                                check_promocode_{{ $plan->name }}();
                                            })

                                            function check_promocode_{{ $plan->name }}(){
                                                $.ajax({
                                                    method: "GET",
                                                    url: '{{ route('ajax.coupon.show', null) }}/' + $('#pc-{{ $plan->name }}').val(),
                                                    error: function(jqXHR, textStatus, errorThrown){
                                                        $('#pc-{{ $plan->name }}').addClass('is-invalid');
                                                        $('#pc-{{ $plan->name }}-submit').removeClass('btn-secondary').addClass('btn-danger');
                                                    },
                                                    success: function (data, textStatus, jqXHR){
                                                        $('#form-{{ $plan->name }}-check').addClass('d-none');
                                                        $('#form-{{ $plan->name }}-clear').removeClass('d-none');
                                                        $('#form-{{ $plan->name }}-clear input').val($('#pc-{{ $plan->name }}').val());
                                                        $('.field-promocode').val($('#pc-{{ $plan->name }}').val());

                                                        $('#pc-{{ $plan->name }}-clear').click(function(){
                                                            clear_promocode_{{ $plan->name }}();
                                                        });

                                                        calc_{{ $plan->name }}(7000000, data.nominal);
                                                    },
                                                });
                                            }

                                            function clear_promocode_{{ $plan->name }}(){
                                                $('#form-{{ $plan->name }}-check').removeClass('d-none');
                                                $('#form-{{ $plan->name }}-clear').addClass('d-none');
                                                $('#pc-{{ $plan->name }}').removeClass('is-invalid').val('');
                                                $('#pc-{{ $plan->name }}-submit').removeClass('btn-danger').addClass('btn-secondary');
                                                $('.field-promocode').val('');

                                                calc_{{ $plan->name }}(7000000, 0);
                                            }

                                            function calc_{{ $plan->name }}(subtotal, promo){
                                                var ppn = (subtotal - promo) * (10 / 100);
                                                var total = (subtotal - promo) + ppn;

                                                $('#calc-{{ $plan->name }}-promo').text('Rp. '+ numeral(promo).format('0,0'))
                                                $('#calc-{{ $plan->name }}-ppn').text('Rp. '+ numeral(ppn).format('0,0'))
                                                $('#calc-{{ $plan->name }}-total').text('Rp. '+ numeral(total).format('0,0'))
                                            }
                                        })
                                    </script>
                                    @endpush
                                </div>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <dl class="row border-b">
                                    <dt class="col-sm-3">Subtotal</dt>
                                    <dd class="col-sm-9 text-right" id="calc-{{ $plan->name }}-subtotal" data-nominal="{{ $plan->price }}">
                                        {{ $plan->currency->code }}
                                        {{ number_format($plan->price) }}
                                    </dd>
                                    @if($plan->promo)
                                    <dt class="col-sm-3">Promocode</dt>
                                    <dd class="col-sm-9 text-right" id="calc-{{ $plan->name }}-promo" data-nominal="0">Rp. 0</dd>
                                    @endif

                                    @if($plan->currency->code == 'IDR')
                                    <dt class="col-sm-3">PPN</dt>
                                    <dd class="col-sm-9 text-right" id="calc-{{ $plan->name }}-ppn" data-nominal="{{ ($plan->price * 10) / 100 }}">
                                        {{ $plan->currency->code }}
                                        {{ number_format(($plan->price * 10) / 100) }}
                                    </dd>
                                    @endif
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-3">TOTAL</dt>
                                    <dd class="col-sm-9 text-right font-w600" id="calc-{{ $plan->name }}-total" data-nominal="{{ $plan->price + (($plan->price * 10) / 100) }}">
                                        {{ $plan->currency->code }}
                                        {{ number_format($plan->price + (($plan->price * 10) / 100)) }}
                                    </dd>
                                </dl>
                            </div>
                        </div>

                        <div class="border-t mt-20 pt-20">
                            <div class="mb-20">{!! config('app.billing_info_intl') !!}</div>

                            <p class="bg-gray-lighter p-10 mb-0">{!! __('package.billing_agreement') !!}</p>
                        </div>
                    </div>
                    <div class="block-content block-content-full bg-gray-lighter border-t">
                        <div class="row">
                            <div class="col-auto mr-auto">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('general.close') }}</button>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-danger">{{ __('package.request') }}</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endforeach

@php
/****************************** REGULAR ******************************/
$plan = \Gerardojbaez\LaraPlans\Models\Plan::where('name', 'regular')->first();
@endphp
@if($plan->id != $current->id)
<div class="modal fade" id="package-regular-request" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="block mb-0">
				<div class="block-header bg-gray-lighter">
					<h3 class="block-title">{{ __('package.regular.name') }}</h3>
					<div class="block-options">
						<button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
							<i class="si si-close"></i>
						</button>
					</div>
				</div>
				@if(Auth::user()->subscription('main')->ability()->consumed('products') <= $plan->features()->where('code', 'products')->first()->value)
                <form action="{{ route('member.package.store') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{ $plan->name }}" name="package">
                    <div class="block-content block-content-full">
                        <div class="mb-20">
                            {{ __('package.request_notification') }}
                        </div>
                    </div>
                    <div class="block-content block-content-full bg-gray-lighter border-t">
                        <div class="row">
                            <div class="col-auto mr-auto">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('general.close') }}</button>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-danger">{{ __('package.request') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
                @else
                    <div class="block-content block-content-full">
                        {{
                            __('package.need_delete_product', [
                                'quantity' => $plan->features()->where('code', 'products')->first()->value
                            ])
                        }}
                    </div>
                    <div class="block-content block-content-full bg-gray-lighter border-t">
                        <div class="row">
                            <div class="col-auto ml-auto">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('general.close') }}</button>
                            </div>
                        </div>
                    </div>
                @endif
			</div>
		</div>
	</div>
</div>
@endif


@php
/****************************** OPTION 1 ******************************/
$plan = \Gerardojbaez\LaraPlans\Models\Plan::where('name', 'option_1')->first();
@endphp
@if($plan->id != $current->id)
<div class="modal fade" id="package-option_1-request" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="block mb-0">
                <div class="block-header bg-gray-lighter">
                    <h3 class="block-title">{{ __('package.option_1.name') }}</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                @if(Auth::user()->subscription('main')->ability()->consumed('products') <= $plan->features()->where('code', 'products')->first()->value)
                <form action="{{ route('member.package.store') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{ $plan->name }}" name="package">
                    <input type="hidden" class="field-promocode" name="promo">
                    <div class="block-content block-content-full">
                        <div class="row ">
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>Product</th>
                                                <th class="text-center">Unit Price</th>
                                                <th class="text-center">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>
                                                    Option 1 - Rp. 7,000,000 / year
                                                    <span class="d-block font-w400">1 year</span>
                                                </th>
                                                <th class="text-right">Rp. 7,000,000</th>
                                                <th class="text-right">Rp. 7,000,000</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div id="promo-{{ $plan->name }}" data-children=".p-item">
                                    <div class="p-item">
                                        <a data-toggle="collapse" data-parent="#promo-{{ $plan->name }}" href="#promo-{{ $plan->name }}-content">
                                            Have a promotional code?
                                        </a>
                                        <div id="promo-{{ $plan->name }}-content" class="collapse">
                                            <div class="mb-3">
                                                <div id="form-{{ $plan->name }}-check" class="input-group">
                                                    <input id="pc-{{ $plan->name }}" type="text" class="form-control" placeholder="Enter promocode here">
                                                    <span class="input-group-btn">
                                                        <button id="pc-{{ $plan->name }}-submit" class="btn btn-secondary" type="button">Submit</button>
                                                    </span>
                                                </div>
                                                <div id="form-{{ $plan->name }}-clear" class="input-group d-none">
                                                    <input type="text" class="form-control" disabled>
                                                    <span class="input-group-btn">
                                                        <button id="pc-{{ $plan->name }}-clear" class="btn btn-secondary" type="button">Remove</button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @push('script')
                                    <script type="text/javascript">
                                        $(function(){
                                            $('#pc-{{ $plan->name }}-submit').click(function(){
                                                check_promocode_{{ $plan->name }}();
                                            })

                                            function check_promocode_{{ $plan->name }}(){
                                                $.ajax({
                                                    method: "GET",
                                                    url: '{{ route('ajax.coupon.show', null) }}/' + $('#pc-{{ $plan->name }}').val(),
                                                    error: function(jqXHR, textStatus, errorThrown){
                                                        $('#pc-{{ $plan->name }}').addClass('is-invalid');
                                                        $('#pc-{{ $plan->name }}-submit').removeClass('btn-secondary').addClass('btn-danger');
                                                    },
                                                    success: function (data, textStatus, jqXHR){
                                                        $('#form-{{ $plan->name }}-check').addClass('d-none');
                                                        $('#form-{{ $plan->name }}-clear').removeClass('d-none');
                                                        $('#form-{{ $plan->name }}-clear input').val($('#pc-{{ $plan->name }}').val());
                                                        $('.field-promocode').val($('#pc-{{ $plan->name }}').val());

                                                        $('#pc-{{ $plan->name }}-clear').click(function(){
                                                            clear_promocode_{{ $plan->name }}();
                                                        });

                                                        calc_{{ $plan->name }}(7000000, data.nominal);
                                                    },
                                                });
                                            }

                                            function clear_promocode_{{ $plan->name }}(){
                                                $('#form-{{ $plan->name }}-check').removeClass('d-none');
                                                $('#form-{{ $plan->name }}-clear').addClass('d-none');
                                                $('#pc-{{ $plan->name }}').removeClass('is-invalid').val('');
                                                $('#pc-{{ $plan->name }}-submit').removeClass('btn-danger').addClass('btn-secondary');
                                                $('.field-promocode').val('');

                                                calc_{{ $plan->name }}(7000000, 0);
                                            }

                                            function calc_{{ $plan->name }}(subtotal, promo){
                                                var ppn = (subtotal - promo) * (10 / 100);
                                                var total = (subtotal - promo) + ppn;

                                                $('#calc-{{ $plan->name }}-promo').text('Rp. '+ numeral(promo).format('0,0'))
                                                $('#calc-{{ $plan->name }}-ppn').text('Rp. '+ numeral(ppn).format('0,0'))
                                                $('#calc-{{ $plan->name }}-total').text('Rp. '+ numeral(total).format('0,0'))
                                            }
                                        })
                                    </script>
                                    @endpush
                                </div>
                            </div>
                            <div class="col-md-4">
                                <dl class="row border-b">
                                    <dt class="col-sm-3">Subtotal</dt>
                                    <dd class="col-sm-9 text-right" id="calc-{{ $plan->name }}-subtotal" data-nominal="7000000">Rp. 7,000,000</dd>
                                    <dt class="col-sm-3">Promocode</dt>
                                    <dd class="col-sm-9 text-right" id="calc-{{ $plan->name }}-promo" data-nominal="0">Rp. 0</dd>
                                    <dt class="col-sm-3">PPN</dt>
                                    <dd class="col-sm-9 text-right" id="calc-{{ $plan->name }}-ppn" data-nominal="500000">Rp. 700,000</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-3">TOTAL</dt>
                                    <dd class="col-sm-9 text-right font-w600" id="calc-{{ $plan->name }}-total" data-nominal="7000000">Rp. 7,700,000</dd>
                                </dl>
                            </div>
                        </div>

                        <div class="border-t mt-20 pt-20">
                            <div class="mb-20">{!! config('app.billing_info') !!}</div>

                            <p class="bg-gray-lighter p-10 mb-0">{!! __('package.billing_agreement') !!}</p>
                        </div>
                    </div>
                    <div class="block-content block-content-full bg-gray-lighter border-t">
                        <div class="row">
                            <div class="col-auto mr-auto">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('general.close') }}</button>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-danger">{{ __('package.request') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
                @else
                    <div class="block-content block-content-full">
                        {{
                            __('package.need_delete_product', [
                                'quantity' => $plan->features()->where('code', 'products')->first()->value
                            ])
                        }}
                    </div>
                    <div class="block-content block-content-full bg-gray-lighter border-t">
                        <div class="row">
                            <div class="col-auto ml-auto">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('general.close') }}</button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif


@php
/****************************** OPTION 2 ******************************/
$plan = \Gerardojbaez\LaraPlans\Models\Plan::where('name', 'option_2')->first();
@endphp
@if($plan->id != $current->id)
<div class="modal fade" id="package-option_2-request" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="block mb-0">
                <div class="block-header bg-gray-lighter">
                    <h3 class="block-title">{{ __('package.option_2.name') }}</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                @if(Auth::user()->subscription('main')->ability()->consumed('products') <= $plan->features()->where('code', 'products')->first()->value)
                <form action="{{ route('member.package.store') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{ $plan->name }}" name="package">
                    <input type="hidden" class="field-promocode" name="promo">
                    <div class="block-content block-content-full">
                        <div class="row ">
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>Product</th>
                                                <th class="text-center">Unit Price</th>
                                                <th class="text-center">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>
                                                    Option 2 - Rp. 2,000 / PPC
                                                    <span class="d-block font-w400">Deposit</span>
                                                </th>
                                                <th class="text-right">Rp. 2,000,000</th>
                                                <th class="text-right">Rp. 2,000,000</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div id="promo-{{ $plan->name }}" data-children=".p-item">
                                    <div class="p-item">
                                        <a data-toggle="collapse" data-parent="#promo-{{ $plan->name }}" href="#promo-{{ $plan->name }}-content">
                                            Have a promotional code?
                                        </a>
                                        <div id="promo-{{ $plan->name }}-content" class="collapse">
                                            <div class="mb-3">
                                                Only available for Option 1
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <dl class="row border-b">
                                    <dt class="col-sm-3">Subtotal</dt>
                                    <dd class="col-sm-9 text-right" id="calc-{{ $plan->name }}-subtotal" data-nominal="2000000">Rp. 2,000,000</dd>
                                    <dt class="col-sm-3">Promocode</dt>
                                    <dd class="col-sm-9 text-right" id="calc-{{ $plan->name }}-promo" data-nominal="0">Rp. 0</dd>
                                    <dt class="col-sm-3">PPN</dt>
                                    <dd class="col-sm-9 text-right" id="calc-{{ $plan->name }}-ppn" data-nominal="100000">Rp. 200,000</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-3">TOTAL</dt>
                                    <dd class="col-sm-9 text-right font-w600" id="calc-{{ $plan->name }}-total" data-nominal="1000000">Rp. 2,000,000</dd>
                                </dl>
                            </div>
                        </div>

                        <div class="border-t mt-20 pt-20">
                            <div class="mb-20">{!! config('app.billing_info') !!}</div>

                            <p class="bg-gray-lighter p-10 mb-0">{!! __('package.billing_agreement') !!}</p>
                        </div>
                    </div>
                    <div class="block-content block-content-full bg-gray-lighter border-t">
                        <div class="row">
                            <div class="col-auto mr-auto">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('general.close') }}</button>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-danger">{{ __('package.request') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
                @else
                    <div class="block-content block-content-full">
                        {{
                            __('package.need_delete_product', [
                                'quantity' => $plan->features()->where('code', 'products')->first()->value
                            ])
                        }}
                    </div>
                    <div class="block-content block-content-full bg-gray-lighter border-t">
                        <div class="row">
                            <div class="col-auto ml-auto">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('general.close') }}</button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif


@php
/****************************** OPTION 3 ******************************/
$plan = \Gerardojbaez\LaraPlans\Models\Plan::where('name', 'option_3')->first();
@endphp
@if($plan->id != $current->id)
<div class="modal fade" id="package-option_3-request" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="block mb-0">
                <div class="block-header bg-gray-lighter">
                    <h3 class="block-title">{{ __('package.option_3.name') }}</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                @if(Auth::user()->subscription('main')->ability()->consumed('products') <= $plan->features()->where('code', 'products')->first()->value)
                <form action="{{ route('member.package.store') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{ $plan->name }}" name="package">
                    <input type="hidden" class="field-promocode" name="promo">
                    <div class="block-content block-content-full">
                        <div class="row ">
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>Product</th>
                                                <th class="text-center">Unit Price</th>
                                                <th class="text-center">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>
                                                    Option 3 - IDN Marketing Services
                                                    <span class="d-block font-w400">1 year</span>
                                                </th>
                                                <th class="text-right">Rp. 0</th>
                                                <th class="text-right">Rp. 0</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-20">
                                    <small>
                                        IDN Marketing Fee ranges from 3% to 5% depending on your product and price.<br>
                                    Our IDN Marketing Service\'s Team will contact you for detail discussion.
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <dl class="row border-b">
                                    <dt class="col-sm-3">Subtotal</dt>
                                    <dd class="col-sm-9 text-right" id="calc-{{ $plan->name }}-subtotal" data-nominal="0">Rp. 0</dd>
                                    <dt class="col-sm-3">PPN</dt>
                                    <dd class="col-sm-9 text-right" id="calc-{{ $plan->name }}-ppn" data-nominal="100000">Rp. 0</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-3">TOTAL</dt>
                                    <dd class="col-sm-9 text-right font-w600" id="calc-{{ $plan->name }}-total" data-nominal="0">Rp. 0</dd>
                                </dl>
                            </div>
                        </div>

                        <div class="border-t mt-20 pt-20">
                            <div class="mb-20">{!! config('app.billing_info') !!}</div>

                            <p class="bg-gray-lighter p-10 mb-0">{!! __('package.billing_agreement') !!}</p>
                        </div>
                    </div>
                    <div class="block-content block-content-full bg-gray-lighter border-t">
                        <div class="row">
                            <div class="col-auto mr-auto">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('general.close') }}</button>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-danger">{{ __('package.request') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
                @else
                    <div class="block-content block-content-full">
                        {{
                            __('package.need_delete_product', [
                                'quantity' => $plan->features()->where('code', 'products')->first()->value
                            ])
                        }}
                    </div>
                    <div class="block-content block-content-full bg-gray-lighter border-t">
                        <div class="row">
                            <div class="col-auto ml-auto">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('general.close') }}</button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
@endif
