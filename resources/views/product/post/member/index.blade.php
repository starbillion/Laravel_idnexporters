@extends('_layouts.backend')
@section('title', __('general.products'))

@section('content')
<div class="row">
    <div class="col-md-4">
        <a href="{{ route('member.product.post.index', array_merge(request()->query(), ['status' => null, 'page' => null])) }}" class="block text-right">
            <div class="block-content block-content-full bg-info clearfix">
                <div class="float-left mt-10 d-none d-sm-block">
                    <i class="si si-layers fa-3x text-info-light"></i>
                </div>
                <div class="font-size-h3 font-w600 text-white">{{ number_format($count['total']) }}</div>
                <div class="font-size-sm font-w600 text-info-light text-uppercase">{{ __('product/post.total') }}</div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('member.product.post.index', array_merge(request()->query(), ['status' => 'approved', 'page' => null])) }}" class="block text-right">
            <div class="block-content block-content-full bg-success clearfix">
                <div class="float-left mt-10 d-none d-sm-block">
                    <i class="si si-layers fa-3x text-success-light"></i>
                </div>
                <div class="font-size-h3 font-w600 text-white">{{ number_format($count['approved']) }}</div>
                <div class="font-size-sm font-w600 text-success-light text-uppercase">{{ __('product/post.approved') }}</div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('member.product.post.index', array_merge(request()->query(), ['status' => 'pending', 'page' => null])) }}" class="block text-right">
            <div class="block-content block-content-full bg-warning clearfix">
                <div class="float-left mt-10 d-none d-sm-block">
                    <i class="si si-layers fa-3x text-warning-light"></i>
                </div>
                <div class="font-size-h3 font-w600 text-white">{{ number_format($count['pending']) }}</div>
                <div class="font-size-sm font-w600 text-warning-light text-uppercase">{{ __('product/post.pending') }}</div>
            </div>
        </a>
    </div>
</div>

@widget('HeaderTools', [
    'search'    => [
        'status' => true,
        'route' => route('member.product.post.index')
    ],
    'add'       => [
        'status' => (Auth::user()->subscription('main')->ability()->remainings('products') <= 0 or isRequestPackage()) ? false : true,
        'route' => route('member.product.post.create')
    ],
    'sorts'     => [
        'name'          => __('product/post.name'),
        'created_at'    => __('product/post.created')
    ],
    'filters' => [
        [
            'name'  => 'Status',
            'input' => 'status',
            'data'  => [
                'active' => 'Active',
            ],
        ],
    ],
])

<div class="block block-bordered">
    <div class="block-content">
        <div class="table-responsive">
            <table class="table table-vcenter">
                <thead>
                    <tr>
                        <th width="50%">{{ __('general.name') }}</th>
                        <th>{{ __('product/post.status') }}</th>
                        <th>{{ __('general.created') }}</th>
                        <th class="text-center" style="width: 100px;">{{ __('general.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            <span class="font-w600">{{ $product->name }}</span>
                        </td>
                        <td>
                            @if($product->isPending())
                            <span class="badge badge-warning">{{ __('product/post.pending') }}</span>
                            @elseif($product->isApproved())
                            <span class="badge badge-success">{{ __('product/post.approved') }}</span>
                            @endif
                        </td>
                        <td>
                            {{ $product->created_at->diffForHumans() }}
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('member.product.post.edit', $product->id) }}" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="{{ __('general.edit') }}">
                                    <i class="si si-pencil"></i>
                                </a>
                                <a href="javascript:void(0)" class="delete-item btn btn-sm btn-secondary" data-id="{{ $product->id }}" data-toggle="tooltip" title="{{ __('general.delete') }}">
                                    <i class="si si-trash"></i>
                                    <form id="product-destroy-{{ $product->id }}" action="{{ route('member.product.post.destroy', $product->id) }}" method="POST" style="display: none;">
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

            {!! $products->appends(request()->query())->render() !!}
        </div>
    </div>
</div>
@endsection

@push('script')
<script type="text/javascript">
$(function(){
	@if(hasPermission('delete-product'))
	$('.delete-item').on('click', function(){
		var id = $(this).data('id');

		swal({
			text: '{{ __('product/post.alert_delete') }}',
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: '{{ __('general.yes') }}',
			cancelButtonText: '{{ __('general.no') }}'
		}).then(function (e) {
			document.getElementById('product-destroy-' + id).submit();
		})
	});
	@endif
});
</script>
@endpush
