@extends('_layouts.backend')
@section('title', __('user.export'))

@section('content')

<div class="block block-bordered">
    <div class="block-content block-content-full">
        <div class="row">
            <div class="col-md-6">
                <h6 class="text-center">
                    {{ __('general.seller') }}
                </h6>
                <hr>

                @php
                $columns = [
                    'salutation',
                    'name',
                    'email',
                    'halal',
                    'subscribe',
                    'hide_contact',
                    'company',
                    'established',
                    'city',
                    'postal',
                    'mobile',
                    'phone_1',
                    'phone_2',
                    'fax',
                    'company_email',
                    'website',
                    'languages',
                    'address',
                    'description',
                    'additional_notes',
                    'main_exports',
                    'export_destinations',
                    'current_markets',
                    'annual_revenue',
                    'factory_address',
                    'certifications'
                ];
                @endphp
                <form action="{{ route('admin.user.export.process') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="type" value="seller">
                    @foreach($columns as $column)
                    <div class="">
                        <label class="css-control css-control-primary css-checkbox">
                            <input type="checkbox" class="css-control-input" name="columns[{{ $column }}]" checked="">
                            <span class="css-control-indicator"></span> {{ __('user.' . $column) }}
                        </label>
                    </div>
                    @endforeach
                    <div class="mt-10 pt-10 border-t">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __('user.export') }}
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <h6 class="text-center">
                    {{ __('general.buyer') }}
                </h6>
                <hr>

                @php
                $columns = [
                    'salutation',
                    'name',
                    'email',
                    'halal',
                    'subscribe',
                    'hide_contact',
                    'company',
                    'established',
                    'city',
                    'postal',
                    'mobile',
                    'phone_1',
                    'phone_2',
                    'fax',
                    'company_email',
                    'website',
                    'languages',
                    'address',
                    'description',
                    'additional_notes',
                    'main_imports',
                    'product_interests'
                ];
                @endphp
                <form action="{{ route('admin.user.export.process') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="type" value="buyer">
                    @foreach($columns as $column)
                    <div class="">
                        <label class="css-control css-control-primary css-checkbox">
                            <input type="checkbox" class="css-control-input" name="columns[{{ $column }}]" checked="">
                            <span class="css-control-indicator"></span> {{ __('user.' . $column) }}
                        </label>
                    </div>
                    @endforeach
                    <div class="mt-10 pt-10 border-t">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __('user.export') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
