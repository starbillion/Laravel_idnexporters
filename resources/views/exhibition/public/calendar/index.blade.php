@extends('_layouts.frontend')
@section('title', __('general.exhibition_calendar'))

@section('content')
<div class="bg-pulse">
	<div class="content content-full content-top text-center overflow-hidden">
		<h1 class="h2 font-w700 text-white mb-30 js-appear-enabled animated fadeInDown" data-toggle="appear" data-class="animated fadeInDown">
			{{ __('general.exhibition_calendar_indonesia') }}
		</h1>
	</div>
</div>

<div class="content content-full pt-50 pb-50">
	<div class="block block-bordered">
		<div class="block-content block-content-full">
			<div class="js-calendar"></div>
		</div>
	</div>
</div>
@endsection

@push('style_before')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/fullcalendar/fullcalendar.min.css') }}">
<style type="text/css">
.fc-day-grid-event > .fc-content {
   white-space: normal;
}

.fc-time{
   display : none;
}
</style>
@endpush

@push('script')
<script type="text/javascript" src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/fullcalendar/fullcalendar.min.js') }}"></script>
<script type="text/javascript">
$(function(){
	var initCalendar = function(){
        var date = new Date();
        var d    = date.getDate();
        var m    = date.getMonth();
        var y    = date.getFullYear();

        $('.js-calendar').fullCalendar({
            @php
            $format = preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])$/', request()->input('position')) ? request()->input('position') : false;
            $date = $format
            ? \Carbon\Carbon::createFromFormat('Y-m', $format)
            : \Carbon\Carbon::now()->format('Y-m-d');
            @endphp
        	defaultDate: '{{ $date }}',
        	defaultView: 'month',
        	validRange: {
        		start: '{{ \Carbon\Carbon::parse('first day of January ' . (date('Y') - config('app.calendar_min_year')))->format('Y-m-d') }}',
        		end: '{{ \Carbon\Carbon::parse('last day of December ' . (date('Y') + config('app.calendar_max_year')))->format('Y-m-d') }}',
        	},
            firstDay: 1,
            header: {
                left: 'title',
                right: 'prev,next'
            },
            events: [
            	@foreach($posts as $post)
                {
                    title: '{!! $post->title !!}',
                    start: '{{ $post->start_at->format('Y-m-d') }}',
                    @if($post->ending_at)
                    end: '{{ $post->ending_at->format('Y-m-').($post->ending_at->format('d') + 1) }}',
                    @endif
                    color: '{{ $post->color }}',
                    url: '{{ route('public.exhibition.calendar.show', $post->slug) }}'
                },
                @endforeach
            ]
        });
    };

    initCalendar();
});
</script>
@endpush
