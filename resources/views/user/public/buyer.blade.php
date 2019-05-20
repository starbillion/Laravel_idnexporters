@extends('_layouts.frontend')
@section('title', __('general.buyers'))

@section('content')
<div class="bg-image bg-black-op-25 bg-image-bottom" style="background-image: url('{{ asset('img/covers/buyers.jpg') }}');">
    <div class="bg-primary-dark-op">
        <div class="content content-full content-top text-center overflow-hidden">
            <h1 class="h2 font-w700 text-white  mb-100 js-appear-enabled animated fadeInDown" data-toggle="appear" data-class="animated fadeInDown">
                {{ __('user.browse_buyers') }}
            </h1>
        </div>
    </div>
</div>

<div class="content content-full pt-50 pb-50">
    <div class="row">
        <div class="col-md-3">
            @widget('BuyerFilter')
        </div>

        <div class="col-md-9">
            <div class="block block-bordered">
                <div class="block-header block-header-default">
                    <h3 class="block-title">{{ __('user.buyers_count', ['buyers' => $buyers_count]) }}</h3>
                </div>
            </div>

            @if(count($buyers) > 0)
            <div class="block block-bordered">
                <div class="block-content">
                    <table class="table">
                        <?php $i = 0;?>
                        @foreach($buyers as $buyer)
                        <tr>
                            <td class="{{ $i == 0 ? 'border-0' : '' }}">
                                <a class="clearfix" data-toggle="collapse" href="#detail-{{ $i }}">
                                    {{ $buyer->company }}
                                </a>
                                <span class="font-size-sm text-muted">{{ $buyer->product_interests }}</span>

                                <div id="detail-{{ $i }}" class="collapse my-10">
                                    <div class="row mb-20">
                                        <div class="col">
                                            <h6 class="mb-0">{{ __('user.address') }}</h6>
                                            <div>{{ $buyer->address ? $buyer->address : '-' }}</div>
                                        </div>
                                        <div class="col">
                                            <h6 class="mb-0">{{ __('user.location') }}</h6>
                                            <div>
                                                {{ $buyer->city }}
                                                {{ $buyer->country_id ? ', ' . $buyer->country->name : '' }}
                                            </div>
                                        </div>
                                    </div>

                                    @if(!$buyer->hide_contact)
                                    @if($buyer->company_email or $buyer->phone_1 or $buyer->phone_2 or $buyer->fax or $buyer->website)
                                    <div class="row mb-20">
                                        @if($buyer->company_email)
                                        <div class="col">
                                            <h6 class="mb-0">{{ __('user.email') }}</h6>
                                            <div>{!! nl2br(e($buyer->company_email)) !!}</div>
                                        </div>
                                        @endif
                                        @if($buyer->phone_1 or $buyer->phone_2)
                                        <div class="col">
                                            <h6 class="mb-0">{{ __('user.phone') }}</h6>
                                            <div>
                                                {!! nl2br(e($buyer->phone_1)) !!}
                                                {!! '<br>' . nl2br(e($buyer->phone_2)) !!}
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="row mb-20">
                                        @if($buyer->fax)
                                        <div class="col">
                                            <h6 class="mb-0">{{ __('user.fax') }}</h6>
                                            <div>{!! nl2br(e($buyer->fax)) !!}</div>
                                        </div>
                                        @endif
                                        @if($buyer->website)
                                        <div class="col">
                                            <h6 class="mb-0">{{ __('user.website') }}</h6>
                                            <div><a href="{!! nl2br(e($buyer->website)) !!}" target="_blank">{!! nl2br(e($buyer->website)) !!}</a></div>
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                    @endif
                                </div>
                            </td>
                            <td class="{{ $i == 0 ? 'border-0' : '' }} text-right" width="30%">
                                @widget('SendMessage', [
                                    'type' => 'buyer',
                                    'user' => $buyer
                                ])
                            </td>
                        </tr>
                        <?php $i++;?>
                        @endforeach
                    </table>
                </div>
            </div>

            @if($buyers->hasPages())
            <div class="block block-bordered">
                <div class="block-content">
                    {!! $buyers->appends(request()->query())->render() !!}
                </div>
            </div>
            @endif
            @else
            <div class="alert alert-info mb-0" role="alert">{{ __('user.no_buyers') }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
