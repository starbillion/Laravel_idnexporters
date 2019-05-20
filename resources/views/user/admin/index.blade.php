@extends('_layouts.backend')
@section('title', __('general.users'))

@section('content')
<div class="row gutters-tiny mb-10">
    <div class="col-md-3">
        <a href="{{ route('admin.user.index.' . request()->segment(3), array_merge(request()->query(), ['status' => null, 'page' => null])) }}" class="block text-right">
            <div class="block-content block-content-full bg-info clearfix">
                <div class="float-left mt-10 d-none d-sm-block">
                    <i class="si si-people fa-3x text-info-light"></i>
                </div>
                <div class="font-size-h3 font-w600 text-white text-truncate">{{ number_format($count['total']) }}</div>
                <div class="font-size-sm font-w600 text-info-light text-uppercase text-truncate">{{ __('product/post.total') }}</div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('admin.user.index.' . request()->segment(3), array_merge(request()->query(), ['status' => 'approved', 'page' => null])) }}" class="block text-right">
            <div class="block-content block-content-full bg-success clearfix">
                <div class="float-left mt-10 d-none d-sm-block">
                    <i class="si si-people fa-3x text-success-light"></i>
                </div>
                <div class="font-size-h3 font-w600 text-white text-truncate">{{ number_format($count['approved']) }}</div>
                <div class="font-size-sm font-w600 text-success-light text-uppercase text-truncate">{{ __('product/post.approved') }}</div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('admin.user.index.' . request()->segment(3), array_merge(request()->query(), ['status' => 'pending', 'page' => null])) }}" class="block text-right">
            <div class="block-content block-content-full bg-warning clearfix">
                <div class="float-left mt-10 d-none d-sm-block">
                    <i class="si si-people fa-3x text-warning-light"></i>
                </div>
                <div class="font-size-h3 font-w600 text-white text-truncate">{{ number_format($count['pending']) }}</div>
                <div class="font-size-sm font-w600 text-warning-light text-uppercase text-truncate">{{ __('product/post.pending') }}</div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('admin.user.index.' . request()->segment(3), array_merge(request()->query(), ['status' => 'rejected', 'page' => null])) }}" class="block text-right">
            <div class="block-content block-content-full bg-danger clearfix">
                <div class="float-left mt-10 d-none d-sm-block">
                    <i class="si si-people fa-3x text-danger-light"></i>
                </div>
                <div class="font-size-h3 font-w600 text-white text-truncate">{{ number_format($count['rejected']) }}</div>
                <div class="font-size-sm font-w600 text-danger-light text-uppercase text-truncate">{{ __('product/post.rejected') }}</div>
            </div>
        </a>
    </div>
</div>
@php
$filters = [
    [
        'name'  => __('user.type'),
        'input' => 'type',
        'data'  => [
            'seller' => __('general.seller'),
            'buyer' => __('general.buyer'),
        ],
    ],
    [
        'name'  => __('user.status'),
        'input' => 'status',
        'data'  => [
            'pending' => __('user.pending'),
            'approved' => __('user.approved'),
        ],
    ]
];

if(request()->input('type') == 'seller'){
    $filters[] = [
        'name'  => 'Membership',
        'input' => 'package',
        'data'  => [
            '1'   => 'Regular',
            '2'  => 'Option 1',
            '3'  => 'Option 2',
            '4'  => 'Option 3',
        ],
    ];
}
@endphp
@widget('HeaderTools', [
    'search'    => [
        'status' => true,
        'route' => route('admin.user.index.' . request()->segment(3))
    ],
    'add'       => [
        'status' => true,
        'route' => route('admin.user.create')
    ],
    'sorts'     => [
        'name'      => __('user.company'),
        'created'   => __('user.created')
    ],
    'filters' => $filters
])

