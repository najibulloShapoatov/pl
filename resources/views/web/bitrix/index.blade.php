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
    <div class="content-body d-flex justify-content-center align-items-center" >
        <!-- ---------------------------------------------------------------------------------------------- -->
        <!-- Page Headings Start -->
        <div class="row ">
            <!-- Page Heading Start -->
            <div class="col-12 mb-20 mt-15 d-flex justify-content-center align-items-center">
                <img class="bitrix_backgr" src="/public/web_assets/images/bitrix/bitrix%20background.png" alt="">
                <div class=" col-sm-12 col-md-7  col-lg-7 d-flex justify-content-center align-items-center">
                   <div class="brt">
                       <img class="mb-25" src="/public/web_assets/images/bitrix/logo%20bitrix.png" alt=" " style="margin-top: 4%; width: 100%">
                       <p class="mb-25 pl-15">@lang('lang.bitrix_text1')</p>
                       <div class="col-12">
                           <div class="m-auto">
                               <div style="padding-left: 7%; padding-right: 7%;">
                                   <span class="ml-5">@lang('lang.bitrix_text2')</span>
                                   <h4 class="noselect  text-center mt-10">S18-NA-PD1WFIPIWCBA4VBA</h4>
{{--                                   <input disabled class="form-control noselect primary text-center mt-10" type="text" readonly value="S18-NA-PD1WFIPIWCBA4VBA">--}}
                               </div>
                           </div>
                       </div>
                   </div>
                </div>
            </div>
        </div><!-- Page Headings End -->


    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')
    @endsection
