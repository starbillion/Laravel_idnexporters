@extends('_layouts.backend')
@section('title', __('general.messages'))

@section('content')

@widget('HeaderTools', [
    'search'    => [
        'status' => false,
    ],
    'add'       => [
        'status' => false,
    ],
    'filters' => [
        [
            'name'  => __('product/post.status'),
            'input' => 'status',
            'data'  => [
                'all' => 'All',
                'pending' => __('message.pending'),
                'approved' => __('message.approved'),
                'deleted' => __('message.deleted'),
            ],
        ],
    ],
])

<div class="block block-bordered">
    <div class="block-content">
        @if(count($threads) > 0)
        <div class="table-responsive">
            <table class="table table-vcenter">
                <thead>
                    <tr>
                        <th>{{ __('message.from') }}</th>
                        <th>{{ __('message.to') }}</th>
                        <th>{{ __('message.status') }}</th>
                        <th class="text-center" style="width: 100px;">{{ __('general.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($threads as $thread)
                    <tr>
                        <td>
                            <span class="font-w600">
                                {{ $thread->users()->withTrashed()->first()->company }}
                                <small class="d-block text-muted">
                                    {{ $thread->users()->withTrashed()->first()->hasRole('seller') ? 'Seller' : 'Buyer' }}
                                </small>
                            </span>
                        </td>
                        <td>
                            <span class="font-w600">
                                {{ $thread->users()->withTrashed()->orderBy('id', 'asc')->first()->company }}
                                <small class="d-block text-muted">
                                    {{ $thread->users()->withTrashed()->orderBy('id', 'asc')->first()->hasRole('seller') ? 'Seller' : 'Buyer' }}
                                </small>
                            </span>
                        </td>
                        <td>
                            @if($thread->deleted_at)
                            <span class="badge badge-danger">{{ __('message.deleted') }}</span>
                            @elseif($thread->status)
                            <span class="badge badge-success">{{ __('message.approved') }}</span>
                            @else
                            <span class="badge badge-warning">{{ __('message.pending') }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="#" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#thread-{{ $thread->id }}">
                                    <i class="si si-eye"></i>
                                </a>

                                @push('modal')
                                <div class="modal fade" id="thread-{{ $thread->id }}" tabindex="-1" role="dialog">
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
                                                    <div class="bg-info-light rounded p-20">
                                                        {{ $thread->messages()->first()->body }}
                                                    </div>
                                                    <small class="text-right d-block mt-5">
                                                        {{ $thread->messages()->first()->user()->withTrashed()->first()->hasRole('seller') ? 'Seller' : 'Buyer' }}
                                                    </small>
                                                </div>
                                            </div>

                                            @if($thread->status == 0 and $thread->deleted_at == null)
                                            <div class="modal-footer">
                                                <form action="{{ route('admin.message.update', $thread->id) }}" method="post">
                                                    {{ csrf_field() }}
                                                    <input name="_method" type="hidden" value="PUT">
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="btn btn-success">{{ __('general.approve') }}</button>
                                                </form>

                                                <form action="{{ route('admin.message.destroy', $thread->id) }}" method="post">
                                                    {{ csrf_field() }}
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="submit" class="btn btn-danger">{{ __('general.delete') }}</button>
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

            {!! $threads->appends(request()->query())->render() !!}
        </div>
        @else
        <div class="alert alert-info" role="alert">{{ __('message.no_message') }}</div>
        @endif
    </div>
</div>
@endsection


@push('script')
<script type="text/javascript">
$(function(){
    $('.delete-item').on('click', function(){
        var id = $(this).data('id');

        swal({
            text: '{{ __('faq.post_data.alert_delete') }}',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: '{{ __('general.yes') }}',
            cancelButtonText: '{{ __('general.no') }}'
        }).then(function (e) {
            document.getElementById('post-destroy-' + id).submit();
        })
    });
});
</script>
@endpush
