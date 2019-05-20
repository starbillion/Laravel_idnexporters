<ul class="nav nav-tabs nav-tabs-block">
	<li class="nav-item">
		<a class="nav-link {{ Route::currentRouteName() == 'admin.setting.company' ? 'active' : '' }}" href="{{ route('admin.setting.company') }}">
			{{ __('setting.menu.company') }}
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link {{ Route::currentRouteName() == 'admin.setting.application' ? 'active' : '' }}" href="{{ route('admin.setting.application') }}">
			{{ __('setting.menu.application') }}
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link {{ Route::currentRouteName() == 'admin.setting.email' ? 'active' : '' }}" href="{{ route('admin.setting.email') }}">
			{{ __('setting.menu.email') }}
		</a>
	</li>
</ul>
