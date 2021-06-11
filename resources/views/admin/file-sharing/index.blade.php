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
            <div class="col-12 col-lg-auto mb-20">
                <div class="page-heading main d-flex">
                    <h3>@lang('lang.settings_fileSharing')&nbsp;&nbsp;</h3>
                    @if(Auth::check() && Auth::user()->role_id == 1 )
                        <span class="my-tests pt-1 pl-20">
                        <a href="{{ url('/faylobmennik') }}">
                            <h5>@lang('lang.file_share')</h5>
                        </a>
                        </span>
                    @endif
                </div>
            </div><!-- Page Heading End -->
            <div class="uploding-file col-sm-12 ">
                <div class="col-lg-6 col-12 pl-0  mb-20">
                    <div id="succes_file_sharing" class="alert alert-success d-none" role="alert">
                    </div>
                    <h6 class="mb-15">@lang('lang.set_file_sharing_restrictions') <span>(MB)</span></h6>

                    <div class="row mbn-15">
                        <div class="col-12 d-flex mb-15 ">
                            <input id="file_share_input_settings" type="text" class="form-control form-control-sm file-share-settings-input" placeholder="@lang('lang.enter_file_sharing_restrictions')" value="{{ $max_size_file }}">
                            <button id="save_file_sharing_settings_btn" class="button std ml-20 button-primary button-outline mb-0">@lang('lang.save')</button>
                        </div>
                    </div>
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
