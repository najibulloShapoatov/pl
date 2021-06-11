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
        <div class="row">
            <!-- Page Heading Start -->
            <div class="col-md-12 col-sm-12 col-xs-12 col-12 col-lg-auto pl-20 mb-20">
                <div class="page-heading d-flex">
                    <h3> Контакты</h3>
                    @if(Auth::check() && Auth::user()->role_id == 1)
                        <span class="my-tests pt-1 pl-20">
                                <a href="{{ url('/about-manage') }}">
                                    <h5>@lang('lang.manage')</h5>
                                </a>
                            </span>
                    @endif
                </div>
            </div>

        </div><!-- Page Headings End -->
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-xs-12 col-md-12 col-12 mb-30 ">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="row">
                        <div class="box contacts">
                            <div class="box-body">
                                <table class="table conts">
                                    <tbody>
                                    <tr>
                                        <th>@lang('lang.phone')</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $Infodata->phone_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('lang.e_mail')</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $Infodata->email }}</td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="row">
                        <div class="box contacts">
                            <div class="box-body">
                                <table class="table conts">
                                    <tbody>
                                    <tr>
                                        <th>@lang('lang.addres')</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $Infodata->adress }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('lang.we_are_in_the_socials')</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p class="social-ite" style="font-size: 20px;">
                                                <a href="{{ $Infodata->facebook_link }}" class="ml-1 mr-1"><i class="fab fa-facebook-square"></i></a>
                                                <a href="{{ $Infodata->instagram_link }}" class="ml-1 mr-1"><i class="fab fa-instagram"></i></a>
                                                <a href="{{ $Infodata->youtube_link }}" class="ml-1 mr-1"><i class="fab fa-youtube"></i></a>
                                            </p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-30 col-lg-12 col-sm-12 col-xs-12 col-md-12 col-12 mb-30">
                <div class="col-md-6 col-sm-12 pr-30 col-xs-12 mb-30">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div><br />
                    @endif

                    @if($sts ==1)
                            <div class="alert alert-success" role="alert">
                                @lang('lang.succes_send')
                            </div>
                    @endif

                    <form method="post" action="{{url('captcha')}}" class="contact-form">
                        @csrf
                        <div class="col-12 mb-15">
                            <input name="fio" type="text" class="form-control" placeholder="@lang('fio')">
                        </div>
                        <div class="col-12 mb-15">
                            <input name="email_phone" type="text" class="form-control" placeholder="@lang('lang.enter_your_email')">
                        </div>
                        <div class="col-12  mb-15">
                            <select name="topic" class="form-control">
                                <option value="">@lang('lang.select_topic')</option>
                                <option value="Жалоба">@lang('lang.jaloba') </option >
                                <option value="Предложение">@lang('lang.predlojenie')</option>
                                <option value="Задать вопрос">@lang('lang.ask_question')</option>
                            </select>
                        </div>
                        <div class="col-12  mb-15">
                            <select id="facult_select" name="faculty-feed" class="form-control">
                                <option value=""> @lang('lang.select_facult')</option>
                                @if(count($fac)>0)
                                    @foreach($fac as $f)
                                        <option value="{{ $f->id }}">{!! $f->title !!}</option >
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-12  mb-15">
                            <select id="to_whom" name="fed-to" class="form-control">
                                <option value="">@lang('lang.to_who')</option>
                                <option value="admin">@lang('lang.admin')</option>
                                <option value="booker">@lang('lang.booker')</option>
                            </select>
                        </div>
                        <div class="col-12 mb-15">
                            <textarea name="text" class="form-control hh100" placeholder="@lang('lang.text')"></textarea>
                        </div>
                       {{-- <div class="col-12 d-flex">
                            <div class="col-6 mb-15">
                                <img src="/public/web_assets/images/capcha/capcha.png" alt="">
                            </div>
                            <div class="col-6 mb-15">
                                <input type="text" class="form-control" placeholder="">
                            </div>
                        </div>--}}
                        <div class="row ml-0 mr-0 mb-15">
                            <div class="col-12"></div>
                            <div class="form-group col-md-10">
                                <div class="captcha d-flex">
                                    <span>{!! captcha_img() !!}</span>
                                    <button type="button" class="btn btn-success ml-20"><i class="fa fa-refresh" id="refresh"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="row ml-0 mr-0 mb-15">
                            <div class="col-md-10"></div>
                            <div class="form-group col-md-10">
                                <input id="captcha" type="text" autocomplete="off" class="form-control" placeholder="@lang('lang.enter_code_from_image')" name="captcha"></div>
                        </div>

                        <div class="col-12 mb-15">
                            <button type="submit" class="button button-success w-100">
                                <span>@lang('lang.send')</span>
                            </button>
                        </div>

                    </form>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    {{--<div id="google-map-marker" class="google-map google-map-marker">
                    </div>--}}
{{--                    <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Ab0539e2a3fa0143fa66ed90c286adaba80ed38069241bd7550e28819e4afd78c&amp;source=constructor" width="100%" height="400" frameborder="0"></iframe>--}}
                    <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Ab0539e2a3fa0143fa66ed90c286adaba80ed38069241bd7550e28819e4afd78c&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>

                </div>
            </div>
        </div>

    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')
{{--    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfmCVTjRI007pC1Yk2o2d_EhgkjTsFVN8"></script>--}}{{--
    <script src="/public/web_assets/js/plugins/google-map/googlemap.active.js"></script>--}}

    <!-- OWl Carousel -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>


    <script type="text/javascript">
        $('#refresh').click(function(){
            $.ajax({
                type:'GET',
                url:'refreshcaptcha',
                success:function(data){
                    $(".captcha span").html(data.captcha);
                }
            });
        });
    </script>





    @endsection
