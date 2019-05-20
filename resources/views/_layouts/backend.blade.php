<!doctype html>
<!--[if lte IE 9]>     <html lang="{{ app()->getLocale() }}" class="no-focus lt-ie10 lt-ie10-msg"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="{{ app()->getLocale() }}" class="no-focus"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>
        @if(request()->segment(1) == null)
            {{ config('app.name') }} - {{ config('app.tagline') }}
        @else
            @yield('title', config('app.name')) - {{ config('app.name') }}
        @endif
        </title>
        <meta name="robots" content="noindex, nofollow">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="assets/img/favicons/favicon.png">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('img/favicons/favicon-192x192.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicons/apple-touch-icon-180x180.png') }}">
        <link rel="stylesheet" id="css-main" href="{{ asset('css/style.css') }}">
        @stack('style')
    </head>
    <body>
        <div id="page-container" class="side-scroll page-header-fixed main-content-boxed bg-gray-lighter">
            @include('_layouts.components.partial-sidebar')
            @include('_layouts.components.partial-header')
            <main id="main-container">
                <div class="content content-full pt-50 pb-50">
                    <div class="row">
                        <div class="col-md-3">
                            @if (Auth::user()->hasRole('seller') or Auth::user()->hasRole('buyer'))
                            @widget('SidebarMember')
                            @else
                            @widget('SidebarAdmin')
                            @endif
                        </div>
                        <div class="col-md-9">
                            <h2 class="content-heading pt-0">@yield('title')</h2>
                            @yield('content')
                        </div>
                    </div>
                </div>
            </main>
            @include('_layouts.components.partial-footer')
        </div>

        @widget('AuthModal')
        <div class="modal fade" id="upgrade_required" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">{{ __('general.upgrade_required') }}</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content block-content-full">
                            {{ __('general.upgrade_required_content') }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('general.close') }}</button>
                        <a href="{{ route('member.package.index') }}" class="btn btn-danger">{{ __('general.see_options') }}</a>
                    </div>
                </div>
            </div>
        </div>
        @stack('modal')

        <script src="{{ asset('js/script.js') }}"></script>
        @stack('script')

        <script type="text/javascript">
        @if (session('status-error'))

            $(function(){
                $.notify({
                    message: '{{ session('status-error') }}',
                },{
                    type: "danger",
                    placement: {
                        from: "top",
                        align: "center"
                    },
                });
            });
        @endif

        @if (session('status-success'))
            $(function(){
                $.notify({
                    message: '{{ session('status-success') }}',
                },{
                    type: "success",
                    placement: {
                        from: "top",
                        align: "center"
                    },
                });
            });
        @endif
        </script>
    </body>
</html>
