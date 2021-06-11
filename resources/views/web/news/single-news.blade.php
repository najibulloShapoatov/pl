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

        <div class="row ">
            <div class="col-12 col-lg-auto mb-20">
                <div class="page-heading n-s-title">
                    <h4>{{ $news->title }}</h4>
                    <span class="pt-10" ><i class="ti-calendar"></i>&nbsp; {{ date('d.m.Y', strtotime($news->created_at)) }}</span>
                    <span class="pl-45 pt-10"><i class="ti-eye"></i>&nbsp;{{ $news->viewed }}</span>

                </div>
            </div>
        </div>
        <div class="row">
            <div class=" n-single col-md-12 col-lg-auto col-12 col-xs-12">
                @if($news->image)
                    <img src="/public/uploads/news/{{ $news->id .'/' . $news->image }}" alt="">
                @else
                    <img src="/public/web_assets/images/news/Layer.png" alt="">
                @endif
                <p class="pt-30 pb-50">
               {{-- {!!    ($news->text_detail)->render() !!}--}}
                    {!!html_entity_decode($news->text_detail)!!}
                </p>
            </div>
           {{-- <!--Basic Pill Start-->
            <div class=" col-xs-12 col-lg-12 col-12 pl-0 pr-0 b-cc">
                <div class="box">
                    <div class="box-head">
                     <h4>Коментарии</h4>
                    </div>
                    <div class="box-body">
                                <div class="comment-item d-flex pb-30">
                                    <div class="avata">
                                        <div class="avatar avatar-lg mr-10 mb-10">
                                            <img src="/public/web_assets/images/avatar/avatar-1.jpg" alt="">
                                            <!-- <span class="status"></span> -->
                                        </div>
                                    </div>
                                    <div class="coment col-md-11 col-xs-11 col-sm-11 col-lg-11">
                                        <div
                                            class="c-notification d-flex justify-content-between align-items-center">
                                            <span class="name"> Akmal</span>
                                            <span class="date">2 дня назад</span>
                                        </div>
                                        <p class="comment_text mt-10">
                                            Запомнилось и понравилось отношение Стива к выключателям. В
                                            конце книги
                                            он перед лицом смерти ведёт рассуждение, как оно случается?
                                            Есть ли
                                            жизнь после смерти? Или как выключатель. Дословно:
                                            Щелк! И тебя нет! Наверное, именно поэтому я никогда не
                                            любил ставить
                                            выключатели на устройства Apple. (Стив Джобс).
                                            Интересно, увлекательно и познавательно. Рекомендую, книга
                                            многогранна.
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
                                    <div class="coment col-md-11 col-xs-11 col-sm-11 col-lg-11">
                                        <div
                                            class="c-notification d-flex justify-content-between align-items-center">
                                            <span class="name"> Akmal</span>
                                            <span class="date">2 дня назад</span>
                                        </div>
                                        <p class="comment_text mt-10">
                                            Запомнилось и понравилось отношение Стива к выключателям. В
                                            конце книги
                                            он перед лицом смерти ведёт рассуждение, как оно случается?
                                            Есть ли
                                            жизнь после смерти? Или как выключатель. Дословно:
                                            Щелк! И тебя нет! Наверное, именно поэтому я никогда не
                                            любил ставить
                                            выключатели на устройства Apple. (Стив Джобс).
                                            Интересно, увлекательно и познавательно. Рекомендую, книга
                                            многогранна.
                                        </p>
                                    </div>

                                </div>
                                <div class="col-md-11 col-xs-11 col-sm-11 col-lg-11 add-comment-form">
                                        <textarea class=" col-sm-12 col-xs-12 col-md-12" id="add-comment" placeholder="Коментарироват ..."></textarea>
                                        <button class=" button button-primary std button-outline mt-20"> Отправить</button>

                                </div>
                    </div>
                </div>
            </div>
            <!--Basic Pill End-->--}}
        </div>

    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')



@endsection
