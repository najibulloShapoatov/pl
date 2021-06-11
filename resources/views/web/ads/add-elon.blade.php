@extends('layouts.main')

@section('title')
    @lang('lang.title')
@endsection
@section('styles')
    <!-- Custom Style CSS Only For Demo Purpose -->
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/style-primary.css">
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/custom.css">
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/fortest2.css">
@endsection


<!-- ################################################################################################### -->


@section('content')
    @include('inc.header')
    @include('inc.side_bar')
    <!-- Content Body Start -->
    <div class="content-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-auto mb-20 d-flex justify-content-between">
                <div class="page-heading">
                    <h3>@lang('lang.post_an_ad')</h3>
                </div>
                <span class="single-elon-header pt-1 pl-20 float-right ">
                    <a href="{{ url('/elon') }}">
                        <span>@lang('lang.all_announcements')</span>
                    </a>
                    @if(Auth::check())
                        <a class="ml-15" href="{{ url('/my-elon') }}">
                            <span>@lang('lang.my_announcements')</span>
                        </a>
                    @endif
                </span>

            </div>
            <div class="col-sm-12 mt-25">
                <div class="col-6">
                    <div class="row mbn-15">
                        <div class="col-12">
                        <div class="error hide"></div>
                        </div>
                        <div class="col-12 mb-15">
                            <select id="elon_cat_id" class="form-control">
                                <option value="">@lang('lang.select_a_category')</option>
                                @foreach($elon_cats as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-12 mb-15">
                            <input id="new_elon_title" type="text" class="form-control" placeholder="@lang('lang.header')">
                        </div>
                        <div class="col-12 mb-15">
                            <input id="new_elon_price" type="text" class="form-control" placeholder="@lang('lang.enter_a_price')">
                        </div>
                        <div class="col-4 elon_img mb-15 p-20">
                            <input
                                type="file"
                                class="dropify-elon-img"
                                id="input-file-elon-img"
                                data-allowed-file-extensions="jpeg jpg png "
                                data-max-file-size="5M"/>
                        </div>
                        <div class="col-12 mb-15">
                            <textarea id="new_elon_descr" class="form-control" placeholder="@lang('lang.description')"></textarea>
                        </div>
                        <div class="col-12 mb-15">
                            <input id="new_elon_phone_no" type="text" class="form-control" placeholder="@lang('lang.enter_the_phone_number')">
                        </div>
                        <div class="col-12 mt-20 mb-15 elon-notifications">
                            <button id="add_elon_btn" class="button float-right">@lang('lang.post_an_ad')</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div><!-- Content Body End -->

    @include('inc.footer')
@endsection


@section('scripts')

    <script src="/public/web_assets/js/plugins/dropify/dropify.min.js"></script>
    <script src="/public/web_assets/js/plugins/dropify/dropify.active.js"></script>
    <script src="/public/web_assets/js/customize_dropify.js"></script>
    <script src="/public/web_assets/js/plugins/nice-select/jquery.nice-select.min.js"></script>
    <script src="/public/web_assets/js/plugins/nice-select/niceSelect.active.js"></script>

@endsection
