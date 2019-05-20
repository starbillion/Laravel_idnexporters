<div class="block block-bordered mb-20">
	<div class="block-header block-header-default border-b">
        <h3 class="block-title">{{ __('user.browse_filters') }}</h3>
    </div>
	<div class="block-content block-content-full">
		<form>
			<div class="form-group">
				<label for="field-country">{{ __('user.country') }}</label>
				<select class="js-select2 form-control" id="field-country" name="country" style="width: 100%;" data-placeholder="{{ __('general.choose') }}">
					<option></option>
					@foreach($countries as $country)
					<option value="{{ $country->id }}" {{ request()->input('country') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<label for="field-q">{{ __('user.import_interests') }}</label>
				<input type="text" class="form-control" id="field-q" name="q" value="{{ request()->input('q') }}" placeholder="{{ __('user.import_interests_placeholder') }}">
			</div>
			<hr>

			@if(request()->input('country') or request()->input('q'))
			<a href="{{ route('public.user.buyer.index') }}" class="btn btn-secondary btn-block">{{ __('user.clear_filters') }}</a>
			@endif
			<button type="submit" class="btn btn-danger btn-block">{{ __('general.search') }}</button>
		</form>
	</div>
</div>
