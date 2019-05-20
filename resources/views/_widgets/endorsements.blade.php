@if(count($endorsements) > 0)
<div class="block block-bordered">
    <div class="block-header block-header-default">
        <h3 class="block-title">{{ __('endorsement.title') }}</h3>
    </div>
    <div class="block-content block-content-full text-center">
        <div class="js-slider slick-nav-black slick-nav-hover" data-dots="true" data-arrows="true" data-slides-to-show="3">
            @foreach($endorsements as $endorsement)
            <div class="py-20 text-center">
                <a class="d-block text-center" href="#" data-target="#endorsement-{{ $endorsement->id }}" data-toggle="modal">
                    @if($endorsement->getFirstMediaUrl('logo'))
                    <img class="d-inline" style="height: 150px;" src="{{ $endorsement->getFirstMediaUrl('logo', 'full') }}">
                    @else
                    <img class="d-inline" style="height: 150px;" src="{{ asset('img/noimage.png') }}">
                    @endif
                </a>

                @push('modal')
                <div class="modal fade" id="endorsement-{{ $endorsement->id }}" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="block block-themed block-transparent mb-0">
                                <div class="block-header bg-primary-dark">
                                    <h3 class="block-title">{{ $endorsement->title }}</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                            <i class="si si-close"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="block-content block-content-full" style="position: relative;">
                                    {!! $endorsement->body !!}
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('general.close') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endpush
            </div>
            @endforeach
        </div>
    </div>
</div>

@push('script')
<script src="{{ asset('plugins/slick/slick.min.js') }}"></script>
<script>
    $(function () {
        Codebase.helpers('slick');
    });
</script>
@endpush

@push('style')
<link rel="stylesheet" href="{{ asset('plugins/slick/slick.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/slick/slick-theme.min.css') }}">
@endpush
@endif
