<ul class="nav nav-tabs nav-tabs-block">
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'member.profile.general' ? 'active' : '' }}" href="{{ route('member.profile.general') }}">
            {{ __('user.profile_tab_general') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'member.profile.company' ? 'active' : '' }}" href="{{ route('member.profile.company') }}">
            {{ __('user.profile_tab_company') }}
        </a>
    </li>

    @role('buyer')
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'member.profile.profile' ? 'active' : '' }}" href="{{ route('member.profile.profile') }}">
            {{ __('user.profile_tab_buyer') }}
        </a>
    </li>
    @endrole

    @role('seller')
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'member.profile.profile' ? 'active' : '' }}" href="{{ route('member.profile.profile') }}">
            {{ __('user.profile_tab_seller') }}
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'member.profile.category' ? 'active' : '' }}" href="{{ route('member.profile.category') }}">
            {{ __('user.profile_tab_category') }}
        </a>
    </li>

    @if(Auth::user()->subscription('main')->ability()->canUse('company_logo'))
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'member.profile.banners' ? 'active' : '' }}" href="{{ route('member.profile.banners') }}">
            {{ __('user.profile_tab_banners') }}
        </a>
    </li>
    @else
    <li class="nav-item">
        <a class="nav-link disabled" href="#" data-toggle="modal" data-target="#upgrade_required">
            {{ __('user.profile_tab_banners') }}
        </a>
    </li>
    @endif

    @if(Auth::user()->subscription('main')->ability()->canUse('company_banners'))
    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() == 'member.profile.media' ? 'active' : '' }}" href="{{ route('member.profile.media') }}">
            {{ __('user.profile_tab_media') }}
        </a>
    </li>
    @else
    <li class="nav-item">
        <a class="nav-link disabled" href="#" data-toggle="modal" data-target="#upgrade_required">
            {{ __('user.profile_tab_media') }}
        </a>
    </li>
    @endif
    @endrole
</ul>