<div class="block block-bordered">
    <div class="block-content">
        <div class="table-responsive">
            <table class="table table-vcenter">
                <thead>
                    <tr>
                        <th width="50%">{{ __('general.name') }}</th>
                        <th>Joined</th>
                        <th>{{ __('user.status') }}</th>
                        <th class="text-center" style="width: 100px;">{{ __('general.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <span class="font-w600"><a href="{{ route('admin.user.edit', $user->id) }}">{{ $user->company ? $user->company : '-' }}</a></span><br>
                            <span class="text-muted">{{ $user->name }}</span><br>
                            <span class="text-muted">
                                @if($user->hasRole('seller'))
                                {{ $user->main_exports }}
                                @else
                                {{ $user->product_interests }}
                                @endif
                            </span>
                        </td>
                        <td>
                            {{ $user->created_at->diffforhumans() }}<br>
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td>
                            @if($user->isPending())
                            <span class="badge badge-warning">{{ __('user.pending') }}</span>
                            @elseif($user->isApproved())
                            <span class="badge badge-success">{{ __('user.approved') }}</span>
                            @elseif($user->isRejected())
                            <span class="badge badge-danger">{{ __('user.rejected') }}</span>
                            @endif

                            @if($user->hasRole('seller'))
                            @if($user->verified_member)
                            <span class="badge badge-danger">{{ __('user.verified_member') }}</span>
                            @endif
                            @if($user->halal)
                            <img src="{{ asset('img/icons/halal.png') }}" style="width: 28px;"></i>
                            @endif
                            @endif
                        </td>
                        <td class="text-right">
                            <div class="btn-group">
                                <a href="#" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#user-{{ $user->id }}">
                                    <i class="si si-eye"></i>
                                </a>
                                 <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="{{ __('general.edit') }}">
                                    <i class="si si-pencil"></i>
                                </a>
                                <a href="javascript:void(0)" class="delete-item btn btn-sm btn-secondary" data-id="{{ $user->id }}" data-toggle="tooltip" title="{{ __('general.delete') }}">
                                    <i class="si si-trash"></i>
                                    <form id="user-destroy-{{ $user->id }}" action="{{ route('admin.user.destroy', $user->id) }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                        <input name="_method" type="hidden" value="DELETE">
                                    </form>
                                </a>

                                @push('modal')
                                <div class="modal fade" id="user-{{ $user->id }}" tabindex="-1" role="dialog">
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
                                                        <div class="block-content block-content-full block-sticky-options pt-30 ribbon ribbon-info">
                                                            <div class="ribbon-box">
                                                                @if($user->hasRole('seller'))
                                                                    {{ __('general.seller') }}
                                                                @else
                                                                    {{ __('general.buyer') }}
                                                                @endif
                                                            </div>
                                                            @if($user->getFirstMediaUrl('logo'))
                                                            <img id="company_logo" class="img-avatar" src="{{ asset($user->getFirstMediaUrl('logo', 'full')) }}" alt="">
                                                            @else
                                                            <img id="company_logo" class="img-avatar" src="{{ asset('img/noimage.png') }}" alt="">
                                                            @endif
                                                        </div>
                                                        <div class="block-content block-content-full block-content-sm bg-body-light border-t border-b">
                                                            <div class="font-w600 mb-5">{{ $user->company }}</div>
                                                            <div class="font-size-sm text-muted">{{ $user->salutation ? __('user.' . $user->salutation) : '' }} {{ $user->name }}</div>
                                                        </div>
                                                        <div class="block-content">
                                                            <div class="row items-push">
                                                                @if($user->hasRole('seller'))
                                                                <div class="col">
                                                                    <div class="mb-5">
                                                                        <i class="si si-badge fa-2x"></i>
                                                                    </div>
                                                                    <div class="font-size-sm text-muted">
                                                                        {{ __('package.' . userPackage($user->id)->type . '.' . userPackage($user->id)->name . '.name') }}
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                <div class="col">
                                                                    @if($user->isApproved())
                                                                    <div class="mb-5">
                                                                        <i class="si si-user fa-2x text-success"></i>
                                                                    </div>
                                                                    <div class="font-size-sm text-success">
                                                                        {{ __('user.approved') }}
                                                                    </div>
                                                                    @elseif($user->isRejected())
                                                                    <div class="mb-5">
                                                                        <i class="si si-user fa-2x text-danger"></i>
                                                                    </div>
                                                                    <div class="font-size-sm text-danger">
                                                                        {{ __('user.rejected') }}
                                                                    </div>
                                                                    @elseif($user->isPending())
                                                                    <div class="mb-5">
                                                                        <i class="si si-user fa-2x text-warning"></i>
                                                                    </div>
                                                                    <div class="font-size-sm text-warning">
                                                                        {{ __('user.pending') }}
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                                @if($user->hasRole('seller'))
                                                                <a class="col" href="{{ route('admin.product.post.index', ['seller' => $user->id]) }}">
                                                                    <div class="mb-5">
                                                                        <i class="si si-layers fa-2x"></i>
                                                                    </div>
                                                                    <div class="font-size-sm text-muted">
                                                                        {{ number_format($user->products->count()) }} {{ __('general.products') }}
                                                                    </div>
                                                                </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="block-content text-left border-t">
                                                            <dl class="row">
                                                                <dt class="col-sm-4">{{ __('user.name') }}</dt>
                                                                <dd class="col-sm-8">{{ $user->salutation ? __('user.' . $user->salutation) : '' }} {{ $user->name }}</dd>
                                                                <dt class="col-sm-4">{{ __('user.company') }}</dt>
                                                                <dd class="col-sm-8">{{ $user->company }}</dd>
                                                                <dt class="col-sm-4">{{ __('user.email') }}</dt>
                                                                <dd class="col-sm-8">{{ $user->email }}</dd>
                                                                <dt class="col-sm-4">{{ __('user.business_types') }}</dt>
                                                                <dd class="col-sm-8">
                                                                    @if($user->business_types)
                                                                    <ul class="list-unstyled mb-0">
                                                                    @foreach($user->business_types as $type)
                                                                        <li>{{ __('user.business_types_data.' . $type) }}</li>
                                                                    @endforeach
                                                                    </ul>
                                                                    @else
                                                                    -
                                                                    @endif
                                                                </dd>
                                                                <dt class="col-sm-4">{{ __('user.established') }}</dt>
                                                                <dd class="col-sm-8">{{ $user->established ? $user->established : '-' }}</dd>
                                                                <dt class="col-sm-4">{{ __('user.city') }}</dt>
                                                                <dd class="col-sm-8">{{ $user->city ? $user->city : '-' }}</dd>
                                                                <dt class="col-sm-4">{{ __('user.postal') }}</dt>
                                                                <dd class="col-sm-8">{{ $user->postal ? $user->postal : '-' }}</dd>
                                                                <dt class="col-sm-4">{{ __('user.country') }}</dt>
                                                                <dd class="col-sm-8">{{ $user->country_id ? $user->country->name : '-' }}</dd>
                                                                <dt class="col-sm-4">{{ __('user.mobile') }}</dt>
                                                                <dd class="col-sm-8">{{ $user->mobile }}</dd>
                                                                <dt class="col-sm-4">{{ __('user.phone') }}</dt>
                                                                <dd class="col-sm-8">
                                                                    @if($user->phone_1 or $user->phone_2)
                                                                    {{ $user->phone_1 ? $user->phone_1 : '' }}
                                                                    {{ $user->phone_2 ? ', ' . $user->phone_2 : '' }}
                                                                    @else
                                                                    -
                                                                    @endif
                                                                </dd>
                                                                <dt class="col-sm-4">{{ __('user.company_email') }}</dt>
                                                                <dd class="col-sm-8">{{ $user->company_email ? $user->company_email : '-' }}</dd>
                                                                <dt class="col-sm-4">{{ __('user.website') }}</dt>
                                                                <dd class="col-sm-8">{{ $user->website ? $user->website : '-' }}</dd>
                                                                <dt class="col-sm-4">{{ __('user.address') }}</dt>
                                                                <dd class="col-sm-8">{{ $user->address ? $user->address : '-' }}</dd>
                                                                <dt class="col-sm-4">{{ __('user.factory_address') }}</dt>
                                                                <dd class="col-sm-8">{{ $user->factory_address ? $user->factory_address : '-' }}</dd>
                                                            </dl>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @if($user->isPending())
                                            <div class="modal-footer">
                                                <form action="{{ route('admin.user.update', $user->id) }}" method="post">
                                                {{ csrf_field() }}
                                                <input name="_method" type="hidden" value="PUT">
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="btn btn-success">{{ __('user.approve') }}</button>
                                                </form>

                                                <form action="{{ route('admin.user.update', $user->id) }}" method="post">
                                                {{ csrf_field() }}
                                                <input name="_method" type="hidden" value="PUT">
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="btn btn-danger">{{ __('user.reject') }}</button>
                                                </form>
                                            </div>
                                            @endif

                                            @if($user->isRejected())
                                            <div class="modal-footer">
                                                <form action="{{ route('admin.user.update', $user->id) }}" method="post">
                                                {{ csrf_field() }}
                                                <input name="_method" type="hidden" value="PUT">
                                                <input type="hidden" name="status" value="pending">
                                                <button type="submit" class="btn btn-warning">{{ __('user.pending') }}</button>
                                                </form>
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

            {!! $users->appends(request()->query())->render() !!}
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
            text: '{{ __('user.alert_delete') }}',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: '{{ __('general.yes') }}',
            cancelButtonText: '{{ __('general.no') }}'
        }).then(function (e) {
            document.getElementById('user-destroy-' + id).submit();
        })
    });
});
</script>
@endpush
