@extends('_layouts.backend')
@section('title', __('user.profile_tab_general'))

@section('content')
<div class="block block-bordered">
    @include('user.member._tabs')

    <form method="post" action="{{ route('member.profile.update') }}">
        {{ csrf_field() }}
        <input name="_method" type="hidden" value="PUT">
        <div class="block-content block-content-full">
            <h6 class="text-pulse">Please click and choose max 3 Categories</h6>
            <div id="c1" data-children=".c1_item">
                @foreach($categories as $c1)
                <div class="c1_item">
                    <a data-toggle="collapse" data-parent="#c1" href="#{{ $c1->id }}_accordion">
                        {{ $c1->name }}
                    </a>
                    <div id="{{ $c1->id }}_accordion" class="collapse" role="tabpanel">
                        <div class="pl-20">
                            <div id="c2{{ $c1->id }}" data-children=".c2_item">
                                @foreach($c1->children as $c2)
                                <div class="c2_item">
                                    <a data-toggle="collapse" data-parent="#c2{{ $c1->id }}" href="#{{ $c2->id }}_accordion">
                                        {{ $c2->name }}
                                    </a>
                                    <div id="{{ $c2->id }}_accordion" class="collapse" role="tabpanel">
                                        <div class="pl-20">
                                            @foreach($c2->children as $c3)
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $c3->id }}"
                                                    {{ (collect(old('categories', $user->categories))->contains($c3->id)) ? 'checked':'' }}
                                                    >
                                                    {{ $c3->name }}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="block-content block-content-full bg-gray-lighter">
            <div class="row">
                <div class="col-auto mr-auto">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">{{ __('general.save') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('script')
<script src="{{ asset('plugins/sweetalert2/es6-promise.auto.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script type="text/javascript">
    $(function(){

        $('input[type=checkbox].form-check-input').on('change', function (e) {
            if ($('input[type=checkbox].form-check-input:checked').length > 3) {
                $(this).prop('checked', false);
                swal ( "Oops" ,  "Allowed only 3" ,  "warning" )
            }

            highlightSelected();
        });

        highlightSelected();

        function highlightSelected(){
            $('#c1 a').css({
                'font-weight': 'normal',
                'text-decoration': 'none'
            });

            $('input[type=checkbox].form-check-input:checked').each(function(){
                var c1 = $(this).parent().parent().parent().parent().parent().parent().parent().parent().siblings('a').css({
                    'font-weight': '700',
                    'text-decoration': 'underline'
                });

                var c2 = $(this).parent().parent().parent().parent().siblings('a').css({
                    'font-weight': '700',
                    'text-decoration': 'underline'
                });
            });
        }

    })
</script>
@endpush
