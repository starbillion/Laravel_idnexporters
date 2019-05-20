<li>
    <a{{ Route::currentRouteName() == 'public.index' ? ' class=active' : '' }} href="{{ route('public.index') }}">{{ __('general.home') }}</a>
</li>
<li>
	<a class="nav-submenu" data-toggle="nav-submenu" href="#">{{ __('general.about') }}</a>
	<ul>
		<li>
			<a href="{{ route('public.page.show', 'about') }}">{{ __('general.about_us') }}</a>
		</li>
		<li>
			<a href="{{ route('public.faq.index') }}">{{ __('general.faqs') }}</a>
		</li>
		<li>
			<a href="{{ route('public.contact.create') }}">{{ __('general.contact') }}</a>
		</li>
	</ul>
</li>
<li>
    <a{{ request()->segment(1) == 'category' ? ' class=active' : '' }} href="{{ route('public.product.index') }}">{{ __('general.products') }}</a>
</li>
<li>
    <a{{ Route::currentRouteName() == 'public.user.seller.index' ? ' class=active' : '' }} href="{{ route('public.user.seller.index', ['splash' => true]) }}">{{ __('general.sellers') }}</a>
</li>
<li>
    <a{{ Route::currentRouteName() == 'public.user.buyer.index' ? ' class=active' : '' }} href="{{ route('public.user.buyer.index', ['splash' => true]) }}">{{ __('general.buyers') }}</a>
</li>
<li>
	<a class="{{ request()->segment(1) == 'news' ? 'active' : '' }}" href="{{ route('public.news.index') }}">{{ __('general.news') }}</a>
</li>
<li>
	<a class="{{ request()->segment(1) == 'exhibition' ? 'active' : '' }} nav-submenu" data-toggle="nav-submenu" href="#">{{ __('general.exhibitions') }}</a>
	<ul style="min-width: 200px;">
		<li>
			<a href="{{ route('public.exhibition.index') }}">{{ __('general.featured_exhibitions') }}</a>
		</li>
		<li>
			<a href="{{ route('public.exhibition.calendar.index') }}">{{ __('general.exhibition_calendar') }}</a>
		</li>
	</ul>
</li>
@if(Auth::check())
<li>
	@if(hasRoleGroup('member'))
	<a class="{{ request()->segment(1) == 'member' ? 'active' : '' }} nav-submenu" data-toggle="nav-submenu" href="#">{{ Auth::user()->name }}</a>
	@else
	<a class="{{ request()->segment(1) == 'admin' ? 'active' : '' }} nav-submenu" data-toggle="nav-submenu" href="#">{{ Auth::user()->name }}</a>
	@endif
	<ul>
		<li>
			<a href="{{ route('dashboard') }}">
				{{ __('general.dashboard') }}
			</a>
		</li>
		<li>
			<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
				{{ __('general.logout') }}
				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
			</a>
		</li>
	</ul>
</li>
@else
<li>
	<a href="#" data-toggle="modal" data-target="#modal-login">
		{{ __('general.login_register') }}
	</a>
</li>
@endif
