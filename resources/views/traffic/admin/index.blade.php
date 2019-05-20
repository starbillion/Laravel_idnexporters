@extends('_layouts.backend')
@section('title', __('general.traffic'))

@section('content')

<div class="d-flex justify-content-start mb-20">
    <div class="btn-group">
        <a href="{{ route('admin.traffic.index', ['sort' => 'product']) }}" class="btn btn-{{ request()->input('sort') == 'product' ? 'primary' : 'secondary' }}">Product Name</a>
        <a href="{{ route('admin.traffic.index', ['sort' => 'company']) }}" class="btn btn-{{ request()->input('sort') == 'company' ? 'primary' : 'secondary' }}">Company Name</a>
        <a href="{{ route('admin.traffic.index', ['sort' => 'hi-traffic']) }}" class="btn btn-{{ request()->input('sort') == 'hi-traffic' ? 'primary' : 'secondary' }}">Highest Traffic</a>
        <a href="{{ route('admin.traffic.index', ['sort' => 'lo-traffic']) }}" class="btn btn-{{ request()->input('sort') == 'lo-traffic' ? 'primary' : 'secondary' }}">Lowest Traffic</a>
    </div>
</div>


<div class="block block-bordered">
    <div class="block-content">
        <div class="table-responsive">
            <table class="table table-vcenter">
                <thead>
                    <tr>
                        <th width="50%">{{ __('general.name') }}</th>
                        <th>Owner</th>
                        <th class="text-center" style="width: 100px;">{{ __('general.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            <a href="{{ route('admin.traffic.show', $product->id) }}">
                                <span class="font-w600">{{ $product->name }}</span>
                            </a>
                        </td>
                        <td>
                            <span class="font-w600">{{ $product->owner->company }}</span>
                        </td>
                        <td class="text-right">
                            <div class="btn-group">
                                <a href="{{ route('admin.traffic.show', $product->id) }}" class="btn btn-sm btn-secondary">
                                    <i class="si si-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {!! $products->appends(request()->query())->render() !!}
        </div>
    </div>
</div>
@endsection
