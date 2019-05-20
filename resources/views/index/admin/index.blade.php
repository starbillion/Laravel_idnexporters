@extends('_layouts.backend')
@section('title', __('general.dashboard'))

@section('content')
<div class="section">
	<div class="row gutters-tiny">

		@if(Auth::user()->can('read-user'))
		<div class="col-6 col-md-3 col-xl-3">
			<a class="block block-link-shadow text-center" href="{{ route('admin.user.index.seller') }}">
				<div class="block-content">
					<p class="mt-5">
						<i class="si si-people fa-4x"></i>
					</p>
					<p class="font-w600">Manage Seller</p>
				</div>
			</a>
		</div>
		<div class="col-6 col-md-3 col-xl-3">
			<a class="block block-link-shadow text-center" href="{{ route('admin.user.index.buyer') }}">
				<div class="block-content">
					<p class="mt-5">
						<i class="si si-people fa-4x"></i>
					</p>
					<p class="font-w600">Manage Buyer</p>
				</div>
			</a>
		</div>
		@endif

		@if(Auth::user()->can('read-product'))
		<div class="col-6 col-md-3 col-xl-3">
			<a class="block block-link-shadow text-center" href="{{ route('admin.product.category.index') }}">
				<div class="block-content">
					<p class="mt-5">
						<i class="si si-list fa-4x"></i>
					</p>
					<p class="font-w600">Manage Categories</p>
				</div>
			</a>
		</div>
		<div class="col-6 col-md-3 col-xl-3">
			<a class="block block-link-shadow text-center" href="{{ route('admin.product.post.index') }}">
				<div class="block-content">
					<p class="mt-5">
						<i class="si si-layers fa-4x"></i>
					</p>
					<p class="font-w600">Manage Products</p>
				</div>
			</a>
		</div>
		@endif

		@if(Auth::user()->can('read-message'))
		<div class="col-6 col-md-3 col-xl-3">
			<a class="block block-link-shadow text-center" href="{{ route('admin.message.index') }}">
				<div class="block-content">
					<p class="mt-5">
						<i class="si si-envelope fa-4x"></i>
					</p>
					<p class="font-w600">Internal Emails</p>
				</div>
			</a>
		</div>
		@endif

		@if(Auth::user()->can('read-contact'))
		<div class="col-6 col-md-3 col-xl-3">
			<a class="block block-link-shadow text-center" href="{{ route('admin.contact.index') }}">
				<div class="block-content">
					<p class="mt-5">
						<i class="si si-envelope fa-4x"></i>
					</p>
					<p class="font-w600">Inquiries To IDN</p>
				</div>
			</a>
		</div>
		@endif

		@if(Auth::user()->can('read-traffic'))
		<div class="col-6 col-md-3 col-xl-3">
			<a class="block block-link-shadow text-center" href="{{ route('admin.traffic.index') }}">
				<div class="block-content">
					<p class="mt-5">
						<i class="si si-graph fa-4x"></i>
					</p>
					<p class="font-w600">Traffic</p>
				</div>
			</a>
		</div>
		@endif

		@if(Auth::user()->can('read-search'))
		<div class="col-6 col-md-3 col-xl-3">
			<a class="block block-link-shadow text-center" href="{{ route('admin.search.index') }}">
				<div class="block-content">
					<p class="mt-5">
						<i class="si si-magnifier fa-4x"></i>
					</p>
					<p class="font-w600">Searches</p>
				</div>
			</a>
		</div>
		@endif

		@if(Auth::user()->can('read-news'))
		<div class="col-6 col-md-3 col-xl-3">
			<a class="block block-link-shadow text-center" href="{{ route('admin.news.index') }}">
				<div class="block-content">
					<p class="mt-5">
						<i class="si si-feed fa-4x"></i>
					</p>
					<p class="font-w600">News</p>
				</div>
			</a>
		</div>
		@endif

		@if(Auth::user()->can('read-exhibition'))
		<div class="col-6 col-md-3 col-xl-3">
			<a class="block block-link-shadow text-center" href="{{ route('admin.exhibition.index') }}">
				<div class="block-content">
					<p class="mt-5">
						<i class="si si-globe fa-4x"></i>
					</p>
					<p class="font-w600">Exhibitions</p>
				</div>
			</a>
		</div>
		@endif

		@if(Auth::user()->can('read-coupon'))
		<div class="col-6 col-md-3 col-xl-3">
			<a class="block block-link-shadow text-center" href="{{ route('admin.coupon.index') }}">
				<div class="block-content">
					<p class="mt-5">
						<i class="si si-present fa-4x"></i>
					</p>
					<p class="font-w600">Coupons</p>
				</div>
			</a>
		</div>
		@endif

		@if(Auth::user()->can('read-setting'))
		<div class="col-6 col-md-3 col-xl-3">
			<a class="block block-link-shadow text-center" href="{{ route('admin.setting.index') }}">
				<div class="block-content">
					<p class="mt-5">
						<i class="si si-settings fa-4x"></i>
					</p>
					<p class="font-w600">Settings</p>
				</div>
			</a>
		</div>
		@endif
	</div>
</div>
@endsection
