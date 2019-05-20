@extends('_layouts.backend')
@section('title', __('general.role'))

@section('content')
@widget('HeaderTools', [
    'search'    => [
        'status' => true,
        'route' => route('admin.role.index')
    ],
    'add'       => [
        'status' => true,
        'route' => route('admin.role.create')
    ],
    'sorts'     => [
        'name'      => __('role.name'),
        'created_at'   => __('role.created')
    ],
])

<div class="block block-bordered">
    <div class="block-content">
        <div class="table-responsive">
            <table class="table table-vcenter">
                <thead>
                    <tr>
                        <th>{{ __('role.name') }}</th>
                        <th class="text-center" style="width: 100px;">{{ __('general.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>
                            <a href="{{ route('admin.role.edit', $role->id) }}">
                                <span class="font-w600">{{ $role->display_name }}</span>
                            </a>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('admin.role.edit', $role->id) }}" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="{{ __('general.edit') }}">
                                    <i class="si si-pencil"></i>
                                </a>

                                <a href="javascript:void(0)" class="delete-item btn btn-sm btn-secondary" data-id="{{ $role->id }}" data-toggle="tooltip" title="{{ __('general.delete') }}">
                                    <i class="si si-trash"></i>
                                    <form id="role-destroy-{{ $role->id }}" action="{{ route('admin.role.destroy', $role->id) }}" method="POST" style="display: none;">
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

            {!! $roles->appends(request()->query())->render() !!}
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
            text: '{{ __('role.alert_delete') }}',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: '{{ __('general.yes') }}',
            cancelButtonText: '{{ __('general.no') }}'
        }).then(function (e) {
            document.getElementById('role-destroy-' + id).submit();
        })
    });
});
</script>
@endpush
