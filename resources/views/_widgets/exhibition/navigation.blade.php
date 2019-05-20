<ul class="nav nav-tabs  mb-0 pb-0">
	<li class="nav-item">
		<a class="nav-link {{ request()->segment(5) == '' ? 'active' : '' }}" href="{{ route('public.exhibition.catalogue.show', $post->slug) }}">{{ __('exhibition.about') }}</a>
	</li>

	@if(Auth::check() and (
		Auth::user()->hasRole('superadmin|admin') or
		Auth::user()->subscriptions()->where('canceled_at', null)->first()->plan->name == 'option_1' or
		Auth::user()->subscriptions()->where('canceled_at', null)->first()->plan->name == 'option_2' or
		Auth::user()->subscriptions()->where('canceled_at', null)->first()->plan->name == 'option_3'
	))
	<li class="nav-item">
		<a class="nav-link {{ request()->segment(5) == 'exhibitors' ? 'active' : '' }}" href="{{ route('public.exhibition.catalogue.exhibitors', $post->slug) }}">{{ __('exhibition.exhibitor_list') }}</a>
	</li>
	@else
	<li class="nav-item">
		<a class="nav-link" href="javascript:;" data-target="#modal-exhibitors" data-toggle="modal">{{ __('exhibition.exhibitor_list') }}</a>
	</li>
	@endif

</ul>

@push('modal')
<div class="modal fade" id="modal-exhibitors" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="block block-themed block-transparent mb-0">
				<div class="block-header bg-primary-dark">
					<h3 class="block-title">{{ __('general.exhibitors') }}</h3>
					<div class="block-options">
						<button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
							<i class="si si-close"></i>
						</button>
					</div>
				</div>
				<div class="block-content block-content-full">
					The complete list of exhibitors for this event is only available for IDN paid membership.
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
@endpush
