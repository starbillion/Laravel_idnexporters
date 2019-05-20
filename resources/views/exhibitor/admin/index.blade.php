@extends('_layouts.backend')
@section('title', __('general.exhibitors'))

@section('content')
@widget('HeaderTools', [
    'search'    => [
        'status' => true,
        'route' => route('admin.exhibitor.index')
    ],
    'add'       => [
        'status' => true,
        'route' => route('admin.exhibitor.create')
    ],
    'sorts'     => [
        'name'      => __('exhibitor.name'),
        'created'   => __('exhibitor.created')
    ],
])

<div class="block block-bordered">
    <div class="block-content">
        <div class="table-responsive">
            <table class="table table-vcenter">
                <thead>
                    <tr>
                        <th>{{ __('exhibitor.name') }}</th>
                        <th class="text-center" style="width: 100px;">{{ __('general.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr>
                        <td>
                            <a href="{{ route('admin.exhibitor.edit', $post->id) }}">
                                <span class="font-w600">{{ $post->name }}</span>
                            </a>

                            @php
                            $exhibitors_count = $post->exhibitions()->count()
                            @endphp

                            <a class="d-block" href="#" data-toggle="modal" data-target="#modal_exhibitions_{{ $post->id }}">
                                {{ $exhibitors_count }} {{ str_plural(__('general.exhibition'), $exhibitors_count) }}
                            </a>

                            @push('modal')
                            <div class="modal fade" id="modal_exhibitions_{{ $post->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">{{ $post->name }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <ul class="list-group">
                                            @foreach($post->exhibitions as $exhibition)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <a href="{{ route('admin.exhibition_assign.edit', [$exhibition->id, $post->id]) }}">
                                                        {{ $exhibition->title }}
                                                    </a>

                                                    @if($exhibition->pivot->booth)
                                                    <span class="badge badge-primary badge-pill">{{ $exhibition->pivot->booth }}</span>
                                                    @endif
                                                </li>
                                            @endforeach
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endpush
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('admin.exhibitor.edit', $post->id) }}" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="{{ __('general.edit') }}">
                                    <i class="si si-pencil"></i>
                                </a>

                                <a href="javascript:void(0)" class="delete-item btn btn-sm btn-secondary" data-id="{{ $post->id }}" data-toggle="tooltip" title="{{ __('general.delete') }}">
                                    <i class="si si-trash"></i>
                                    <form id="post-destroy-{{ $post->id }}" action="{{ route('admin.exhibitor.destroy', $post->id) }}" method="POST" style="display: none;">
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


            {!! $posts->appends(request()->query())->render() !!}
        </div>
</div>
@endsection


@push('script')
<script type="text/javascript">
$(function(){
    $('.delete-item').on('click', function(){
        var id = $(this).data('id');

        swal({
            text: '{{ __('exhibitor.alert_delete') }}',
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
