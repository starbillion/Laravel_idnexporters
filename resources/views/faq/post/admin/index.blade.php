@extends('_layouts.backend')
@section('title', __('faq.posts'))

@section('content')
@widget('HeaderTools', [
    'search'    => [
        'status' => true,
        'route' => route('admin.faq.post.index')
    ],
    'add'       => [
        'status' => true,
        'route' => route('admin.faq.post.create')
    ],
    'sorts'     => [
        'name'      => __('faq.category_data.name'),
        'created'   => __('faq.category_data.created')
    ],
    'filters' => [
        [
            'name'  => 'Category',
            'input' => 'category_id',
            'data'  => \App\FaqCategory::pluck('name', 'id')
        ],
    ],
])

<div class="block block-bordered">
    <div class="block-content">
        <div class="table-responsive">
            <table class="table table-vcenter">
                <thead>
                    <tr>
                        <th>{{ __('faq.post_data.question') }}</th>
                        <th class="text-center" style="width: 100px;">{{ __('general.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr>
                        <td>
                            <a href="{{ route('admin.faq.post.edit', $post->id) }}">
                                <span class="font-w600">{{ $post->question }}</span>
                            </a>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('admin.faq.post.edit', $post->id) }}" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="{{ __('general.edit') }}">
                                    <i class="si si-pencil"></i>
                                </a>

                                <a href="javascript:void(0)" class="delete-item btn btn-sm btn-secondary" data-id="{{ $post->id }}" data-toggle="tooltip" title="{{ __('general.delete') }}">
                                    <i class="si si-trash"></i>
                                    <form id="post-destroy-{{ $post->id }}" action="{{ route('admin.faq.post.destroy', $post->id) }}" method="POST" style="display: none;">
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
