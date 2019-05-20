@extends('_layouts.backend')
@section('title', __('general.packages'))

@section('content')
<div class="block block-bordered">
    <div class="block-content">
        <div class="table-responsive">
            <table class="table table-vcenter">
                <thead>
                    <tr>
                        <th>{{ __('general.users') }}</th>
                        <th class="text-center" style="width: 100px;">{{ __('general.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                    <tr>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#request-{{ $request->id }}">
                                <span class="font-w600">{{ $request->user->company }}</span>
                            </a>
                        </td>
                        <td class="text-right">
                            <div class="btn-group">
                                <a href="#" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#request-{{ $request->id }}">
                                    <i class="si si-eye"></i>
                                </a>

                                @push('modal')
                                <div class="modal fade" id="request-{{ $request->id }}" tabindex="-1" role="dialog">
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
                                                <div class="block-content block-content-full bg-gray-lighter border-b">
                                                    <ul class="list-unstyled">
                                                        <li class="font-w600 mb-5">
                                                            {{ $request->user->company }}<br>
                                                            {{ $request->user->name }}
                                                        </li>
                                                        <li class="text-muted">
                                                            <i class="si si-envelope"></i>&nbsp;
                                                            {{ $request->user->email }}
                                                        </li>
                                                        <li class="text-muted">
                                                            <i class="si si-phone"></i>&nbsp;
                                                            {{ $request->user->mobile }} /
                                                            {{ $request->user->phone_1 }}
                                                            {{ $request->user->phone_2 ? '/' . $request->user->phone_2 : '' }}
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="block-content block-content-full">
                                                    <dl class="row">
                                                        <dt class="col-sm-4">{{ __('package.current_package') }}</dt>
                                                        <dd class="col-sm-8">{{ __('package.' . userPackage($request->user->id)->type . '.' . userPackage($request->user->id)->name . '.name') }}</dd>
                                                        <dt class="col-sm-4">{{ __('package.requested_package') }}</dt>
                                                        <dd class="col-sm-8">{{ __('package.' . $request->plan->type . '.' . $request->plan->name . '.name') }}</dd>
                                                        <dt class="col-sm-4">{{ __('package.promocode') }}</dt>
                                                        <dd class="col-sm-8">
                                                            @if($request->coupon)
                                                            <strong>{{ $request->coupon->code }}</strong>
                                                            {!! $request->coupon->note ? '<br>' . $request->coupon->note : '' !!}
                                                            @else
                                                            -
                                                            @endif
                                                        </dd>
                                                        <dt class="col-sm-4">{{ __('package.requested_time') }}</dt>
                                                        <dd class="col-sm-8">{{ $request->created_at->diffforhumans() }}</dd>
                                                    </dl>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('admin.package.update', $request->id) }}" method="post">
                                                {{ csrf_field() }}
                                                <input name="_method" type="hidden" value="PUT">
                                                <input type="hidden" name="status" value="confirm">
                                                <button type="submit" class="btn btn-success">{{ __('package.confirm') }}</button>
                                                </form>

                                                <form action="{{ route('admin.package.update', $request->id) }}" method="post">
                                                {{ csrf_field() }}
                                                <input name="_method" type="hidden" value="PUT">
                                                <input type="hidden" name="status" value="cancel">
                                                <button type="submit" class="btn btn-danger">{{ __('package.cancel') }}</button>
                                                </form>
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

            {!! $requests->appends(request()->query())->render() !!}
        </div>
    </div>
</div>
@endsection
