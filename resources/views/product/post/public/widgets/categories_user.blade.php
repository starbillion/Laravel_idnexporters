<div class="block block-bordered mb-20">
    <div class="block-header block-header-default border-b">
        <h3 class="block-title">{{ __('product/category.refine_by_categories') }}</h3>
    </div>

    <div class="block-content block-content-full">
        <ul class="nav-main">
            <li>
                <a class="pl-20 {{ request()->input('category') ? '' : 'active' }}" href="{{ $route ? route($route) : route('public.product.index') }}">{{ __('product/post.featured') }}</a>
            </li>
        </ul>
        <hr>
        <ul class="nav-main">
            @foreach($categories as $category)
                @if(isset($category['children']))
                    <li class="open">
                        <a class="d-flex flex-row justify-content-between align-items-center pl-20 active"
                        href="{{ $route ? route($route, ['category' => $category['category']->id]) : route('public.product.index', ['category' => $category['category']->id]) }}"
                        ">
                            {{ $category['category']->name }}
                            @if(!$route)
                            <span class="badge badge-pill badge-secondary float-right">{{ $category['count'] }}</span>
                            @endif
                        </a>

                        <ul>
                            @foreach($category['children'] as $category)
                                @if(isset($category['children']))
                                <li class="open">
                                    <a class="d-flex flex-row justify-content-between align-items-center active" href="{{ $route ? route($route, ['category' => $category['category']->id]) : route('public.product.index', ['category' => $category['category']->id]) }}">
                                        <span class="pr-5">{{ $category['category']->name }}</span>
                                        @if(!$route)
                                        <span class="badge badge-pill badge-secondary float-right align-middle">{{ $category['count'] }}</span>
                                        @endif
                                    </a>

                                    <ul>
                                    @foreach($category['children'] as $category)
                                        <li>
                                            <a class="d-flex flex-row justify-content-between align-items-center {{ $selected == $category['category']->id ? 'active' : '' }}" href="{{ $route ? route($route, ['category' => $category['category']->id]) : route('public.product.index', ['category' => $category['category']->id]) }}">
                                                <span class="pr-5">{{ $category['category']->name }}</span>
                                                @if(!$route)
                                                <span class="badge badge-pill badge-secondary float-right align-middle">{{ $category['count'] }}</span>
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                    </ul>
                                </li>
                                @else
                                <li>
                                    <a class="d-flex flex-row justify-content-between align-items-center" href="{{ $route ? route($route, ['category' => $category['category']->id]) : route('public.product.index', ['category' => $category['category']->id]) }}">
                                        <span class="pr-5">{{ $category['category']->name }}</span>
                                        @if(!$route)
                                        <span class="badge badge-pill badge-secondary float-right align-middle">{{ $category['count'] }}</span>
                                        @endif
                                    </a>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li>
                        <a class="d-flex flex-row justify-content-between align-items-center pl-20" href="{{ $route ? route($route, ['category' => $category['category']->id]) : route('public.product.index', ['category' => $category['category']->id]) }}">
                            {{ $category['category']->name }}
                            @if(!$route)
                            <span class="badge badge-pill badge-secondary float-right">{{ $category['count'] }}</span>
                            @endif
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
