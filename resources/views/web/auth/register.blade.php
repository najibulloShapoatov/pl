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


    <!-- Content Body Start -->
    <div class="content-body m-0 p-0" style="width: 100%">

        <div class="login-register-wrap">
            <div class="row">

                <div class="d-flex align-self-center justify-content-center order-2 order-lg-1 col-lg-5 col-12">
                    <div class="login-register-form-wrap show">

                        <div class="content">
                            <h1>@lang('lang.register')</h1>
                        </div>

                        <div class="error hide"></div>

                        <div class="login-register-form">
                            <form>

                                <div class="row">

                                    <div class="col-12 mb-20">
                                        <input class="form-control" autocomplete="off"
                                               type="text" id="registerFio" placeholder="@lang('lang.fio')">
                                    </div>
                                   {{-- <div class="col-12 mb-20">
                                        <div class="box box-border-less p-0">
                                            <div class="cto">
                                                <select class="form-control nice-select" id="registerType">
                                                    <option value="">Кто вы?</option>
                                                    <option value="5">Обычный ползователь</option>
                                                    <option value="2">Преподаватель</option>
                                                    <option value="3">Студент</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>--}}
                                    <div class="col-12 mb-20">
                                        <input class="form-control" autocomplete="off" type="text" id="registerLogin" placeholder="@lang('lang.text_login')">
                                    </div>
                                    <div class="col-12 mb-20">
                                        <input class="form-control" autocomplete="off" type="password" id="registerPassword" placeholder="@lang('lang.password')">
                                    </div>
                                    <div class="col-12 mb-20">
                                        <input class="form-control" autocomplete="off" id="registerConfirmPassword" type="password" placeholder="@lang('lang.repeat_password')">
                                    </div>
                                    <div class="col-12">
                                        <div class="row justify-content-between">
                                            <div class="col-auto mb-15 auth ml-10">@lang('lang.have_account') <a href="{{ url('/login/') }}">@lang('lang.login')</a></div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-10">
                                        <button class="button button-primary button-outline" id="registerSubmit">@lang('lang.register')</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="succes hide">
                        <i class="ti-check"></i>
                        <p>@lang('lang.register_succes')</p>
                    </div>
                </div>

                <div class="login-register-bg reg order-1 order-lg-2 col-lg-7 col-12">
                    <div class="content">
                        <h1>@lang('lang.register')</h1>

                    </div>
                </div>

            </div>
        </div>

    </div><!-- Content Body End -->

@endsection


@section('scripts')
    <script>
        (function ($) {

            // registration
            $(document).on("click", "#registerSubmit", function(e){
                e.preventDefault();

                var r_fio = $('#registerFio').val();
               // var r_type = $('#registerType').val();
                var r_login = $('#registerLogin').val();
                var r_pass = $('#registerPassword').val();
                var r_cpass = $('#registerConfirmPassword').val();

                var form_data = new FormData();
                form_data.append('fio', r_fio);
               // form_data.append('utype', r_type);
                form_data.append('login', r_login);
                form_data.append('pass', r_pass);
                form_data.append('cpass', r_cpass);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                    }
                });

                $.ajax({
                    url: '/register_data',
                    data: form_data,
                    type: 'POST',
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType : 'json',
                    beforeSend: function(){
                        $('#registerSubmit').prop('disabled', true).html('В процессе');
                    },
                    success: function (data) {
                        //console.log(data);

                        // error
                        if (data.input.error_code === 1) {
                            $('#registerSubmit').prop('disabled', false).html('Регистрация');
                            $('.error').addClass('show').fadeIn(1000).html(data.input.msg);
                        }

                        // success
                        if (data.input.error_code === 0) {
                            $('.login-register-form-wrap').removeClass('show').addClass('hide');
                            $('.succes').removeClass('hide').addClass('show');
                            setTimeout("location.href = '/'", 1000);
                        }

                    },
                    error: function( data ) {
                        console.log(data);
                    }


            });


                // console.log(fio);
                // console.log(registerType);
                // console.log(registerLogin);
                // console.log(registerPassword);
                // console.log(registerConfirmPassword);




            });

        })(jQuery);
    </script>
@endsection
