@if(Auth::check())
@role('seller|buyer')
@if($user->id != Auth::id())
<a href="#" data-toggle="modal" data-target="#modal-message-{{ $user->id }}" class="btn btn-danger">{{ __('message.contact_' . $type) }}</a>

<div class="modal fade text-left" id="modal-message-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-message-{{ $user->id }}" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

			<form action="{{ $exists ? route('member.message.update', $exists->id) : route('member.message.store') }}" method="post">
				{{ csrf_field() }}

				@if($exists)
				{{ method_field('put') }}
				@endif

				<input type="hidden" name="recipient" value="{{ $user->id }}">

				<div class="block block-themed block-transparent mb-0">
					<div class="block-header bg-pulse text-white">
						<h3 class="block-title">{{ __('message.contact_' . $type) }}</h3>
						<div class="block-options">
							<button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
								<i class="si si-close"></i>
							</button>
						</div>
					</div>
					<div class="block-content bg-gray-lighter border-b block-content-full clearfix">
						<div class="">
							@if(isset($user))
							<div class="font-w600">{{ $user->company }}</div>
							@endif
							@if(isset($product))
							<div class="font-size-sm text-muted">{{ $product->name }}</div>
							<input type="hidden" name="product_id" value="{{ $product->id }}">
							@endif
						</div>
					</div>
					<div class="block-content block-content-full">
						<textarea name="body" class="form-control" rows="8" placeholder="{{ __('message.body_placeholder') }}" required>{{ old('body') }}</textarea>
					</div>
					<div class="block-content bg-gray-lighter border-t block-content-full text-right">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('general.close') }}</button>
						<button type="submit" class="btn btn-danger">{{ __('message.send') }}</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endif
@endrole
@else
<a href="#" data-toggle="modal" data-target="#modal-login" class="btn btn-danger">{{ __('message.login_to_contact_' . $type) }}</a>
@endif
