<div class="block block-bordered mb-20">
	<div class="block-header block-header-default">
		<h3 class="block-title">{{ __('general.exchange_rate') }} <small>(Base USD)</small></h3>
	</div>
	<div class="block-content">
		@if(count($rates) > 0)
		<div class="table-responsive">
			<table class="table table-striped table-vcenter">
				<tbody>
					@foreach($rates as $key => $rate)
					<tr>
						<td>
						{{ $key }}
						</td>
						<td class="text-right">
						{{ number_format($rate, 2) }}
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		@endif
	</div>
</div>
