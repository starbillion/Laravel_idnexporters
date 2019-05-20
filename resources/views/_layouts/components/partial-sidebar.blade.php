<nav id="sidebar">
    <div id="sidebar-scroll">
        <div class="sidebar-content">
            <div class="content-header content-header-fullrow bg-gray-lighter">
                <div class="content-header-section text-center align-parent">
                    <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                        <i class="fa fa-times text-danger"></i>
                    </button>

                    <div class="content-header-item">
                        <a href="{{ route('public.index') }}">
                            <img style="height: 34px;" src="{{ asset('img/logo.svg') }}">
                        </a>
                    </div>
                </div>
            </div>

            <div class="content-side content-side-full">
                <ul class="nav-main">
                    @include('_layouts.components.menu-main')
                </ul>
            </div>
        </div>
    </div>
</nav>
