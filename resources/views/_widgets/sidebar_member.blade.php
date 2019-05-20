<div class="block text-center block-bordered">
    <div class="block-header block-header-default text-left border-b">
        <h3 class="block-title text-truncate">
            {{ Auth::user()->name }}
        </h3>

        @role('seller')
        @if(userPackage()->type == 'seller' and userPackage()->name != 'regular')
        <div class="block-options">
            <div class="dropdown">
                <button type="button" class="btn-block-option" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="si si-menu"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('public.user.show', Auth::id()) }}">
                        {{ __('general.view_public_profile') }}
                    </a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-qr">
                        {{ __('general.qr_code') }}
                    </a>
                </div>
            </div>
        </div>
        @endif
        @endrole
    </div>
    <div class="block-content text-left">
        <ul class="nav nav-pills flex-column push">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center justify-content-between {{ Route::currentRouteName() == 'member.index' ? 'active bg-pulse' : '' }}" href="{{ route('member.index') }}">
                    <span class="text-truncate"><i class="si si-home mr-5"></i> {{ __('general.dashboard') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center justify-content-between {{ request()->segment(2) == 'profile' ? 'active bg-pulse' : '' }}" href="{{ route('member.profile.general') }}">
                    <span class="text-truncate"><i class="si si-user mr-5"></i> {{ __('general.my_profile') }}</span>
                </a>
            </li>
            @role('seller')
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center justify-content-between {{ request()->segment(2) == 'product' ? 'active bg-pulse' : '' }}" href="{{ route('member.product.post.index') }}">
                    <span class="text-truncate"><i class="si si-layers mr-5"></i> {{ __('general.my_products') }}</span>
                </a>
            </li>
            @endrole
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center justify-content-between {{ request()->segment(2) == 'message' ? 'active bg-pulse' : '' }}" href="{{ route('member.message.index') }}">
                    <span class="text-truncate"><i class="si si-envelope-letter mr-5"></i> {{ __('general.messages') }}</span>
                    @if($message_count > 0)
                    <span class="badge badge-pill {{ request()->segment(2) == 'message' ? 'badge-secondary' : 'badge-danger' }}">{{ $message_count }}</span>
                    @endif
                </a>
            </li>
        </ul>
    </div>
</div>


@if(userPackage()->type == 'seller' and userPackage()->name != 'option_3')
<div class="block block-bordered">
    <div class="block-header block-header-default border-b">
        <h3 class="block-title">{{ __('general.product_quota') }}</h3>
    </div>
    <div class="block-content block-content-full">
        <p>
            {{
                __('general.product_usage', [
                    'used' => Auth::user()->subscription('main')->ability()->consumed('products'),
                    'total' => Auth::user()->subscription('main')->ability()->value('products')
                ])
            }}
        </p>
        <div class="progress push">
            <div class="progress-bar progress-bar-striped bg-pulse" role="progressbar" style="width: {{ (100 / Auth::user()->subscription('main')->ability()->value('products')) * Auth::user()->subscription('main')->ability()->consumed('products')  }}%;">
                @if(Auth::user()->subscription('main')->ability()->consumed('products') > 0)
                <span class="progress-bar-label">{{ Auth::user()->subscription('main')->ability()->consumed('products') }}</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

@widget('AccountUpgrade')

<div class="modal fade" id="modal-qr" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('general.qr_code') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ getQrCode(Auth::id()) }}" class="img-thumbnail">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="{{ route('public.user.qr', Auth::id()) }}" class="btn btn-primary">Download</a>
            </div>
        </div>
    </div>
</div>
