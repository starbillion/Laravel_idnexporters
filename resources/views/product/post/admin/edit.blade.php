@extends('_layouts.backend')
@section('title', __('general.products') . ' - '. __('general.edit'))

@section('content')
<nav class="breadcrumb bg-white push">
    <a class="breadcrumb-item" href="{{ route('admin.product.post.index') }}">{{ __('general.products') }}</a>
    <span class="breadcrumb-item active text-muted">{{ __('general.edit') }}</span>
</nav>

<div class="block block-bordered">
    <form action="{{ route('admin.product.post.update', $product->id) }}" method="post">
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PUT">
        <div class="block-content block-content-full tab-content">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                        <label for="field-name">{{ __('product/post.name') }}</label>
                        <input type="text" class="form-control" id="field-name" name="name" value="{{ old('name', $product->name) }}">
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group{{ $errors->has('currency_id') ? ' is-invalid' : '' }}">
                        <label for="field-currency_id">{{ __('product/post.currency') }}</label>
                        <select class="js-select2 form-control" id="field-currency_id" name="currency_id" style="width: 100%;" data-placeholder="{{ __('general.choose') }}">
                            <option></option>
                            @foreach($currencies as $currency)
                            <option value="{{ $currency->id }}" {{ (old('currency_id') == $currency->id or $product->currency_id == $currency->id) ? 'selected' : '' }}>{{ $currency->code }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">{{ $errors->first('currency_id') }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('price') ? ' is-invalid' : '' }}">
                        <label for="field-price">{{ __('product/post.price') }}</label>
                        <input type="text" class="form-control" id="field-price" name="price" value="{{ old('price', $product->price) }}">
                        <div class="invalid-feedback">{{ $errors->first('price') }}</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('category_id-1') ? ' is-invalid' : '' }}">
                        <label for="field-category_id-1">Category - 1 Level</label>
                        <select class="js-select2 form-control" id="field-category_id-1" name="category_id-1" style="width: 100%;" data-placeholder="{{ __('general.choose') }}">
                            <option></option>
                            @foreach($categories['data'][1] as $category)
                            <option value="{{ $category->id }}" {{ $categories['selected'][1] == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">{{ $errors->first('category_id-1') }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('category_id-2') ? ' is-invalid' : '' }}">
                        <label for="field-category_id-2">Category - 2 Level</label>
                        <select class="js-select2 form-control" id="field-category_id-2" name="category_id-2" style="width: 100%;" data-placeholder="{{ __('general.choose') }}">
                            <option></option>
                            @foreach($categories['data'][2] as $category)
                            <option value="{{ $category->id }}" {{ $categories['selected'][2] == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">{{ $errors->first('category_id-2') }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('category_id-3') ? ' is-invalid' : '' }}">
                        <label for="field-category_id-3">Category - 3 Level</label>
                        <select class="js-select2 form-control" id="field-category_id-3" name="category_id-3" style="width: 100%;" data-placeholder="{{ __('general.choose') }}">
                            <option></option>
                            @foreach($categories['data'][3] as $category)
                            <option value="{{ $category->id }}" {{ $categories['selected'][3] == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">{{ $errors->first('category_id-3') }}</div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group{{ $errors->has('supply_ability') ? ' is-invalid' : '' }}">
                        <label for="field-supply_ability">{{ __('product/post.supply_ability') }}</label>
                        <input type="text" class="form-control" id="field-supply_ability" name="supply_ability" value="{{ old('supply_ability', $product->supply_ability) }}">
                        <div class="invalid-feedback">{{ $errors->first('supply_ability') }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group{{ $errors->has('fob_port') ? ' is-invalid' : '' }}">
                        <label for="field-fob_port">{{ __('product/post.fob_port') }}</label>
                        <input type="text" class="form-control" id="field-fob_port" name="fob_port" value="{{ old('fob_port', $product->fob_port) }}">
                        <div class="invalid-feedback">{{ $errors->first('fob_port') }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group{{ $errors->has('payment_term') ? ' is-invalid' : '' }}">
                        <label for="field-payment_term">{{ __('product/post.payment_term') }}</label>
                        <input type="text" class="form-control" id="field-payment_term" name="payment_term" value="{{ old('payment_term', $product->payment_term) }}" placeholder="{{ __('product/post.payment_term_placeholder') }}">
                        <div class="invalid-feedback">{{ $errors->first('payment_term') }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group{{ $errors->has('minimum_order') ? ' is-invalid' : '' }}">
                        <label for="field-minimum_order">{{ __('product/post.minimum_order') }}</label>
                        <input type="text" class="form-control" id="field-minimum_order" name="minimum_order" value="{{ old('minimum_order', $product->minimum_order) }}">
                        <div class="invalid-feedback">{{ $errors->first('minimum_order') }}</div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group{{ $errors->has('description_en') ? ' is-invalid' : '' }}">
                        <label for="field-description_en">{{ __('product/post.description_en') }}</label>
                        <textarea class="form-control field_description" name="description_en" rows="6">{!! e(old('description_en', $product->description_en)) !!}</textarea>
                        <div class="invalid-feedback">{{ $errors->first('description_en') }}</div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group{{ $errors->has('description_id') ? ' is-invalid' : '' }}">
                        <label for="field-description_id">{{ __('product/post.description_id') }}</label>
                        <textarea class="form-control field_description" name="description_id" rows="6">{{ old('description_id', $product->description_id) }}</textarea>
                        <div class="invalid-feedback">{{ $errors->first('description_id') }}</div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group{{ $errors->has('description_zh') ? ' is-invalid' : '' }}">
                        <label for="field-description_zh">{{ __('product/post.description_zh') }}</label>
                        <textarea class="form-control field_description" name="description_zh" rows="6">{{ old('description_zh', $product->description_zh) }}</textarea>
                        <div class="invalid-feedback">{{ $errors->first('description_zh') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block-content block-content-full bg-gray-lighter border-t">
            <div class="row">
                <div class="p-2 mr-auto">
                    <label class="css-control css-control-success css-switch">
                        <input type="hidden" name="publish" value="0">
                        <input type="checkbox" name="publish" class="css-control-input" value="1" {{ old('publish', $product->publish) ? 'checked' : '' }}>
                        <span class="css-control-indicator"></span> {{ __('product/post.publish') }}
                    </label>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">{{ __('general.save') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection


@push('script')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lodash@4.17.4/lodash.min.js"></script>
<script type="text/javascript" src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script type="text/javascript">
    $(function(){
        getData(1);
        getData(2);

        function getData(wrapper){
            var field = "#field-category_id-" + wrapper;

            $(field).on('change', function(){
                if(wrapper == 1){
                    $('#field-category_id-2').html('<option></option>');
                    $('#field-category_id-3').html('<option></option>');
                }
                else if(wrapper == 2){
                    $('#field-category_id-3').html('<option></option>');
                }

                $.ajax({
                    method: "GET",
                    url: '{{ route('ajax.product.category.show', null) }}/' + $(field).val(),
                    error: function(jqXHR, textStatus, errorThrown){
                        console.log('error');
                    },
                    success: function (data, textStatus, jqXHR){
                        var data = _.map(data, function(obj) { return { id: obj.id, text: obj.name }});

                        if(wrapper == 1){
                            $('#field-category_id-2').select2({ data: data });
                            getData(2);
                        }
                        else if(wrapper == 2){
                            $('#field-category_id-3').select2({ data: data });
                        }
                    },
                });
            });
        }

        $('.field_description').summernote({
            height: 200,
            tooltip: false,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol']],
                ['insert', ['table', 'hr']]
            ]
        });
    })
</script>
@endpush

@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
@endpush
