@extends('_layouts.backend')
@section('title', __('general.category') . ' - '. __('general.edit'))

@section('content')
<div class="mb-20">
    <nav class="nav">
        @foreach($ancestors as $key => $ancestor)
        <a class="nav-link active" href="{{ route('admin.product.category.edit', $ancestor->id) }}">
            @if($key == 0)
            <small class="d-block text-muted">Level 1</small>
            @elseif($key == 1)
            <small class="d-block text-muted">Level 2</small>
            @endif

            {{ $ancestor->name }}
        </a>
        @endforeach
        <a class="nav-link disabled" href="#">
            @if(count($ancestors) == 0)
            <small class="d-block text-muted">Level 1</small>
            @elseif(count($ancestors) == 1)
            <small class="d-block text-muted">Level 2</small>
            @elseif(count($ancestors) == 2)
            <small class="d-block text-muted">Level 3</small>
            @endif
            {{ $category->name }}
        </a>
    </nav>
</div>

<div class="block block-bordered">
    <form action="{{ route('admin.product.category.update', $category->id) }}" method="post">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="block-content block-content-full">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group{{ $errors->has('name') ? ' is-invalid' : '' }}">
                        <label for="field-name">{{ __('product/category.name') }}</label>
                        <input type="text" class="form-control" id="field-name" name="name" value="{{ old('name', $category->name) }}">
                        <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    </div>
                </div>
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

@if(count($ancestors) < 2)
<h2 class="content-heading">
    @if(count($ancestors) == 0)
    Level 2
    @elseif(count($ancestors) == 1)
    Level 3
    @endif
</h2>

@widget('HeaderTools', [
    'search'    => [
        'status' => true,
        'route' => route('admin.product.category.edit', $category->id)
    ],
    'add'       => [
        'status' => true,
        'route' => route('admin.product.category.create', ['parent' => $category->id])
    ],
    'sorts'     => [
        'name'      => __('product/category.name'),
        'created_at'   => __('product/category.created')
    ],
])

<div class="block block-bordered">
    <div class="block-content">
        <div class="table-responsive">
            <table class="table table-vcenter">
                <thead>
                    <tr>
                        <th>{{ __('product/category.name') }}</th>
                        <th class="text-center" style="width: 100px;">{{ __('general.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $c)
                    <tr>
                        <td>
                            <a href="{{ route('admin.product.category.edit', $c->id) }}">
                                <span class="font-w600">{{ $c->name }}</span>
                            </a>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('admin.product.category.edit', $c->id) }}" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="{{ __('general.edit') }}">
                                    <i class="si si-pencil"></i>
                                </a>

                                <a href="javascript:void(0)" class="delete-item btn btn-sm btn-secondary" data-id="{{ $c->id }}" data-toggle="tooltip" title="{{ __('general.delete') }}">
                                    <i class="si si-trash"></i>
                                    <form id="category-destroy-{{ $c->id }}" action="{{ route('admin.product.category.destroy', ['id' => $c->id, 'parent' => $category->id]) }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                        <input name="_method" type="hidden" value="DELETE">
                                    </form>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {!! $categories->appends(request()->query())->render() !!}
        </div>
    </div>
</div>
@endif
@endsection


@if(count($ancestors) < 2)
@push('script')
<script type="text/javascript">
$(function(){
    $('.delete-item').on('click', function(){
        var id = $(this).data('id');

        swal({
            text: '{{ __('product/category.alert_delete') }}',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: '{{ __('general.yes') }}',
            cancelButtonText: '{{ __('general.no') }}'
        }).then(function (e) {
            document.getElementById('category-destroy-' + id).submit();
        })
    });
});
</script>
@endpush
@endif
