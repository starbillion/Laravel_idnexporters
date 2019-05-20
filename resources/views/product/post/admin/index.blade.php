@extends('_layouts.backend')
@section('title', __('general.products'))

@section('content')
<div class="row gutters-tiny mb-10">
    <div class="col-md-3">
        <a href="{{ route('admin.product.post.index', array_merge(request()->query(), ['status' => null, 'page' => null])) }}" class="block text-right">
            <div class="block-content block-content-full bg-info clearfix">
                <div class="float-left mt-10 d-none d-sm-block">
                    <i class="si si-layers fa-3x text-info-light"></i>
                </div>
                <div class="font-size-h3 font-w600 text-white text-truncate">{{ number_format($count['total']) }}</div>
                <div class="font-size-sm font-w600 text-info-light text-uppercase text-truncate">{{ __('product/post.total') }}</div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('admin.product.post.index', array_merge(request()->query(), ['status' => 'approved', 'page' => null])) }}" class="block text-right">
            <div class="block-content block-content-full bg-success clearfix">
                <div class="float-left mt-10 d-none d-sm-block">
                    <i class="si si-layers fa-3x text-success-light"></i>
                </div>
                <div class="font-size-h3 font-w600 text-white text-truncate">{{ number_format($count['approved']) }}</div>
                <div class="font-size-sm font-w600 text-success-light text-uppercase text-truncate">{{ __('product/post.approved') }}</div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('admin.product.post.index', array_merge(request()->query(), ['status' => 'pending', 'page' => null])) }}" class="block text-right">
            <div class="block-content block-content-full bg-warning clearfix">
                <div class="float-left mt-10 d-none d-sm-block">
                    <i class="si si-layers fa-3x text-warning-light"></i>
                </div>
                <div class="font-size-h3 font-w600 text-white text-truncate">{{ number_format($count['pending']) }}</div>
                <div class="font-size-sm font-w600 text-warning-light text-uppercase text-truncate">{{ __('product/post.pending') }}</div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('admin.product.post.index', array_merge(request()->query(), ['status' => 'rejected', 'page' => null])) }}" class="block text-right">
            <div class="block-content block-content-full bg-danger clearfix">
                <div class="float-left mt-10 d-none d-sm-block">
                    <i class="si si-layers fa-3x text-danger-light"></i>
                </div>
                <div class="font-size-h3 font-w600 text-white text-truncate">{{ number_format($count['rejected']) }}</div>
                <div class="font-size-sm font-w600 text-danger-light text-uppercase text-truncate">{{ __('product/post.rejected') }}</div>
            </div>
        </a>
    </div>
</div>

