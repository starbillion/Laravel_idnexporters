@extends('_layouts.backend')
@section('title', __('general.search'))

@section('content')
<div class="block block-bordered">
    <div class="block-content">
        <div class="table-responsive">
            <table class="table table-vcenter">
                <thead>
                    <tr>
                        <th width="20%">Count</th>
                        <th>Search String</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($searches as $search)
                    <tr>
                        <td>
                            <span>{{ $search->total }}</span>
                        </td>
                        <td>
                            <span class="font-w600">{{ $search->q }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {!! $searches->appends(request()->query())->render() !!}
        </div>
    </div>
</div>
@endsection
