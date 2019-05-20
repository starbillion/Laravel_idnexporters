@extends('_layouts.backend')
@section('title', __('general.messages'))

@section('content')
<div class="block block-bordered">
    <div class="block-content">
        @if(count($threads) > 0)
        <div class="table-responsive">
            <table class="table table-vcenter">
                <thead>
                    <tr>
                        <th>{{ __('general.company') }}</th>
                        <th style="width: 30%;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($threads as $thread)
                    <tr class="{{ $thread->isUnread(Auth::id()) ? 'table-active' : '' }}">

                        @if(count($thread->users) > 1)
                        @foreach($thread->users as $user)
                        @if($user->id != Auth::id())
                        <td>
                            <span class="font-w600 d-block">
                                <a href="{{ route('member.message.show', $thread->id) }}">
                                    {{ $user->company }}

                                    <span class="badge badge-primary">
                                        {{ $user->hasRole('seller') ? 'Seller' : 'Buyer' }}
                                    </span>
                                </a>
                            </span>
                            <span class="text-muted d-block">
                                {{ str_limit($thread->messages()->orderBy('id', 'desc')->first()->body, 50) }}
                            </span>
                        </td>
                        @endif
                        @endforeach
                        @else
                        <td>
                            <span class="font-w600 d-block"><a href="{{ route('member.message.show', $thread->id) }}">{{ __('message.user_inactive') }}</a></span>
                            <span class="text-muted d-block">
                                {{ str_limit($thread->messages()->orderBy('id', 'desc')->first()->body, 50) }}
                            </span>
                        </td>
                        @endif

                        <td class="text-muted text-right"><small>{{ $thread->updated_at->format('d-m-Y') }}</small></td>
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
