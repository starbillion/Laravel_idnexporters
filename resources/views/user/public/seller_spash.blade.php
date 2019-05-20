@extends('_layouts.frontend')
@section('title', __('general.sellers'))

@section('content')
<div id="splash" class="bg-image" style="background-image: url('{{ asset('img/covers/sellers.jpg') }}');">
    <div class="content content-full text-center pt-50">
        <h1 class="font-w400 text-white mt-50 pt-50 mb-50 invisible" style="font-size: 40px; text-shadow:4px 2px 20px #666;" data-toggle="appear" data-class="animated fadeInUp" data-timeout="250">{{ __('user.browse_sellers') }}</h1>
        <a class="btn btn-hero btn-noborder btn-rounded btn-primary invisible" data-toggle="appear" data-class="animated bounceIn" data-timeout="750" href="{{ route('public.user.seller.index') }}">
            <i class="si si-rocket mr-10"></i> {{ __('user.start_browsing') }}
        </a>
    </div>
</div>
@endsection

@push('script')
<script type="text/javascript">
    $(function(){
        $(window).on('resize.cb.main orientationchange.cb.main', function(){
            resizeTimeout = setTimeout(function(){
                $('#splash').css('minHeight', $('#main-container').height());
                $('#splash .content').css('minHeight', $('#main-container').height());
            }, 150);
        }).triggerHandler('resize.cb.main');
    })
</script>
@endpush
