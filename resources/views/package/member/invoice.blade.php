@php
$coupon = 0;
$ppn = 0;
@endphp
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="robots" content="noindex, nofollow">
        <link rel="stylesheet" id="css-main" href="{{ asset('css/style.css') }}">
    </head>
    <body class="bg-white">
        <div id="page-container" class="main-content-boxed">
            <main id="main-container">
                <div class="content">
                    <div class="block">
                        <div class="block-content">
                            <div class="mb-20">
                                <h3>
                                    <img style="height: 45px; margin-top: -6px;" src="{{ asset('img/logo.png') }}">
                                    @if($status)
                                    <span class="btn btn-success float-right text-uppercase">{{ __('package.invoice.confirmed') }}</span>
                                    @else
                                    <span class="btn btn-danger float-right text-uppercase">{{ __('package.invoice.unconfirmed') }}</span>
                                    @endif
                                </h3>
                            </div>

                            <div class="table-responsive push">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td width="50%">
                                                <p class="h3">{{ config('app.company.name') }}</p>
                                                <address>
                                                    {{ config('app.company.address_1') }}<br>
                                                    {{ config('app.company.address_2') }}<br>
                                                    {{ config('app.company.address_3') }}<br>
                                                    {{ config('app.company.phone') }}<br>
                                                    {{ config('app.company.fax') }}
                                                </address>
                                            </td>
                                            <td width="50%" class="text-right">
                                                <p class="h3">#{{ Hashids::connection('invoice')->encode($request->id) }}</p>
                                                <address>
                                                    <strong>{{ $request->user->company }}</strong><br>
                                                    <strong>{{ $request->user->name }}</strong><br>
                                                    {{ $request->user->country->name }}<br>
                                                    {{ $request->user->phone_1 }}<br>
                                                    {{ $request->user->email }}<br>
                                                    {{ $request->user->company_email }}
                                                </address>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="table-responsive push">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('general.package') }}</th>
                                            <th class="text-right" width="30%">Amount ({{ $request->plan->currency->code }})</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                {{ __('package.' . $request->plan->type . '.' . $request->plan->name . '.name') }}<br>
                                                <span class="text-muted">
                                                    {{ __('package.' . $request->plan->type . '.' . $request->plan->name . '.description') }}
                                                </span>
                                            </td>
                                            <td class="text-right">{{ number_format($request->plan->price) }}</td>
                                        </tr>

                                        @if($request->coupon)
                                        <tr>
                                            <td class="font-w600 text-right">Coupon</td>
                                            <td class="text-right">
                                                @php
                                                $coupon = $request->coupon->nominal;
                                                @endphp

                                                {{ number_format($request->coupon->nominal) }}
                                            </td>
                                        </tr>
                                        @endif

                                        @if($request->plan->currency->code == 'IDR')
                                        <tr>
                                            <td class="font-w600 text-right">PPN</td>
                                            <td class="text-right">{{ number_format($ppn = ($request->plan->price - $coupon) * 10 / 100) }}</td>
                                        </tr>
                                        @endif

                                        <tr class="table-warning">
                                            <td class="font-w700 text-uppercase text-right">Total Due</td>
                                            <td class="font-w700 text-right">{{ number_format($request->plan->price - $coupon + $ppn ) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <p class="text-muted text-center">{{ __('package.invoice.footer_notes') }}</p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
