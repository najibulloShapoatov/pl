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
        <!-- ---------------------------------------------------------------------------------------------- -->
        <!-- Page Headings Start -->
        <div class="row ">
            <!-- Page Heading Start -->
            <div class="col-12 mb-20">
                <div class="page-heading main d-flex">
                    <div class="col-11 pl-0 d-flex">
                    <h3>@lang('lang.file_share')&nbsp;&nbsp;</h3>
                    @if(Auth::check() && Auth::user()->role_id == 1 )
                        <span class="my-tests pt-1 pl-20">
                        <a href="{{ url('/file-sharing-manage') }}">
                            <h5>@lang('lang.manage')</h5>
                        </a>
                        </span>
                    @endif
                    </div>
                    <div class="col-1 pr-0">
                        <div class="d-flex align-items-center pull-right">
                            <a class="faq-link" href="/faq#Файлобменник">
                                <img src="/public/web_assets/images/icons/faq-black.svg" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- Page Heading End -->
            <div class="uploding-file col-sm-12 ">
            <div class="col-12 mb-10 pl-0 pr-0 ">
                <input type="file" id="input-file-now-sharing"   data-max-file-size="{{ $max_size_file }}M" class="dropify-file-sharing" />
            </div>
            <div id="succes" class="col-12 mb-20 d-none justify-content-center">
                <p class="text-center"> *@lang('lang.your_link_available') &nbsp;&nbsp;<strong id="end-date"></strong></p>
                <p class="text-center">
                    <a id="link_succes" href=""></a>

                <div class="box-body d-flex align-items-center">
                    <input id="inputClipboard" type="text" class="form-control" value="">
                    <button class="button button-primary button-clipboard mb-0 ml-30" data-clipboard-target="#inputClipboard">@lang('lang.copy')</button>
                </div>
                </p>
            </div>
                <div class="col-12 mb-20 d-flex justify-content-center align-items-center">
                    <button id="file_sharing_btn" class="button button-primary button-outline">@lang('lang.share')</button>
                </div>
            </div>

        </div><!-- Page Headings End -->


    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')

    <!-- OWl Carousel -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>

    <script src="/public/web_assets/js/plugins/dropify/dropify.min.js"></script>
    <script src="/public/web_assets/js/plugins/dropify/dropify.active.js"></script>
    <script src="/public/web_assets/js/customize_dropify.js"></script>


    <!-- Plugins & Activation JS For Only This Page -->
    <script src="/public/web_assets/js/plugins/clipboard/clipboard.min.js"></script>
    <script src="/public/web_assets/js/plugins/clipboard/clipboard.active.js"></script>
    @endsection
