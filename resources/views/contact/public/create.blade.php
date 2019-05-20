@extends('_layouts.frontend')
@section('title', __('general.contact'))

@section('content')


<div class="bg-image bg-black-op-25" style="background-image: url('{{ asset('img/covers/photo33@2x.jpg') }}');">
    <div class="bg-primary-dark-op">
        <div class="content content-full content-top text-center overflow-hidden">
            <h1 class="h2 font-w700 text-white mb-30 js-appear-enabled animated fadeInDown" data-toggle="appear" data-class="animated fadeInDown">
				{{ __('general.contact') }}
			</h1>
        </div>
    </div>
</div>

<div class="content content-full pt-50 pb-50">
	<div class="row">
		<div class="col-md-9">
			<div class="pb-20 block block-bordered">
				<div class="block-content">
					<form action="{{ route('public.contact.store') }}" method="post">
						{{ csrf_field() }}
						<div class="block-content block-content-full">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
										<label for="field-name">{{ __('contact.name') }}</label>
										<input type="text" class="form-control" id="field-name" name="name" value="{{ old('name') }}" placeholder="{{ __('contact.name_placeholder') }}">
										<div class="invalid-feedback">{{ $errors->first('name') }}</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
										<label for="field-email">{{ __('contact.email') }}</label>
										<input type="text" class="form-control" id="field-email" name="email" value="{{ old('email') }}" placeholder="{{ __('contact.email_placeholder') }}">
										<div class="invalid-feedback">{{ $errors->first('email') }}</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group{{ $errors->has('mobile') ? ' is-invalid' : '' }}">
										<label for="field-mobile">{{ __('contact.mobile') }}</label>
										<input type="text" class="form-control" id="field-mobile" name="mobile" value="{{ old('mobile') }}" placeholder="{{ __('contact.mobile_placeholder') }}">
										<div class="invalid-feedback">{{ $errors->first('mobile') }}</div>
									</div>
								</div>
								<div class="col-md-12" style="position: relative;">
									<div class="form-group{{ $errors->has('body') ? ' is-invalid' : '' }}">
										<label for="field-body">{{ __('contact.body') }}</label>
										<textarea id="field-body" class="form-control" name="body" rows="6" placeholder="{{ __('contact.body_placeholder') }}">{{ old('body') }}</textarea>
										<div class="invalid-feedback">{{ $errors->first('body') }}</div>
									</div>
								</div>
							</div>

							<div class="row mt-10">
								<div class="col-auto mr-auto">
								</div>
								<div class="col-auto">
									<button type="submit" class="btn btn-danger">{{ __('contact.send') }}</button>
								</div>
							</div>
						</div>
					</form>
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
