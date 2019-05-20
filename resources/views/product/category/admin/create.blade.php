@extends('_layouts.backend')
@section('title', __('general.category') . ' - '. __('general.add'))

@section('content')
<div class="block block-bordered">
    <form action="{{ route('admin.product.category.store', request()->input('parent') ? ['parent' => request()->input('parent')] : null) }}" method="post">
        {{ csrf_field() }}
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                        <label for="field-name">{{ __('product/category.name') }}</label>
                        <input type="text" class="form-control" id="field-name" name="name" value="{{ old('name') }}">
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    </div>
                </div>

                @if(isset($ancestors))
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="field-name">Under</label>

                        <ul class="list-inline">
                        @foreach($ancestors as $ancestor)
                            <li class="list-inline-item">{{ $ancestor->name }} &nbsp;/</li>
                        @endforeach
                        <li class="list-inline-item">{{ $category->name }}</li>
                        </ul>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="block-content block-content-full bg-gray-lighter">
            <div class="row">
                <div class="col-auto mr-auto">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">{{ __('general.save') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
