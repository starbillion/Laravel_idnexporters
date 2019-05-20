@extends('_layouts.frontend')
@section('title', __('general.sellers'))

@section('content')
<div class="bg-image bg-black-op-25 bg-image-bottom" style="background-image: url('{{ asset('img/covers/sellers.jpg') }}');">
    <div class="bg-primary-dark-op">
        <div class="content content-full content-top text-center overflow-hidden">
            <h1 class="h2 font-w700 text-white  mb-100 js-appear-enabled animated fadeInDown" data-toggle="appear" data-class="animated fadeInDown">
                {{ __('user.browse_sellers') }}
            </h1>
        </div>
    </div>
</div>

<div class="content content-full pt-50 pb-50">
    <div class="row">
        <div class="col-md-3">
            @widget('Product\CategoriesUser', ['category' => request()->input('category'), 'route' => 'public.user.seller.index'])
        </div>

        <div class="col-md-9">
            <div class="block block-bordered">
                <div class="block-header block-header-default">
                    <h3 class="block-title">{{ isset($category) ? $category->name : __('user.featured') }}</h3>
                </div>
            </div>

            @if(count($users) > 0)
            <div class="block">
                <div class="block-content block-content-full">
                    <table class="table">
                        <?php $i = 0;?>
                        @foreach($users as $user)
                        <tr>
                            <td class="text-center {{ $i == 0 ? 'border-0' : '' }}" style="width: 100px;">
                                <div>
                                    <a href="#" data-target="#modal-seller-{{ $user->id }}" data-toggle="modal">
                                        @if($user->getFirstMediaUrl('logo'))
                                        <img id="company_logo" class="img-fluid" src="{{ asset($user->getFirstMediaUrl('logo', 'thumb')) }}" alt="{{ $user->company }}">
                                        @else
                                        <img id="company_logo" class="img-fluid" src="{{ asset('img/noimage.png') }}" alt="">
                                        @endif

                                        <div class="text-left modal fade" id="modal-seller-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-seller={{ $user->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="block-header bg-pulse text-white">
                                                    <h3 class="block-title text-white">{{ $user->company }}</h3>
                                                    <div class="block-options">
                                                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                            <i class="si si-close"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="modal-content">
                                                    <div class="block mb-0">
                                                        <div class="block-content tab-content p-0">
                                                            @if($user->getFirstMediaUrl('logo'))
                                                            <img id="company_logo" class="img-fluid" src="{{ asset($user->getFirstMediaUrl('logo', 'full')) }}" alt="{{ $user->company }}">
                                                            @else
                                                            <img id="company_logo" class="img-fluid" src="{{ asset('img/noimage.png') }}" alt="">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td class="{{ $i == 0 ? 'border-0' : '' }}">
                                <a class="clearfix" data-toggle="collapse" href="#detail-{{ $i }}">
                                    {{ $user->company }}&nbsp;

                                    @if($user->verified_member)
                                    <span class="badge badge-primary">{{ __('user.verified_member') }}</span>
                                    @endif

                                    @if($user->halal)
                                    <img src="{{ asset('img/icons/halal.png') }}" style="width: 28px;"></i>
                                    @endif
                                </a>

                                @if($user->main_exports)
                                <span class="font-size-sm text-muted">
                                    {{ $user->main_exports }}
                                </span>
                                @endif

                                <div id="detail-{{ $i }}" class="collapse my-10">
                                    <div class="row mb-20">
                                        <div class="col">
                                            <h6 class="mb-0">{{ __('user.address') }}</h6>
                                            <div>{{ $user->address ? $user->address : '-' }}</div>
                                        </div>
                                        <div class="col">
                                            <h6 class="mb-0">{{ __('user.location') }}</h6>
                                            <div>
                                                {{ $user->city ? $user->city : '' }}

                                                @if($user->city and $user->country)
                                                , {{ $user->country->name }}
                                                @elseif($user->country)
                                                {{ $user->country->name }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @php
                                    $hide = false;

                                    if($user->hide_contact){
                                        $hide = true;
                                    }

                                    if(Auth::check()){
                                        $auth = Auth::user();

                                        if($auth->hasRole('buyer') and userPackage()->name == 'paid'){
                                            $hide = false;
                                        }
                                    }
                                    @endphp

                                    @if(!$hide)
                                    @if($user->company_email or $user->phone_1 or $user->phone_2 or $user->fax or $user->website)
                                    <div class="row mb-20">
                                        @if($user->company_email)
                                        <div class="col">
                                            <h6 class="mb-0">{{ __('user.email') }}</h6>
                                            <div>{!! nl2br(e($user->company_email)) !!}</div>
                                        </div>
                                        @endif
                                        @if($user->phone_1 or $user->phone_2)
                                        <div class="col">
                                            <h6 class="mb-0">{{ __('user.phone') }}</h6>
                                            <div>
                                                {!! nl2br(e($user->phone_1)) !!}
                                                {!! '<br>' . nl2br(e($user->phone_2)) !!}
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="row mb-20">
                                        @if($user->fax)
                                        <div class="col">
                                            <h6 class="mb-0">{{ __('user.fax') }}</h6>
                                            <div>{!! nl2br(e($user->fax)) !!}</div>
                                        </div>
                                        @endif
                                        @if($user->website)
                                        <div class="col">
                                            <h6 class="mb-0">{{ __('user.website') }}</h6>
                                            <div><a href="{!! nl2br(e($user->website)) !!}" target="_blank">{!! nl2br(e($user->website)) !!}</a></div>
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                    @endif

                                    @widget('SendMessage', [
                                        'type' => 'seller',
                                        'user' => $user
                                    ])

                                    @if ($user->subscription('main')->ability()->canUse('public_page'))
                                    <a href="{{ route('public.user.show', $user->id) }}" class="btn btn-secondary">{{ __('user.view_seller') }}</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <?php $i++;?>
                        @endforeach
                    </table>
                </div>
            </div>

            @if($users->hasPages())
            <div class="block block-bordered">
                <div class="block-content">
                    {!! $users->appends(request()->query())->render() !!}
                </div>
            </div>
            @endif
            @else
            <div class="alert alert-info mb-0" role="alert">{{ __('user.no_sellers') }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
