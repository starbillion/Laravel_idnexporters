@extends('_layouts.backend')
@section('title', __('general.traffic'))

@section('content')
<nav class="breadcrumb bg-white push">
    <a class="breadcrumb-item" href="{{ route('admin.traffic.index') }}">{{ __('general.traffic') }}</a>
    <span class="breadcrumb-item active text-muted">{{ $product->name }}</span>
</nav>

<div class="block block-bordered">
    <div class="block-header block-header-default border-b">
        <h3 class="block-title">{{ $product->name }}</h3>
        <div class="block-options">
            <div class="btn-group" role="group">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-secondary dropdown-toggle" id="year" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ $year }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="year">
                        @foreach(range(2015, date('Y')) as $y)
                        <a class="dropdown-item" href="{{ route('admin.traffic.show', ['id' => $product->id, 'year' => $y]) }}">
                            {{ $y }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block-content block-content-full text-center">
        <canvas class="js-chartjs-lines"></canvas>
    </div>

    <div class="block-content block-content-full border-t">
        <div class="table-responsive">
            <table class="table table-striped table-vcenter">
                <thead>
                    <tr>
                        <th class="text-center" width="10%"><i class="si si-calendar"></i></th>
                        <th class="text-center">{{ __('traffic.unique_view') }}</th>
                        <th class="text-center">{{ __('traffic.page_view') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(range(1, 12) as $month)
                    <tr>
                        <td>{{ date("F", mktime(0, 0, 0, $month, 1)) }}</td>
                        <td class="text-center">
                            {{
                                $product->visits()
                                    ->where('visitable_id', $product->id)
                                    ->whereBetween('created_at',[
                                        new Carbon\Carbon('first day of '. date("F", mktime(0, 0, 0, $month, 1)) .' '. $year),
                                        new Carbon\Carbon('last day of '. date("F", mktime(0, 0, 0, $month, 1)) .' '. $year)
                                    ])
                                    ->count()
                            }}
                        </td>
                        <td class="text-center">
                            {{
                                DB::table('product_post_visits')
                                    ->where('product_id', $product->id)
                                    ->whereBetween('created_at',[
                                        new Carbon\Carbon('first day of '. date("F", mktime(0, 0, 0, $month, 1)) .' '. $year),
                                        new Carbon\Carbon('last day of '. date("F", mktime(0, 0, 0, $month, 1)) .' '. $year)
                                    ])
                                    ->count()
                            }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


@push('script')
<script src="{{ asset('plugins/chartjs/Chart.bundle.min.js') }}"></script>
<script type="text/javascript">
$(function(){
    var initChartsChartJS = function () {
        Chart.defaults.global.defaultFontColor              = '#555555';
        Chart.defaults.scale.gridLines.color                = "rgba(0,0,0,.04)";
        Chart.defaults.scale.gridLines.zeroLineColor        = "rgba(0,0,0,.1)";
        Chart.defaults.scale.ticks.beginAtZero              = true;
        Chart.defaults.global.elements.line.borderWidth     = 2;
        Chart.defaults.global.elements.point.radius         = 5;
        Chart.defaults.global.elements.point.hoverRadius    = 7;
        Chart.defaults.global.tooltips.cornerRadius         = 3;
        Chart.defaults.global.legend.labels.boxWidth        = 12;

        var chartLinesCon  = jQuery('.js-chartjs-lines');
        var chartLines;
        var data_products = {
            labels: [
                @foreach(range(1, 12) as $month)
                '{{ date("F", mktime(0, 0, 0, $month, 1)) }}',
                @endforeach
            ],
            datasets: [
                {
                    label: '{{ __('traffic.unique_view') }}',
                    fill: true,
                    backgroundColor: 'rgba(66,165,245,.75)',
                    borderColor: 'rgba(66,165,245,1)',
                    pointBackgroundColor: 'rgba(66,165,245,1)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(66,165,245,1)',
                    data: [
                        @foreach(range(1, 12) as $month)
                        {{
                            $product->visits()
                                ->where('visitable_id', $product->id)
                                ->whereBetween('created_at',[
                                    new Carbon\Carbon('first day of '. date("F", mktime(0, 0, 0, $month, 1)) .' '. $year),
                                    new Carbon\Carbon('last day of '. date("F", mktime(0, 0, 0, $month, 1)) .' '. $year)
                                ])
                                ->count()
                        }},
                        @endforeach
                    ]
                },
                {
                    label: '{{ __('traffic.page_view') }}',
                    fill: true,
                    backgroundColor: 'rgba(66,165,245,.25)',
                    borderColor: 'rgba(66,165,245,1)',
                    pointBackgroundColor: 'rgba(66,165,245,1)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(66,165,245,1)',
                    data: [
                        @foreach(range(1, 12) as $month)
                        {{
                            DB::table('product_post_visits')
                                ->where('product_id', $product->id)
                                ->whereBetween('created_at',[
                                    new Carbon\Carbon('first day of '. date("F", mktime(0, 0, 0, $month, 1)) .' '. $year),
                                    new Carbon\Carbon('last day of '. date("F", mktime(0, 0, 0, $month, 1)) .' '. $year)
                                ])
                                ->count()
                        }},
                        @endforeach
                    ]
                }
            ]
        };

        chartLines = new Chart(chartLinesCon, {
            type: 'line',
            data: data_products,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            userCallback: function(label, index, labels) {
                                if (Math.floor(label) === label) {
                                    return label;
                                }

                            },
                        }
                    }],
                },
            }
        });
    };

    initChartsChartJS();

    $('#field-product').on('change', function(){
        window.location.replace($('#field-product').val());
        return false;
    });
})
</script>
@endpush
