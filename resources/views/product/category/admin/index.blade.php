@extends('_layouts.backend')
@section('title', __('general.category') . ' - Level 1')

@section('content')
@widget('HeaderTools', [
    'search'    => [
        'status' => true,
        'route' => route('admin.product.category.index')
    ],
    'add'       => [
        'status' => true,
        'route' => route('admin.product.category.create')
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
                    @foreach($categories as $category)
                    <tr>
                        <td>
                            <a href="{{ route('admin.product.category.edit', $category->id) }}">
                                <span class="font-w600">{{ $category->name }}</span>
                            </a>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('admin.product.category.edit', $category->id) }}" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="{{ __('general.edit') }}">
                                    <i class="si si-pencil"></i>
                                </a>

                                <a href="javascript:void(0)" class="delete-item btn btn-sm btn-secondary" data-id="{{ $category->id }}" data-toggle="tooltip" title="{{ __('general.delete') }}">
                                    <i class="si si-trash"></i>
                                    <form id="category-destroy-{{ $category->id }}" action="{{ route('admin.product.category.destroy', $category->id) }}" method="POST" style="display: none;">
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
@endsection


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
