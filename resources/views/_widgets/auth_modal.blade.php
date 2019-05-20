@if(!Auth::check())

@push('modal')
<div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="modal-login" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block mb-0">
                <div class="block-header block-header-default pt-0 pb-0 pl-0">
                    <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tab-login">{{ __('general.login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab-register">{{ __('general.register') }}</a>
                        </li>
                    </ul>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>

                <div class="block-content tab-content p-0">
                    <div class="tab-pane active" id="tab-login" role="tabpanel">
                        <form method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="p-20">
                                <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                                    <label for="email" class="control-label">{{ __('general.email') }}</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' is-invalid' : '' }}">
                                    <label for="password" class="control-label">{{ __('general.password') }}</label>
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">{{ __('general.remember_me') }}</span>
                                    </label>
                                </div>
                            </div>

                            <div class="p-20 bg-gray-lighter border-t">
                                <div class="row">
                                    <div class="col-auto mr-auto">
                                        <a class="btn btn-link pl-0" href="{{ route('password.request') }}">
                                            {{ __('general.forgot_password') }}
                                        </a>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-danger">
                                            {{ __('general.login') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="tab-register" role="tabpanel">
                        <form method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}

                            <div class="p-20">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="control-label">Name</label>
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' is-invalid' : '' }}">
                                    <label for="email" class="control-label">{{ __('general.email') }}</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' is-invalid' : '' }}">
                                    <label for="password" class="control-label">{{ __('general.password') }}</label>
                                    <input id="password" type="password" class="form-control" name="password" required>
                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm" class="control-label">{{ __('general.password_confirmation') }}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>

                                <div class="form-group{{ $errors->has('as') ? ' is-invalid' : '' }}">
                                    <label for="as-confirm" class="control-label">{{ __('auth.register_as') }}</label>
                                    <div class="">
                                        <label class="css-control css-control-primary css-radio">
                                            <input type="radio" class="css-control-input" name="as" value="seller" checked>
                                            <span class="css-control-indicator"></span> {{ __('auth.seller_account') }}
                                        </label>
                                    </div>
                                    <div class="">
                                        <label class="css-control css-control-primary css-radio">
                                            <input type="radio" class="css-control-input" name="as" value="buyer">
                                            <span class="css-control-indicator"></span> {{ __('auth.buyer_account') }}
                                        </label>
                                    </div>
                                    @if ($errors->has('as'))
                                    <span class="invalid-feedback">{{ $errors->first('as') }}</span>
                                    @endif
                                </div>
                                <div class="text-muted">
                                    <small>{!! __('auth.agreement') !!}</small>
                                </div>
                            </div>

                            <div class="p-20 bg-gray-lighter border-t">
                                <div class="row">
                                    <div class="col-auto mr-auto">
                                        <a class="btn btn-link pl-0" href="{{ route('login') }}">
                                            {{ __('general.login') }}
                                        </a>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-danger">
                                            {{ __('general.register') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endpush

@push('script')
<script type="text/javascript">
    $(function(){
        $('#modal-login').on('shown.bs.modal', function() {
            $(this).find('[autofocus]').focus();
        });
    })
</script>
@endpush

@endif
