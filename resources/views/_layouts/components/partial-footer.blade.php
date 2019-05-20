<footer id="page-footer" class="bg-primary-dark text-white">
    <div class="content content-full">
        <div class="row items-push-2x mt-30">
            <div class="col-6 col-md-4 mb-0">
                <h3 class="h5 font-w700 text-white">{{ __('general.company') }}</h3>
                <ul class="list list-simple-mini font-size-sm">
                    <li>
                        <a class="link-effect font-w600 text-white" href="{{ route('public.page.show', ['slug' => 'about']) }}">{{ __('general.about') }}</a>
                    </li>
                    <li>
                        <a class="link-effect font-w600 text-white" href="{{ route('public.contact.create') }}">{{ __('general.contact') }}</a>
                    </li>
                    <li>
                        <a class="link-effect font-w600 text-white" href="{{ route('public.news.index') }}">{{ __('general.news') }}</a>
                    </li>
                </ul>
            </div>
            <div class="col-6 col-md-4 mb-0">
                <h3 class="h5 font-w700 text-white">{{ __('general.explore') }}</h3>
                <ul class="list list-simple-mini font-size-sm">
                    @if(Auth::check())
                    <li>
                        <a class="link-effect font-w600 text-white" href="{{ route('dashboard') }}">{{ __('general.dashboard') }}</a>
                    </li>
                    @else
                    <li>
                        <a class="link-effect font-w600 text-white" href="{{ route('login') }}">{{ __('general.login') }}</a>
                    </li>
                    <li>
                        <a class="link-effect font-w600 text-white" href="{{ route('register') }}">{{ __('general.register') }}</a>
                    </li>
                    @endif
                    <li>
                        <a class="link-effect font-w600 text-white" href="{{ route('public.faq.index') }}">{{ __('general.faq') }}</a>
                    </li>
                    <li>
                        <a class="link-effect font-w600 text-white" href="{{ route('public.page.show', 'tos') }}">{{ __('general.tos') }}</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 mb-0">
            <h3 class="h5 font-w700 text-white">{{ config('app.company.name') }}</h3>
                <div class="font-size-sm mb-30">
                    {{ config('app.company.address_1') }}<br>
                    {{ config('app.company.address_2') }}<br>
                    {{ config('app.company.address_3') }}<br>
                    <abbr title="Phone">P:</abbr> {{ config('app.company.phone') }}<br>
                    <abbr title="Phone">F:</abbr> {{ config('app.company.fax') }}
                </div>
            </div>
        </div>
    </div>
</footer>
