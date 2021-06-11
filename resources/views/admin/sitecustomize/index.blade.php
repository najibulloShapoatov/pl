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
                <h3>@lang('lang.manage_site_settings')</h3>
                <span class="my-tests pt-1 pl-20">
                    <a href="{{ url('/edit-site-customize') }}">
                        <h5>@lang('lang.edit')</h5>
                    </a>
                </span>
                {{--<span class="my-tests pt-1 pl-20">
                    <a href="{{ url('/admin-pool') }}">
                        <h5>Голосование</h5>
                    </a>
                </span>--}}
            </div>

            <div>
            </div>
        </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                @if($data)
                    <div class="">
                        <table class="table table-bordered table-hover m-0">
                            <tbody>
                                <tr >
                                    <td  width="25%">@lang('lang.name')</td>
                                    <td>{{ $data->name }}</td>
                                </tr>
                                <tr >
                                    <td  width="25%">@lang('lang.addres')</td>
                                    <td width="75%">{{ $data->adress }}</td>
                                </tr>
                                <tr >
                                    <td  width="25%">@lang('lang.phone')</td>
                                    <td width="75%">{{ $data->phone_no }}</td>
                                </tr>
                                <tr >
                                    <td  width="25%"> @lang('lang.e_mail')</td>
                                    <td width="75%">{{ $data->email }}</td>
                                </tr>
                                <tr >
                                    <td  width="25%">@lang('lang.facebook')</td>
                                    <td width="75%">{{ $data->facebook_link }}</td>
                                </tr>
                                <tr >
                                    <td  width="25%">@lang('lang.instagram')</td>
                                    <td width="75%">{{ $data->instagram_link }}</td>
                                </tr>
                                <tr >
                                    <td  width="25%">@lang('lang.you_tube')</td>
                                    <td width="75%">{{ $data->youtube_link }}</td>
                                </tr>

                            </tbody>
                        </table>
                        <div class="clearfix mb-20"></div>
                    </div>
                @else
                    <p>@lang('lang.no_data')</p>
                @endif
            </div>
        </div>
    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')

@endsection
