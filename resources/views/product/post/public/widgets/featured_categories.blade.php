<h5>{{ __('general.featured_categories') }}</h5>
<div class="row">
    @foreach($categories as $category)
    <div class="col-md-3 col-xl-3 align-self-stretch mb-20">
        <a class="block block-link-pop text-center h-100" href="javascript:void(0)">
            <div class="bg-image h-100" style="background-image: url('https://source.unsplash.com/200x200?{{ strtolower(str_replace(' ', ',', str_replace('-', ',', $category->name))) }}">
                <div class="block-content block-content-full bg-black-op ribbon ribbon-bottom ribbon-crystal h-100">
                    <div class="text-center py-20">
                        <h6 class="font-w700 text-white text-uppercase mb-0 align-middle">
                            {{ $category->name }}
                        </h6>
                    </div>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>
