@extends('layouts.main')

@section('title')
    @lang('lang.title')
@endsection
@section('styles')
    <!-- Custom Style CSS Only For Demo Purpose -->
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/style-primary.css">
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/custom.css">
@endsection


<!-- ################################################################################################### -->


@section('content')
    @include('inc.header')
    @include('inc.side_bar')
    <!-- Content Body Start -->
    <div class="content-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-auto mb-20 d-flex justify-content-between ">
                <div class="page-heading d-flex">
                    <h3>@lang('lang.edit')</h3>

                </div>
            </div>
        </div>
        <div class="col-md-8 ">
            @if($data)
                <div class="row mbn-15">
                    <div id="error" class="alert alert-danger d-none" role="alert">
                        <strong></strong>
                        <button class="close" data-dismiss="alert"><i class="zmdi zmdi-close"></i></button>
                    </div>
                    <div class="col-12 pl-0 mb-15">
                        <input  id="add_bLicense_title"  type="text" class="form-control" placeholder="@lang('lang.name_license')" value="{!! $data->title !!}">
                    </div>
                    <div class="col-6 pl-0 mb-15">
                        <div class="mb-10">
                            <span>@lang('lang.recomended_size_book_license')</span>
                        </div>
                        <input
                            type="file"
                            class="dropify-my"
                            id="add_bLicense_img"
                            data-allowed-file-extensions="svg jpg jpeg png gif "
                            @if($data->image)
                            data-default-file="/public/uploads/books/licenses/{{ $data->id  . '/' . $data->image}}"
                            @endif
                            data-max-file-size="5M"/>
                    </div>
                    <div class="col-12 pl-0 mb-15">
                        <textarea id="add_bLicense_descr"  class="form-control" placeholder="@lang('lang.about_license')">{!! $data->descr !!}</textarea>
                    </div>
                    <div class="col-12 pl-0 mb-15">
                        <button data-id="{{ $data->id }}" id="edit_bLicense_btn" class="button button-primary button-outline fl-right">@lang('lang.save')</button>
                    </div>
                </div>
            @endif
        </div>
    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')
    <script src="/public/web_assets/js/plugins/dropify/dropify.min.js"></script>
    <script src="/public/web_assets/js/plugins/dropify/dropify.active.js"></script>
    <script src="/public/web_assets/js/customize_dropify.js"></script>
@endsection
