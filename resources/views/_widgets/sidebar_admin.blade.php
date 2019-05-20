<div class="block block-bordered">
    <div class="block-content block-content-full">
        <ul class="nav-main">
            <li>
                <a href="{{ route('admin.index') }}" class="{{ Route::currentRouteName() == 'admin.index' ? 'active' : '' }}">
                    <i class="si si-cup"></i>
                    <span class="text-truncate">{{ __('general.dashboard') }}</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.profile') }}" class="{{ Route::currentRouteName() == 'admin.profile' ? 'active' : '' }}">
                    <i class="si si-user"></i>
                    <span class="text-truncate">{{ __('general.profile') }}</span>
                </a>
            </li>

            <li class="nav-main-heading">
                <span class="sidebar-mini-hidden">{{ __('general.management') }}</span>
            </li>

            @if(Auth::user()->can('read-user'))
            <li class="{{ (request()->segment(2) == 'user' or request()->segment(2) == 'package') ? 'open' : '' }}">
                <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                    <i class="si si-people"></i>
                    <span class="text-truncate">{{ __('general.user') }}</span>
                    @if($user['sellers'] > 0 or $user['buyers'] > 0 or $user['package'] > 0)
                    <span class="badge badge-pill badge-danger float-right">{{ $user['sellers'] + $user['buyers'] + $user['package'] }}</span>
                    @endif
                </a>
                <ul>
                    <li>
                        <a href="{{ route('admin.user.index.seller') }}" class="{{ (request()->segment(2) == 'user' and request()->segment(3) == 'seller') ? 'active' : '' }}">
                            <span class="text-truncate">{{ __('general.sellers') }}</span>
                            @if($user['sellers'] > 0)
                            <span class="badge badge-pill badge-danger float-right">{{ $user['sellers'] }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.user.index.buyer') }}" class="{{ (request()->segment(2) == 'user' and request()->segment(3) == 'buyer') ? 'active' : '' }}">
                            <span class="text-truncate">{{ __('general.buyers') }}</span>
                            @if($user['buyers'] > 0)
                            <span class="badge badge-pill badge-danger float-right">{{ $user['buyers'] }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.package.index') }}" class="{{ request()->segment(2) == 'package' ? 'active' : '' }}">
                            <span class="text-truncate">{{ __('package.upgrade_request') }}</span>
                            @if($user['package'] > 0)
                            <span class="badge badge-pill badge-danger float-right">{{ $user['package'] }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.user.export') }}" class="{{ (request()->segment(2) == 'user' and request()->segment(3) == 'export') ? 'active' : '' }}">
                            <span class="text-truncate">{{ __('user.export') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.user.import') }}" class="{{ (request()->segment(2) == 'user' and request()->segment(3) == 'import') ? 'active' : '' }}">
                            <span class="text-truncate">{{ __('user.import') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(Auth::user()->can('read-product'))
            <li class="{{ request()->segment(2) == 'product' ? 'open' : '' }}">
                <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                    <i class="si si-layers"></i>
                    <span class="text-truncate">{{ __('general.products') }}</span>
                    @if($product['posts'] > 0)
                    <span class="badge badge-pill badge-danger float-right">{{ $product['posts'] }}</span>
                    @endif
                </a>
                <ul>
                    <li>
                        <a href="{{ route('admin.product.category.index') }}" class="{{ request()->segment(3) == 'category' ? 'active' : '' }}">
                            <span class="text-truncate">{{ __('general.category') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.product.post.index') }}" class="
                        {{ (request()->segment(3) == 'post' and request()->input('status') != 'pending') ? 'active' : '' }}
                        ">
                            <span class="text-truncate">{{ __('general.product_posts') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.product.post.index', ['status' => 'pending']) }}"
                            class="{{
                                (request()->segment(3) == 'post' and request()->input('status') == 'pending') ? 'active' : ''
                            }}">
                            <span class="text-truncate">{{ __('product/post.new_product') }}</span>
                            @if($product['posts'] > 0)
                            <span class="badge badge-pill badge-danger float-right">{{ $product['posts'] }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(Auth::user()->can('read-message'))
            <li>
                <a href="{{ route('admin.message.index') }}" class="{{ request()->segment(2) == 'message' ? 'active' : '' }}">
                    <i class="si si-envelope"></i>
                    <span class="text-truncate">{{ __('general.messages') }}</span>
                    @if($message['posts'] > 0)
                    <span class="badge badge-pill badge-danger float-right">{{ $message['posts'] }}</span>
                    @endif
                </a>
            </li>
            @endif

            @if(Auth::user()->can('read-traffic'))
            <li>
                <a href="{{ route('admin.traffic.index') }}" class="{{ request()->segment(2) == 'traffic' ? 'active' : '' }}">
                    <i class="si si-graph"></i>
                    <span class="text-truncate">{{ __('general.traffic') }}</span>
                </a>
            </li>
            @endif

            @if(Auth::user()->can('read-search'))
            <li>
                <a href="{{ route('admin.search.index') }}" class="{{ request()->segment(2) == 'search' ? 'active' : '' }}">
                    <i class="si si-magnifier"></i>
                    <span class="text-truncate">{{ __('general.search') }}</span>
                </a>
            </li>
            @endif

            @if(Auth::user()->can('read-faq'))
            <li class="{{ request()->segment(2) == 'faq' ? 'open' : '' }}">
                <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                    <i class="si si-question"></i>
                    <span class="text-truncate">{{ __('general.faq') }}</span>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('admin.faq.category.index') }}" class="{{ request()->segment(3) == 'category' ? 'active' : '' }}">
                            <span class="text-truncate">{{ __('faq.categories') }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.faq.post.index') }}" class="{{ request()->segment(3) == 'post' ? 'active' : '' }}">
                            <span class="text-truncate">{{ __('faq.posts') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(Auth::user()->can('read-coupon'))
            <li>
                <a href="{{ route('admin.coupon.index') }}" class="{{ request()->segment(2) == 'coupon' ? 'active' : '' }}">
                    <i class="si si-present"></i>
                    <span class="text-truncate">{{ __('general.coupons') }}</span>
                </a>
            </li>
            @endif

            @if(Auth::user()->can('read-page'))
            <li>
                <a href="{{ route('admin.page.index') }}" class="{{ request()->segment(2) == 'page' ? 'active' : '' }}">
                    <i class="si si-book-open"></i>
                    <span class="text-truncate">{{ __('general.pages') }}</span>
                </a>
            </li>
            @endif

            @if(Auth::user()->can('read-news'))
            <li>
                <a href="{{ route('admin.news.index') }}" class="{{ request()->segment(2) == 'news' ? 'active' : '' }}">
                    <i class="si si-feed"></i>
                    <span class="text-truncate">{{ __('general.news') }}</span>
                </a>
            </li>
            @endif

            @if(Auth::user()->can('read-exhibition'))
            <li class="{{ (request()->segment(2) == 'exhibition' or request()->segment(2) == 'exhibitor') ? 'open' : '' }}">
                <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                    <i class="si si-globe"></i>
                    <span class="text-truncate">{{ __('general.exhibitions') }}</span>
                </a>
                <ul>
                    <li>
                        <a href="{{ route('admin.exhibition.index') }}" class="{{ request()->segment(2) == 'exhibition' ? 'active' : '' }}">
                            <span class="text-truncate">{{ __('general.exhibitions') }}</span>
                        </a>
                        <a href="{{ route('admin.exhibitor.index') }}" class="{{ request()->segment(2) == 'exhibitor' ? 'active' : '' }}">
                            <span class="text-truncate">{{ __('general.exhibitors') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(Auth::user()->can('read-endorsement'))
            <li>
                <a href="{{ route('admin.endorsement.index') }}" class="{{ request()->segment(2) == 'endorsement' ? 'active' : '' }}">
                    <i class="si si-briefcase"></i>
                    <span class="text-truncate">{{ __('general.endorsements') }}</span>
                </a>
            </li>
            @endif

            @if(Auth::user()->can('read-contact'))
            <li>
                <a href="{{ route('admin.contact.index') }}" class="{{ request()->segment(2) == 'contact' ? 'active' : '' }}">
                    <i class="si si-envelope"></i>
                    <span class="text-truncate">{{ __('general.contact') }}</span>
                </a>
            </li>
            @endif

            @if(Auth::user()->hasRole('superadmin'))
            <li>
                <a href="{{ route('admin.role.index') }}" class="{{ request()->segment(2) == 'role' ? 'active' : '' }}">
                    <i class="si si-equalizer"></i>
                    <span class="text-truncate">{{ __('general.role') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.admin.index') }}" class="{{ request()->segment(2) == 'admin' ? 'active' : '' }}">
                    <i class="si si-ghost"></i>
                    <span class="text-truncate">{{ __('general.admin') }}</span>
                </a>
            </li>
            @endif

            @if(Auth::user()->can('read-setting'))
            <li>
                <a href="{{ route('admin.setting.index') }}" class="{{ request()->segment(2) == 'setting' ? 'active' : '' }}">
                    <i class="si si-settings"></i>
                    <span class="text-truncate">{{ __('general.settings') }}</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</div>
