<!doctype html>
<!--[if lte IE 9]>     <html lang="{{ app()->getLocale() }}" class="no-focus lt-ie10 lt-ie10-msg"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="{{ app()->getLocale() }}" class="no-focus"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>@yield('title', config('app.name'))</title>
        <meta name="robots" content="noindex, nofollow">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="assets/img/favicons/favicon.png">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('img/favicons/favicon-192x192.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicons/apple-touch-icon-180x180.png') }}">
        <link rel="stylesheet" id="css-main" href="{{ asset('css/style.css') }}">
        @stack('style')
    </head>
    <body>
        <div id="page-container" class="main-content-boxed">
            <main id="main-container">
                <div class="bg-image" style="background-image: url('https://source.unsplash.com/daily?landscape');">
                    <div class="hero-static bg-white-op-90">
                        <div class="content content-full">
                            <div class="py-30 px-30 text-center">
                                @widget('\App\Widgets\Logo', [
                                    'url'           => 'public.index',
                                    'type'          => 'image',
                                    'image_source'  => 'img/logo.svg',
                                ])
                            </div>
                            @yield('content')
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <script src="{{ asset('js/script.js') }}"></script>
        @stack('script')

        @if (session('status-error'))
        <script type="text/javascript">
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
        </script>
        @endif

        @if (session('status-success'))
        <script type="text/javascript">
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
        </script>
        @endif
    </body>
</html>
