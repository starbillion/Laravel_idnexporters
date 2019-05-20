@extends('_layouts.frontend')
@section('title', __('general.packages'))

@section('content')
<div class="content pt-50 mt-50">

    <h1 class="text-center">Thanks, IDNexporters.com Customer.</h1>

    <h3 class="text-center">Your customer number : {{ Hashids::connection('invoice')->encode($requested->id) }}</h3>

    <div class="text-center">
        <a href="{{ route('dashboard') }}" class="btn btn-lg btn-primary">Back to Dashboard</a>
    </div>
</div>
@endsection
