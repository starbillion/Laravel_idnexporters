<header id="page-header" class="">
    <div class="content-header">
        <div class="content-header-section">
            <div class="content-header-item">
                <a class="mr-5" href="{{ route('public.index') }}">
                    <img style="height: 45px; margin-top: -6px;" src="{{ asset('img/logo.svg') }}">
                </a>
            </div>
        </div>

        <div class="content-header-section">
            <ul class="nav-main-header">
                @include('_layouts.components.menu-main')
            </ul>
            <button type="button" class="btn btn-dual-secondary" data-toggle="layout" data-action="header_search_on">
                <i class="fa fa-search"></i>
            </button>
            <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none" data-toggle="layout" data-action="sidebar_toggle">
                <i class="fa fa-navicon"></i>
            </button>
        </div>
    </div>

    <div id="page-header-loader" class="overlay-header bg-primary">
        <div class="content-header content-header-fullrow text-center">
            <div class="content-header-item">
                <i class="fa fa-sun-o fa-spin text-white"></i>
            </div>
        </div>
    </div>

    <div id="page-header-search" class="overlay-header">
        <div class="content-header content-header-fullrow">
            <form method="get" action="{{ route('public.search.index') }}">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-secondary px-15" data-toggle="layout" data-action="header_search_off">
                            <i class="fa fa-times"></i>
                        </button>
                    </span>
                    <input type="text" class="form-control" placeholder="Search or hit ESC.." id="page-header-search-input" name="q" value="{{ request()->input('q') }}">
                    <input type="hidden" name="type" value="product">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-secondary px-15">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</header>
