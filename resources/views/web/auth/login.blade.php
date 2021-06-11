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
                    <div class="login-register-form-wrap">

                        <div class="content">
                            <h1 >Вход</h1>
                            <div class="col-12 pl-0 mb-20">
                                <h6 class="mb-15">@lang('lang.who_are_you')</h6>
                                <div class="adomx-checkbox-radio-group inline">
                                    <input type="hidden" value="1" id="user_type">
                                    <label class="adomx-radio-2">
                                        <input data-id="1" class="userType" checked type="radio" name="userType">
                                        <i class="icon"></i> @lang('lang.student')
                                    </label>
                                    <label class="adomx-radio-2">
                                        <input data-id="2" class="userType" type="radio" name="userType">
                                        <i class="icon">
                                        </i> @lang('lang.teacher')
                                    </label>
                                    <label class="adomx-radio-2">
                                        <input data-id="0" class="userType" type="radio" name="userType">
                                        <i class="icon"></i> @lang('lang.user')
                                    </label>
                                </div>
                            </div>
                            <div class="error hide"></div>
                        </div>

                        <div class="login-register-form">
                            <form>
                                <div class="row">
                                    <div class="col-12 mb-20">
                                        <input autocomplete="off" class="form-control" autocomplete="off" id="login" type="text" placeholder="@lang('lang.text_login')">
                                    </div>
                                    <div class="col-12 mb-20">
                                        <input class="form-control" autocomplete="off" id="password" type="password" placeholder="@lang('lang.password')">
                                    </div>
                                    <div class="col-12 mb-20">
                                        <label for="remember" class="adomx-checkbox-2" style="font-size: 13px;">
                                            <input  id="remember" type="checkbox" value="0">
                                            <i class="icon"></i>@lang('lang.remember')</label>
                                    </div>
                                    <div class="col-12">
                                        <div class="row justify-content-between">
                                            <div class="col-auto mb-15 auth" style="font-size: 13px;"><a href="#">@lang('lang.forgot_your_password')</a></div>
                                            <div class="col-auto mb-15 auth" style=" font-size: 13px;">@lang('lang.no_account') <a
                                                    href="{{ url('/register/') }}">@lang('lang.sign_up')</a></div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-10">
                                        <button id="loginSubmit"
                                                class=" breg button button-primary button-outline">@lang('lang.login')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="login-register-bg order-1 order-lg-2 col-lg-7 col-12">
                    <div class="content">
                        <h1>@lang('lang.login')</h1>
                    </div>
                </div>

            </div>
        </div>

    </div><!-- Content Body End -->
@endsection


@section('scripts')


    <script>
        (function ($) {

            // remember me
            $(document).on('change', '#remember', function() {
                if(this.checked) {
                    $('#remember').val(1);
                }
                else{
                    $('#remember').val(0);
                }
            });

            // login
            $(document).on("click", "#loginSubmit", function(e){
                e.preventDefault();

                var login = $('#login').val();
                var password = $('#password').val();
                var remember_me = $("#remember").val();
                let user_type = $('#user_type').val();

                var form_data = new FormData();
                form_data.append('login', login);
                form_data.append('password', password);
                form_data.append('user_type', user_type);
                form_data.append('remember_me', remember_me);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                    }
                });
                $.ajax({
                    url: '/login',
                    data: form_data,
                    type: 'POST',
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType : 'json',
                    beforeSend: function(){
                        $('#loginSubmit').prop('disabled', true);
                        $('#loginSubmit').html('В процессе ...');
                    },
                    success: function( data ) {
                        console.log(data);

                        // error
                        if(data.err == 1){
                            $('#loginSubmit').prop('disabled', false);
                            $('#loginSubmit').html('Войти');
                            $('.error').fadeIn(500).removeClass('hide').addClass('show').html(data.msg);
                        }

                       // success
                        if(data.err == 0){
                            $('#loginSubmit').prop('disabled', true);
                            $('#loginSubmit').html('В процессе ...');
                            // $('.js-validation-signin').fadeOut(500).remove();
                            // $('.login-in-result').fadeIn(500).html('<span class="text-success">'+data.input.msg+'</span>');
                            setTimeout("location.href = '/'", 100);
                        }

                    },
                    error: function( data ) {
                        console.log(data);
                    }
                });

            });


        })(jQuery);
    </script>

    <!-- OWl Carousel -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>

@endsection
