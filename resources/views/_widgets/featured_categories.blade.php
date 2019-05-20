<h5>{{ __('general.featured_categories') }}</h5>
<div class="row">
    @foreach($categories as $category)
    <div class="col-md-3 col-xl-3 align-self-stretch mb-20">
        <a class="block block-link-pop text-center h-100" href="{{ route('public.product.index', ['category' => $category->id]) }}">
            <div class="bg-image h-100" style="background-image: url('{{ asset('img/categories/' . strtolower(str_slug($category->name, '_')) . '.jpg') }}'); background-position: center;">
                <div class="block-content block-content-full bg-black-op h-100">
                    <div class="text-center py-20 h-100 w-100" style="position: relative; display: table;">
                        <h6 class="font-w700 text-white text-uppercase text-center w-100 mb-0" style="vertical-align: middle; display: table-cell;">
                            {{ $category->name }}
                        </h6>
                    </div>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>