@widget('HeaderTools', [
    'search'    => [
        'status' => true,
        'route' => route('admin.product.post.index')
    ],
    'sorts'     => [
        'user_id'   => __('product/post.owner'),
        'name'      => __('product/post.name'),
        'created'   => __('product/post.created')
    ],
    'filters' => [
        [
            'name'  => __('product/post.status'),
            'input' => 'status',
            'data'  => [
                'pending' => __('product/post.pending'),
                'approved' => __('product/post.approved'),
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
                        <th>Created</th>
                        <th>{{ __('product/post.status') }}</th>
                        <th class="text-center" style="width: 100px;">{{ __('general.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            <a href="{{ route('admin.product.post.edit', $product->id) }}">
                                <span class="font-w600">{{ $product->name }}</span>
                            </a><br>
                            <span>{{ $product->owner->company }}</span>
                        </td>
                        <td>
                            {{ $product->created_at->diffforhumans() }}<br>
                            {{ $product->created_at->format('d M Y') }}
                        </td>
                        <td>
                            @if($product->isPending())
                            <span class="badge badge-warning">{{ __('product/post.pending') }}</span>
                            @elseif($product->isApproved())
                            <span class="badge badge-success">{{ __('product/post.approved') }}</span>
                            @elseif($product->isRejected())
                            <span class="badge badge-danger">{{ __('product/post.rejected') }}</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <div class="btn-group">
                                <a href="#" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#product-{{ $product->id }}">
                                    <i class="si si-eye"></i>
                                </a>
                                <a href="{{ route('admin.product.post.edit', $product->id) }}" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="{{ __('general.edit') }}">
                                    <i class="si si-pencil"></i>
                                </a>
                                <a href="javascript:void(0)" class="delete-item btn btn-sm btn-secondary" data-id="{{ $product->id }}" data-toggle="tooltip" title="{{ __('general.delete') }}">
                                    <i class="si si-trash"></i>
                                    <form id="product-destroy-{{ $product->id }}" action="{{ route('admin.product.post.destroy', $product->id) }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                        <input name="_method" type="hidden" value="DELETE">
                                    </form>
                                </a>

                                @push('modal')
                                <div class="modal fade" id="product-{{ $product->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="block block-themed block-transparent mb-0">
                                                <div class="block-header bg-primary-dark">
                                                    <h3 class="block-title">{{ __('general.detail') }}</h3>
                                                    <div class="block-options">
                                                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                            <i class="si si-close"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="block-content block-content-full">
                                                    <div class="block block-bordered text-center">
                                                        <div class="block-content block-content-full block-sticky-options pt-30">
                                                            @if($product->getFirstMediaUrl('product'))
                                                            <img id="company_logo" class="img-avatar" src="{{ asset($product->getFirstMediaUrl('product')) }}" alt="">
                                                            @else
                                                            <img id="company_logo" class="img-avatar" src="{{ asset('img/noimage.png') }}" alt="">
                                                            @endif
                                                        </div>
                                                        <div class="block-content block-content-full block-content-sm bg-body-light border-t border-b">
                                                            <div class="font-w600 mb-5">{{ $product->name }}</div>
                                                            <div class="font-size-sm text-muted">{{ $product->category->name }}</div>
                                                        </div>
                                                        <div class="block-content">
                                                            <div class="row items-push">
                                                                <div class="col">
                                                                    @if($product->isApproved())
                                                                    <div class="mb-5">
                                                                        <i class="si si-layers fa-2x text-success"></i>
                                                                    </div>
                                                                    <div class="font-size-sm text-success">
                                                                        {{ __('product/post.approved') }}
                                                                    </div>
                                                                    @elseif($product->isRejected())
                                                                    <div class="mb-5">
                                                                        <i class="si si-layers fa-2x text-danger"></i>
                                                                    </div>
                                                                    <div class="font-size-sm text-danger">
                                                                        {{ __('product/post.rejected') }}
                                                                    </div>
                                                                    @elseif($product->isPending())
                                                                    <div class="mb-5">
                                                                        <i class="si si-layers fa-2x text-warning"></i>
                                                                    </div>
                                                                    <div class="font-size-sm text-warning">
                                                                        {{ __('product/post.pending') }}
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="block-content text-left border-t">
                                                            <dl class="row">
                                                                <dt class="col-sm-4">{{ __('product/post.owner') }}</dt>
                                                                <dd class="col-sm-8">{{ $product->owner->company }}</dd>
                                                                <dt class="col-sm-4">{{ __('product/post.name') }}</dt>
                                                                <dd class="col-sm-8">{{ $product->name }}</dd>
                                                                <dt class="col-sm-4">{{ __('product/post.category') }}</dt>
                                                                <dd class="col-sm-8">{{ $product->category->name }}</dd>
                                                                <dt class="col-sm-4">{{ __('product/post.currency') }}</dt>
                                                                <dd class="col-sm-8">{{ $product->currency ? $product->currency->name : '-' }}</dd>
                                                                <dt class="col-sm-4">{{ __('product/post.price') }}</dt>
                                                                <dd class="col-sm-8">{{ $product->price ? $product->price : '-' }}</dd>
                                                                <dt class="col-sm-4">{{ __('product/post.description_en') }}</dt>
                                                                <dd class="col-sm-8">{!! $product->description_en ? strip_tags($product->description_en) : '-' !!}</dd>
                                                                <dt class="col-sm-4">{{ __('product/post.description_id') }}</dt>
                                                                <dd class="col-sm-8">{!! $product->description_id ? strip_tags($product->description_id) : '-' !!}</dd>
                                                                <dt class="col-sm-4">{{ __('product/post.description_zh') }}</dt>
                                                                <dd class="col-sm-8">{!! $product->description_zh ? strip_tags($product->description_zh) : '-' !!}</dd>
                                                                <dt class="col-sm-4">{{ __('product/post.supply_ability') }}</dt>
                                                                <dd class="col-sm-8">{{ $product->supply_ability ? $product->supply_ability : '-' }}</dd>
                                                                <dt class="col-sm-4">{{ __('product/post.fob_port') }}</dt>
                                                                <dd class="col-sm-8">{{ $product->fob_port ? $product->fob_port : '-' }}</dd>
                                                                <dt class="col-sm-4">{{ __('product/post.payment_term') }}</dt>
                                                                <dd class="col-sm-8">{{ $product->payment_term ? $product->payment_term : '-' }}</dd>
                                                                <dt class="col-sm-4">{{ __('product/post.minimum_order') }}</dt>
                                                                <dd class="col-sm-8">{{ $product->minimum_order ? $product->minimum_order : '-' }}</dd>
                                                            </dl>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @if($product->owner->isApproved())
                                                @if($product->isPending())
                                                <div class="modal-footer">
                                                    <form action="{{ route('admin.product.post.update', $product->id) }}" method="post">
                                                    {{ csrf_field() }}
                                                    <input name="_method" type="hidden" value="PUT">
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="btn btn-success">{{ __('product/post.approve') }}</button>
                                                    </form>

                                                    <form action="{{ route('admin.product.post.update', $product->id) }}" method="post">
                                                    {{ csrf_field() }}
                                                    <input name="_method" type="hidden" value="PUT">
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="btn btn-danger">{{ __('product/post.reject') }}</button>
                                                    </form>
                                                </div>
                                                @endif
                                            @else
                                                <div class="modal-footer">
                                                    <div class="text-danger py-20">{!! __('product/post.alert_user_approval') !!}</div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endpush
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
