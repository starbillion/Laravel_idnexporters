@extends('_layouts.backend')
@section('title', __('user.profile_tab_media'))

@section('content')
<div class="block block-bordered" id="block-wrapper">
    @include('user.member._tabs')

    <div class="block-content block-content-full">

        @foreach(range(1, 4) as $item)
        <div class="row mb-10">
            <div class="col-md-12">
                <h6>{{ __('user.banner') }} #{{ $item }}</h6>
                <div class="row justify-content-md-center text-center" id="for-banner-{{ $item }}">
                    <div class="col-md-12">
                        <div class="options-container">

                            @if($media = $user->media()->where(['collection_name' => 'banner', 'custom_properties->id' => (string)$item])->first())
                            <img id="company_logo" class="img-fluid options-item" src="{{ asset($media->getUrl()) }}" alt="">
                            <div class="options-overlay bg-black-op-75">
                                <div class="options-overlay-content p-20">
                                    <a class="btn btn-sm btn-alt-secondary min-width-75" onclick="event.preventDefault(); document.getElementById('upload-banner-{{ $item }}').click()">
                                        {{ __('user.change_image') }}
                                    </a>
                                    <a class="btn btn-sm btn-alt-danger min-width-75" onclick="event.preventDefault(); Codebase.loader('show'); document.getElementById('form-delete-{{ $item }}').submit();">
                                        {{ __('user.delete_image') }}
                                    </a>
                                    <form id="form-delete-{{ $item }}" method="post" action="{{ route('member.profile.media.destroy', ['id' => $media->id]) }}" class="d-none">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="type" value="banner">
                                        <input name="_method" type="hidden" value="DELETE">
                                    </form>
                                </div>
                            </div>
                            @else
                            <img id="company_logo" class="img-fluid options-item" src="{{ asset('img/noimage-banner.png') }}" alt="">
                            <div class="options-overlay bg-black-op-75">
                                <div class="options-overlay-content p-20">
                                    <a class="btn btn-sm btn-alt-secondary min-width-75" onclick="event.preventDefault(); document.getElementById('upload-banner-{{ $item }}').click()">
                                        {{ __('user.upload_image') }}
                                    </a>
                                </div>
                            </div>
                            @endif

                            <form id="form-upload-{{ $item }}" method="post" action="{{ route('member.profile.media.store', ['id' => $item]) }}" class="d-none" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="type" value="banner">
                                <input id="upload-banner-{{ $item }}" type="file" name="banner" onchange="event.preventDefault(); Codebase.loader('show'); document.getElementById('form-upload-{{ $item }}').submit();" />
                            </form>

                        </div>
                    </div>
                </div>
                <span class="text-muted text-center d-block mt-10">{{ __('user.banner_placeholder') }}</span>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
