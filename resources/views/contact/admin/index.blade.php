@extends('_layouts.backend')
@section('title', __('general.contact'))

@section('content')
@widget('HeaderTools', [
    'search'    => [
        'status' => true,
        'route' => route('admin.contact.index')
    ],
    'sorts'     => [
        'name'      => __('contact.name'),
        'created'   => __('contact.created')
    ],
])

<div class="block block-bordered">
    <div class="block-content">
        <div class="table-responsive">
            <table class="table table-vcenter">
                <thead>
                    <tr>
                        <th>{{ __('contact.email') }}</th>
                        <th class="text-center" style="width: 100px;">{{ __('general.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#modal-{{ $post->id }}">
                                <span class="font-w600">{{ $post->name }}</span>
                            </a><br>
                            <span class="text-muted">{{ $post->email }}</span>
                        </td>
                        <td class="text-right">
                            <div class="btn-group">
                                <a href="#" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal-{{ $post->id }}">
                                    <i class="si si-eye"></i>
                                </a>

                                @push('modal')
                                <div class="modal fade" id="modal-{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-{{ $post->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="block block-themed block-transparent mb-0">
                                                <div class="block-header bg-primary-dark">
                                                    <h3 class="block-title">{{ __('contact.detail') }}</h3>
                                                    <div class="block-options">
                                                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                            <i class="si si-close"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="block-content block-content-full">
                                                    <dl class="row">
                                                        <dt class="col-sm-4">{{ __('contact.name') }}</dt>
                                                        <dd class="col-sm-6">{{ $post->name }}</dd>

                                                        <dt class="col-sm-4">{{ __('contact.email') }}</dt>
                                                        <dd class="col-sm-6">{{ $post->email }}</dd>

                                                        <dt class="col-sm-4">{{ __('contact.mobile') }}</dt>
                                                        <dd class="col-sm-6">{{ $post->mobile }}</dd>

                                                        <dt class="col-sm-4">{{ __('contact.body') }}</dt>
                                                        <dd class="col-sm-6">{{ $post->body }}</dd>
                                                    </dl>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
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


            {!! $posts->appends(request()->query())->render() !!}
        </div>
</div>
@endsection
