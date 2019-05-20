@if(isPackageEnded())
<div class="alert alert-danger" role="alert">
    @if(isRequestPackage())
    {{ __('package.notification_store_success') }}<br>
        {!! __('package.notification_cancel') !!}
    @else
    	@if(Auth::user()->hasRole('seller'))
		    {{ __('package.ended_notification_seller') }}<br>
		    <a href="#" class="btn btn-danger mt-5" data-toggle="modal" data-target="#package-request">
	    		{{ __('package.renew') }}
			</a>
		@else
			{{ __('package.ended_notification_buyer') }}<br>
		    <a href="#" class="btn btn-danger mt-5" data-toggle="modal" data-target="#package-request">
	    		{{ __('package.renew') }}
			</a>
		@endif
    @endif
</div>

<div class="modal fade" id="package-request" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="block block-themed block-transparent mb-0">
				<div class="block-header bg-primary-dark">
					<h3 class="block-title">
						@if(Auth::user()->hasRole('seller'))
						{{ __('package.seller.option_1.name') }}
						@else
						{{ __('package.buyer.paid.name') }}
						@endif
					</h3>
					<div class="block-options">
						<button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
							<i class="si si-close"></i>
						</button>
					</div>
				</div>

				<form action="{{ route('member.package.store') }}" method="post">
					{{ csrf_field() }}
					<input type="hidden" value="{{ Auth::user()->hasRole('seller') ? 2 : 6 }}" name="package">
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
			</div>
		</div>
	</div>
</div>
@endif

@if(Auth::user()->subscriptions()->where('canceled_at', null)->first()->plan->name == 'option_2')
@if(Auth::user()->balance >= 2000 and Auth::user()->balance <= 100000)
<div class="alert alert-danger" role="alert">
    Your available balance Rp {{ number_format(Auth::user()->balance) }}. Please <a href="#">click here</a> to top-up your account in order to continue enjoying our service.
</div>
@elseif(Auth::user()->balance >= 0 and Auth::user()->balance <= 1999)
<div class="alert alert-danger" role="alert">
    Your balance is insufficient. Please <a href="#">click here</a> to top-up your account in order to continue enjoying our service.
</div>
@endif
@endif
