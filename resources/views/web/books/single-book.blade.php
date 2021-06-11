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
            <div class="col-12 col-lg-12 mb-20">
                <div class="emat-item sb-item ">
                    <div class="sb-cover col-md-4  col-xs-7">
                        @if(!empty($book->image))
                            <img src="/public/uploads/books/{{ $book->id }}/{{$book->image}}" alt="{{ $book->title }}">
                        @else
                            <img src="/public/web_assets/images/e-mat/steve_jobs.jpg" alt="no-image">
                        @endif
                    </div>
                    <div class="content col-xs-7">
                        <span class="title">{!!  $book->title !!}</span><br>
                        <span class="autor">
                            @if(count($authors) > 0)
                                @foreach($authors as $item)
                                    {{ $item->author->name . '.' }}&nbsp;
                                @endforeach
                            @endif
                        </span>
                        <!--Score Start-->
                        <div class="box rating">
                            <input data-id="{{ $book->id }}" type="hidden" id="rate_book" value="{{ $point }}">

                                <div class="box-body">
                                    <div class="rating rating-score">
                                    </div>
                                </div>

                        </div>
                        <!--Score End-->
                        <span id="count_r" class="golos">{{ $c_point }} @lang('lang.ratings')</span>
                        <table class="specs-boks">
                            <tr>
                                <td>@lang('lang.year_publish'):</td>
                                <td>{{ $book->publish_year }}</td>
                            </tr>
                            <tr>
                                <td>@lang('lang.publish_house'):</td>
                                <td>{{ $book->publishing_house }}</td>
                            </tr>
                            <tr>
                                <td>@lang('lang.category'):</td>
                                <td>{{ $book->cats->title }}</td>
                            </tr>
                            <tr>
                                <td>@lang('lang.lang'):</td>
                                <td>{{ $book->langt->title }}</td>
                            </tr>
                            <tr>
                                <td>@lang('lang.license'):</td>
                                <td class="d-flex">
                                    <div class="lic-img">
                                        <img src="/public/uploads/books/licenses/{{ $book->lic->id . '/' . $book->lic->image }}" alt="">
                                    </div>
                                        <span class="ml-10 book-lic-descr"  data-tippy-animatefill="false" data-tippy-theme="dark"
                                              data-tippy-animation="perspective" data-tippy-content="{{ $book->lic->descr }}" data-tippy-arrow="true">?</span>
                                </td>
                            </tr>
                        </table>
                        <div class="col-12 mt-60">
                            <div class="row">
                                @if(count($book->bookFiles) > 0)
                                    @php
                                        $k=0
                                    @endphp
                                    @foreach($book->bookFiles as $file)
                                        @php
                                            $arr =explode(".", $file->file_name);
                                            $mime =  end($arr);
                                        @endphp
                                        @if($k==0)<div class="col-4">@endif

                                            <a href="{{ url('/public/uploads/books/'. $book->id . '/' . $file->file_name) }}" download="{{ $book->title . '.' . $mime }}" target="_blank">
                                                <span  class="d-block sbg-btn badge badge-pill badge-primary "> <i class="{{ ($file->file_type == 6)?  'ti-music-alt' : 'ti-book' }} mr-10"></i> @lang('lang.download')</span>
                                            </a>
                                            @if($file->file_type == 1)
                                                <a href="{{ url('/read-book/'. $book->id . '/' . $file->file_name) }}" target="_blank">
                                                    <span  class="d-block sbg-btn badge badge-pill badge-primary "> <i class="{{ ($file->file_type == 6)?  'ti-music-alt' : 'ti-book' }} mr-10"></i> @lang('lang.read')</span>
                                                </a>
                                            @endif
                                       {{-- <span  class="d-block sbg-btn badge badge-pill badge-primary mt-10"><i class="ti-music-alt mr-10"></i>Скачать</span>--}}
                                        @php($k+=1)

                                            @if($k==3)
                                                </div>
                                                @php($k=0)
                                            @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div><!-- Page Heading End -->
            <!--Basic Pill Start-->
            <div class=" col-xs-12 col-lg-12 col-12 pb-20 " style="background-color: #f5f5f5; ">

                <div class="box">
                    <div class="box-head">
                        <ul class="nav nav-pills">
                            <li class="nav-item pr-30"><a class="nav-link active" data-toggle="pill"
                                                          href="#home5">@lang('lang.description')</a>
                            </li>
                            {{--<li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#profile5">Отзывы</a>
                            </li>--}}
                        </ul>
                    </div>
                    <div class="box-body">

                        <div class="tab-content sb-coment">
                            <div class="tab-pane fade show active" id="home5">
                                <h4>{!!  $book->title !!} </h4>
                                <p>
                                    {!!   $book->description !!}
                                </p>
                            </div>
                            {{--<div class="tab-pane com fade" id="profile5">
                                <div class="comment-item d-flex pb-30">
                                    <div class="avata">
                                        <div class="avatar avatar-lg mr-10 mb-10">
                                            <img src="/public/web_assets/images/avatar/avatar-1.jpg" alt="">
                                            <!-- <span class="status"></span> -->
                                        </div>
                                    </div>
                                    <div class="coment col-md-8 col-xs-12 col-sm-6 col-lg-8">
                                        <div class="c-notification d-flex justify-content-between align-items-center">
                                            <span class="name"> Akmal</span>
                                            <span class="date">2 дня назад</span>
                                        </div>
                                        <p class="comment_text">
                                            Запомнилось и понравилось отношение Стива к выключателям. В конце книги
                                            он перед лицом смерти ведёт рассуждение, как оно случается? Есть ли
                                            жизнь после смерти? Или как выключатель. Дословно:
                                            Щелк! И тебя нет! Наверное, именно поэтому я никогда не любил ставить
                                            выключатели на устройства Apple. (Стив Джобс).
                                            Интересно, увлекательно и познавательно. Рекомендую, книга многогранна.
                                        </p>
                                    </div>

                                </div>

                                <div class="comment-item d-flex pb-30">
                                    <div class="avata">
                                        <div class="avatar avatar-lg mr-10 mb-10">
                                            <img src="/public/web_assets/images/avatar/avatar-1.jpg" alt="">
                                            <!-- <span class="status"></span> -->
                                        </div>
                                    </div>
                                    <div class="coment col-md-8 col-xs-12 col-sm-6 col-lg-8">
                                        <div
                                            class="c-notification d-flex justify-content-between align-items-center">
                                            <span class="name"> Akmal</span>
                                            <span class="date">2 дня назад</span>
                                        </div>
                                        <p class="comment_text">
                                            Запомнилось и понравилось отношение Стива к выключателям. В конце книги
                                            он перед лицом смерти ведёт рассуждение, как оно случается? Есть ли
                                            жизнь после смерти? Или как выключатель. Дословно:
                                            Щелк! И тебя нет! Наверное, именно поэтому я никогда не любил ставить
                                            выключатели на устройства Apple. (Стив Джобс).
                                            Интересно, увлекательно и познавательно. Рекомендую, книга многогранна.
                                        </p>
                                    </div>

                                </div>
                                <div class="comment-item d-flex pb-30">
                                    <div class="avata">
                                        <div class="avatar avatar-lg mr-10 mb-10">
                                            <img src="/public/web_assets/images/avatar/avatar-1.jpg" alt="">
                                            <!-- <span class="status"></span> -->
                                        </div>
                                    </div>
                                    <div class="coment col-md-8 col-xs-12 col-sm-6 col-lg-8">
                                        <div
                                            class="c-notification d-flex justify-content-between align-items-center">
                                            <span class="name"> Akmal</span>
                                            <span class="date">2 дня назад</span>
                                        </div>
                                        <p class="comment_text">
                                            Запомнилось и понравилось отношение Стива к выключателям. В конце книги
                                            он перед лицом смерти ведёт рассуждение, как оно случается? Есть ли
                                            жизнь после смерти? Или как выключатель. Дословно:
                                            Щелк! И тебя нет! Наверное, именно поэтому я никогда не любил ставить
                                            выключатели на устройства Apple. (Стив Джобс).
                                            Интересно, увлекательно и познавательно. Рекомендую, книга многогранна.
                                        </p>
                                    </div>

                                </div>







                                <div class="col-md-11 col-xs-11 col-sm-11 col-lg-11 add-comment-form">
                                    <textarea class=" col-sm-12 col-xs-12 col-md-12" id="add-comment" placeholder="Коментарироват ..."></textarea>
                                    <button class=" button button-primary std button-outline mt-20"> Отправить</button>

                                </div>
                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
            <!--Basic Pill End-->

            <div class="modal " id="errAuth">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header brbn d-block">
                            <h5>@lang('lang.you_dont_rate_this')</h5>
                            <h5 class="modal-title ml-10">
                               @lang('lang.to_rate_complate')
                                <a style="color: #1968df; text-decoration: underline;" href="{{ url('/login') }}">
                                    @lang('lang.login')</a>/<a style="color: #1968df; text-decoration: underline;" href="{{ url('/register') }}">
                                    @lang('lang.register')</a></h5>

                        </div>

                    </div>
                </div>
            </div>

        </div><!-- Page Headings End -->

        <!-- ######################################################################## -->






    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')


    <!-- OWl Carousel -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>


    <!-- Plugins & Activation JS For Only This Page -->
    <script src="/public/web_assets/js/plugins/raty/jquery.raty.js"></script>
    <script src="/public/web_assets/js/plugins/raty/raty.active.js"></script>
    <script src="/public/web_assets/js/vendor/bootstrap.min.js"></script>

    <script !src="">
        (function ($) {
            "use strict";
            var r=$('#rate_book').val();

            // Score
            if( $('.rating-score').length ) {
                $('.rating-score').raty({
                    score: r,
                    scoreName: 'sb_rate',
                });
            }

        })(jQuery);



    </script>

    <script !src="">
        (function ($) {


            $(document).on('click', '.rating-score', function () {

                var point = $('input[name ="sb_rate"]').val();
                var b_id = $('#rate_book').attr('data-id');

                var form_data = new FormData();
                form_data.append('point', point);
                form_data.append('b_id', b_id);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                    }
                });
                $.ajax({
                    url: '/rate-book',
                    data: form_data,
                    type: 'POST',
                    contentType: false,
                    cache: false,
                    processData: false,
                    //dataType: 'json',
                    beforeSend: function () {

                    },
                    success: function (data) {
                        if (data.err == 0) {
                            $('#count_r').html(data.c_r + ' оценок');
                            $('.rating-score').raty('score', data.point);

                        }
                        else{
                            jQuery.noConflict();
                            $('#errAuth').modal('show');
                        }

                    },
                    error: function (data) {
                        console.log(data);

                    }
                });

            });
        })(jQuery);

    </script>




    @endsection
