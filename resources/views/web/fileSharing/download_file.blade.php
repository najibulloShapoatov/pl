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
                <div class="page-heading main">
                    <h3>{{ $file->file_real_name }}&nbsp;&nbsp;</h3>
                </div>
            </div><!-- Page Heading End -->
            <div class="downloading-file  col-sm-12">
                <div class="col-12 pl-0 mb-10 pr-0">
                    <a href="{{ url('/public/uploads/file-shared/' . $file->file_name) }}" download="{{ $file->file_real_name }}" class="button text-center btn-download-filesharing">
                        <i class="zmdi zmdi-format-valign-bottom zmdi-hc-fw"></i>
                    </a>
                </div>

                <div class="col-12 mb-20 justify-content-center">
                    <p class="text-center"> *@lang('lang.file_dostupen') {{ $file->end_date }}</p>
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
    @endsection
