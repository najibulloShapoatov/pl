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
                <div class="page-heading">
                    <h3>@lang('lang.edit')</h3>
                </div>
            </div>

        </div><!-- Page Headings End -->

        <div class="col-xs-12 col-sm-12  col-12 mb-20">

            <div class="row mbn-15">
                <div class="row">
                    <div class="col-12 mb-15">
                        <input id="edited_name_site" type="text" class="form-control" placeholder="@lang('lang.name')" value="{!! $data->name !!}">
                    </div>
                    <div class="col-12 mb-15">
                        <input id="edited_adres_site" type="text" class="form-control" placeholder="@lang('lang.addres')" value="{!! $data->adress !!}">
                    </div>
                    <div class="col-12 mb-15">
                        <input id="edited_phone_site" type="text" class="form-control" placeholder="@lang('lang.phone')" value="{!! $data->phone_no !!}">
                    </div>
                    <div class="col-12 mb-15">
                        <input id="edited_email_site" type="text" class="form-control" placeholder="@lang('lang.e_mail')" value="{!! $data->email !!}">
                    </div>
                    <div class="col-12 mb-15">
                        <input id="edited_f_l_site" type="text" class="form-control" placeholder="@lang('lang.facebook')" value="{!! $data->facebook_link !!}">
                    </div><div class="col-12 mb-15">
                        <input id="edited_i_l_site" type="text" class="form-control" placeholder="@lang('lang.instagram')" value="{!! $data->instagram_link !!}">
                    </div>
                    <div class="col-12 mb-15">
                        <input id="edited_y_l_site" type="text" class="form-control" placeholder="@lang('lang.you_tube')" value="{!! $data->youtube_link !!}">
                    </div>


                    <div class="col-12 mb-15">
                        <button data-id="{{ $data->id }}" id="save_edited_site_customize" class="button button-success fl-right" style="text-transform: none">@lang('lang.save')</button>
                    </div>


                </div>
            </div>
        </div>
    </div><!-- Content Body End -->




    @include('inc.footer')
@endsection


@section('scripts')
    <!-- Plugins & Activation JS For Only This Page -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

@endsection
