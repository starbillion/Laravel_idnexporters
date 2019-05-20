@extends('_layouts.backend')
@section('title', $to ? $to->company . ' ' . ($to->hasRole('seller') ? '(Seller)' : '(Buyer)')  : __('message.user_inactive'))

@section('content')
<div class="block">
    <div class="block block-bordered">
        <div class="block-content block-content-full border-b bg-gray-lighter">

            @if($to)
			<form action="{{ route('member.message.update', $thread->id) }}" method="post">
			    {{ method_field('put') }}
			    {{ csrf_field() }}

			    <div class="form-group{{ $errors->has('body') ? ' is-invalid' : '' }}">
			        <textarea name="body" class="form-control" placeholder="{{ __('message.body_placeholder') }}">{{ old('body') }}</textarea>
                    <div class="invalid-feedback">{{ $errors->first('body') }}</div>
			    </div>

			    @foreach($thread->users as $user)
					@if($user->id != Auth::id())
						<a class="btn btn-link pl-0">
                            {{ $user->company }}

                            <span class="badge badge-primary">
                                {{ $user->hasRole('seller') ? 'Seller' : 'Buyer' }}
                            </span>
                        </a>
					@endif
				@endforeach

			    <button type="submit" class="btn btn-danger float-right">{{ __('message.send') }}</button>
			    <div class="clearfix"></div>
			</form>
            @else
                <div class="form-group{{ $errors->has('body') ? ' is-invalid' : '' }}">
                    <textarea name="body" class="form-control" placeholder="{{ __('message.inactive_info') }}" disabled=""></textarea>
                </div>
            @endif
        </div>
        <div class="block-content">
            @foreach($messages as $message)
            @if($message->user_id == Auth::id())
            <div class="row justify-content-start">
            	<div class="col-md-8">
            		<div class="block">
	            		<div class="block-content bg-info-light rounded">
	            			<p>{!! nl2br(e($message->body)) !!}</p>

                            @if($message->product)
                            <a class="block" href="{{ route('public.product.show', $message->product_id) }}" target="_blank">
                                <div class="block-content block-content-full clearfix p-10">
                                    <div class="float-right">
                                        @if($message->product->getFirstMediaUrl('product'))
                                        <img class="img-avatar" src="{{ $message->product->getFirstMediaUrl('product') }}">
                                        @else
                                        <img class="img-avatar" src="{{ asset('img/noimage.png') }}">
                                        @endif
                                    </div>
                                    <div class="float-left mt-10">
                                        <div class="font-w600 mb-5">{{ $message->product->name }}</div>
                                        <div class="font-size-sm text-muted">{{ $message->product->category->name }}</div>
                                    </div>
                                </div>
                            </a>
                            @endif

                            <small class="text-right d-block mb-5">
                                {{ $message->user->hasRole('seller') ? 'Seller' : 'Buyer' }}
                            </small>
	            		</div>
            			<span class="text-muted d-block">
                            <small>{{ $message->created_at->format('d M Y') }}</small>
                        </span>
            		</div>
            	</div>
            </div>
            @else
			<div class="row justify-content-end">
            	<div class="col-md-8">
            		<div class="block">
	            		<div class="block-content bg-gray-lighter rounded">
	            			<p>{!! nl2br(e($message->body)) !!}</p>

                            @if($message->product)
                            <a class="block" href="{{ route('public.product.show', $message->product_id) }}" target="_blank">
                                <div class="block-content block-content-full clearfix p-10">
                                    <div class="float-right">
                                        @if($message->product->getFirstMediaUrl('product'))
                                        <img class="img-avatar" src="{{ $message->product->getFirstMediaUrl('product') }}">
                                        @else
                                        <img class="img-avatar" src="{{ asset('img/noimage.png') }}">
                                        @endif
                                    </div>
                                    <div class="float-left mt-10">
                                        <div class="font-w600 mb-5">{{ $message->product->name }}</div>
                                        <div class="font-size-sm text-muted">{{ $message->product->category->name }}</div>
                                    </div>
                                </div>
                            </a>
                            @endif

                            <small class="text-right d-block mb-5">
                                {{ $message->user->hasRole('seller') ? 'Seller' : 'Buyer' }}
                            </small>
	            		</div>
            			<span class="text-muted d-block text-right">
                            <small>
                                {{ $message->created_at->format('d M Y') }}
                            </small>
                        </span>
            		</div>
            	</div>
            </div>
            @endif
            @endforeach

            {!! $messages->appends(request()->query())->render() !!}
        </div>
    </div>
</div>
@endsection
