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

                    <a href="{{ url('/news')  }}">
                        <h3>@lang('lang.latest_news')&nbsp;&nbsp;
                            <img style="width: 30px; height: 30px;" src="/public/web_assets/images/icons/arrow_forward_48px.svg" alt="">
                        </h3>
                    </a>
                </div>
            </div><!-- Page Heading End -->

            <!-- Page Button Group Start -->
            <!-- <div class="col-12 col-lg-auto mb-20">
                <div class="page-date-range">
                    <input type="text" class="form-control input-date-predefined">
                </div>
            </div> -->
            <!-- Page Button Group End -->

        </div><!-- Page Headings End -->

        <!-- News -->
        <div class="row news mb-20">
            @if(count($homeNews) > 0)
                @php
                    $i=1;
                @endphp
                <div class=" col-sm-12  col-md-8 ">
                    @foreach($homeNews as $item)
                        @if($i==1)
                                <div data-id="{{ $item->id }}" class="news-item mb-10">
                                    @if(!empty($item->image))
                                        <img src="/public/uploads/news/{{ $item->id }}/{{ $item->image }}" alt="{{ $item->title }}">
                                    @else
                                        <img src="/public/web_assets/images/news/Layer.png" alt="no-image">
                                    @endif

                                    <div class="n-content">
                                        <div class="n-notifications d-flex">
                                            {{--<a href="#">Раздел</a>--}}
                                            <span class="n-date ml-3"><i class="ti-calendar"></i>&nbsp;&nbsp; {{ date('d.m.Y', strtotime($item->created_at)) }}</span>
                                        </div>
                                        <a href="{{ url('/news/' . $item->id) }}" class=" ml-2"><p>{{ $item->title }}</p></a>
                                    </div>
                                </div>
                            </div>
                            <div class=" col-sm-12  col-md-4">
                                <div class="n-items">
                        @else
                                <div data-id="{{ $item->id }}" class=" news-item " >
                                    @if(!empty($item->image))
                                        <img src="/public/uploads/news/{{ $item->id }}/{{ $item->image }}" alt="{{ $item->title }}">
                                    @else
                                        <img src="/public/web_assets/images/news/Layer.png" alt="no-image">
                                    @endif
                                    <div class="n-content">
                                        <div class="n-notifications d-flex">
                                            {{--<a href="#">Раздел</a>--}}
                                            <span class=" ml-3 "><i class="ti-calendar"></i>&nbsp;{{ date('d.m.Y', strtotime($item->created_at)) }}</span>
                                        </div>
                                        <a href="{{ url('/news/' . $item->id) }}" class=" ml-2">
                                            <p class=" ml-2">{{ $item->title }}</p></a>
                                    </div>
                                </div>

                        @endif
                        @php
                            $i++;
                        @endphp
                    @endforeach
                                </div>
                </div>
            @endif
        </div><!-- News End -->
        <!-- -------------------------------------------------------------------------------------------------------- -->
        <!-- E_Materials -->
        <div class="row ">
            <!-- Page Heading Start -->
            <div class="col-12 col-lg-auto mb-20 mt-20">
                <div class="page-heading main">
                    <a href="{{ url('/library') }}">
                    <h3>@lang('lang.library')&nbsp;&nbsp;
                        <img style="width: 30px; height: 30px;" src="/public/web_assets/images/icons/arrow_forward_48px.svg" alt="">
                    </h3>
                    </a>
                </div>
            </div><!-- Page Heading End -->
        </div><!-- Page Headings End -->

        <div class="row e-mats">


            <div class="col-sm-12">
                <div class="row">
                    <div id="owl-example" class="owl-carousel">
                        @if(count($books) > 0)
                            @foreach($books as $item)
                            <div class="col-sm-12">
                                <div data-id="{{ $item->id }}" class="em-item">
                                    @if(!empty($item->image))
                                        <div class="home-book-img">
                                            <img src="/public/uploads/books/{{ $item->id }}/{{ $item->image }}" alt="{{ $item->title }}">
                                        </div>
                                    @else
                                        <img src="/public/web_assets/images/e-mat/steve_jobs.jpg" alt="no-image">
                                    @endif

                                    <div class="d-flex justify-content-center">
                                        <a href="{{ url('/book/' . $item->id) }}">@lang('lang.view')</a></div>
                                        <p>{!!  mb_substr($item->title, 0, 50) !!}<br>
                                            <span>
                                               @if(count($item->authorList) > 0)
                                                    @foreach($item->authorList as $author)
                                                        {{ mb_substr($author->author->name . '.', 0, 20) }}&nbsp;
                                                        @break
                                                    @endforeach
                                                @endif
                                            </span>
                                        </p>

                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>



        </div><!-- E_materials End -->
        <!-- -------------------------------------------------------------------------------------------------- -->
        <div class="row  mt-50">
            <!-- Page Heading Start -->
            <div class="col-12 col-lg-auto mb-20">
                <div class="page-heading main">
                    <a href="{{ url('/video-course') }}">
                    <h3>@lang('lang.videocourses')&nbsp;&nbsp;
                        <img style="width: 30px; height: 30px;" src="/public/web_assets/images/icons/arrow_forward_48px.svg" alt="">
                    </h3>
                    </a>
                </div>
            </div>
        </div><!-- Page Heading End -->
        <div class=" row ">
            <div class="col-sm-12">
                <div class="row">
                    <div id="owl-example2" class="owl-carousel">
                        @if(count($videocourse)>0)
                            @foreach($videocourse as $item)
                                <div class="col-sm-12 ">
                                    <div data-id="{{ $item->id }}" class=" vl-item ">
                                        @if($item->image)
                                            <img src="/public/uploads/videocourse/{{ $item->id . '/' . $item->image }}">
                                        @else
                                            <img src="/public/web_assets/images/default-v-course.jpg">
                                        @endif
                                        <a href="{{ url('/videocourse/'. $item->id) }}">
                                            <p class=" ml-2">{!!  mb_substr($item->title, 0, 70) !!}</p>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-60">
            <div class="col-sm-12">
                <div class="col-md-4 pl-0">
                    <div class="voting">
                        <div class="title">@lang('lang.pooling')</div>
                        <div class="content">
                            <p>{{ $pool->title }} </p>
                            <div class="box-body voting-loading hide d-flex justify-content-center align-items-center">
                                <div class="spinner-border">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <div id="pool_res_percent" class="box-body voting-progres {{ ($isPolled)? '' : 'hide' }}">
                                @if(count($pool->answers) > 0)
                                    @foreach($pool->answers as $answer)
                                        <span class="pool-res-text">{{ $answer->title }}</span>
                                        <div class="progress">
                                            @php
                                                $n=0;
                                                if($p_res > 0){$n = (count($answer->poolres)/$p_res)*100;}
                                            @endphp
                                            <div class="progress-bar" role="progressbar" style="width: {{ ($n < 13)? 13.5 : number_format($n, 2, '.', ' ') }}%" aria-valuenow="{{ number_format($n, 1, '.', ' ') }}"
                                                 aria-valuemin="0" aria-valuemax="100">{{ number_format($n, 1, '.', ' ') }}%</div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="adomx-checkbox-radio-group voting-radio {{ ($isPolled)? 'hide': 'show' }} ">
                                @if(count($pool->answers) > 0)
                                    <input type="hidden" id="pool_selected" value="">

                                    @foreach($pool->answers as $answer)
                                    <label  class="adomx-radio">
                                        <input data-id="{{ $answer->id }}" type="radio" class="pool-input" name="adomxRadio">
                                        <i class="icon"></i>
                                        {{ $answer->title }}</label>
                                    @endforeach
                                @endif
                            </div>
                            <div class="d-flex justify-content-center btn-voting">
                                @if($isPolled)
                                    <span class="polled">@lang('lang.thanks')</span>
                                @else
                                    <span id="polling" >@lang('lang.pool') </span>
                                   {{-- <a data-id="{{ $pool->id }}" id="result_pool" style="font-weight: 400;" >Резултаты</a>--}}
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="forum">
                        <div class="title">@lang('lang.forum')</div>
                        <div class="content pt-50">
                            <i style="font-size: 100px;"
                               class="fas fa-users d-flex justify-content-center align-items-center"></i>
                            <a href="{{ url('/forum/') }}">@lang('lang.go_to')</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 pr-0">
                    <div class="test">
                        <div class="title ">@lang('lang.test')</div>
                        <div class="content pt-50">

                            <i style="font-size: 100px;"
                               class="fas fa-clipboard-list d-flex justify-content-center align-items-center">
                            </i>

                            <a href="{{ url('/testing/') }}">@lang('lang.pass_the_test')</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>




        <!-- SEND MAil -->



        <div class="col-md-12 mt-60" style="background-color: #257ad1; height: 127px;">
            <div class="mailing">
                <img src="/public/web_assets/images/mail/mailing-wall.png">
                <div class="content d-flex  justify-content-between align-items-center">

                    <p>@lang('lang.subscribe_text')</p>
                    <div class="email">
                        <div class="email-form">
                            <form >
                                <button id="footer-newsletter-submit" class="btn-email">
                                    <i class="fas fa-arrow-circle-right"></i>
                                </button>
                                <input id="footer-newsletter-address" type="text" placeholder="E-mail">
                            </form>
                            <div id="subsResult"></div>
                        </div>

                    </div>

                </div>

            </div>
        </div>

        <div class="row  pt-50">
            <!-- Page Heading Start -->
            <div class="col-12 col-lg-auto mb-20">
                <div class="page-heading main">
                    <a href="{{ url('/community') }}">
                        <h3>@lang('lang.community')&nbsp;&nbsp;
                            <img style="width: 30px; height: 30px;" src="/public/web_assets/images/icons/arrow_forward_48px.svg" alt="">
                        </h3>
                    </a>
                </div>
            </div>
        </div><!-- Page Heading End -->
        <div class="col-sm-12 pl-0 pr-0 mt-20">
            <div class="row">
                <div id="owl-community" class="owl-carousel">
                    @foreach($community as $item)
                        <div class="col-sm-12">
                            <div class="com-home-item mb-30">
                                <div class="d-flex justify-content-center mt-30 mb-25">
                                    @if(!empty($item->image))
                                        <img src="/public/uploads/communities/{{ $item->id }}/{{ $item->image }}" alt="{{ $item->title }}">
                                    @else
                                        <img src="/public/web_assets/images/community/default.png" alt="no-image">
                                    @endif
                                </div>
                                <div class="d-flex justify-content-center">
                                    <p>
                                        <a href="{{ url('/community/' . $item->id) }}">
                                      {!!  mb_substr($item->title, 0, 20) !!}
                                        </a>
                                    </p>
                                </div>
                                <div class="d-flex justify-content-center mt-10">
                                    <span data-id="{{ count($item->paricipants) }}" id="c_part_{{ $item->id }}">@lang('lang.subscribed') {{ count($item->paricipants) }}</span>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button id="subcribe_community" data-id="{{ $item->id }}" class="button button-round subs_comm_{{ $item->id }} button-primary mt-30 mb-40">
                                       {{-- @if($isUserSubscribed == 1)
                                            <span>Вы подписанны</span>
                                        @else--}}
                                            <span>@lang('lang.subscribe')</span>
                                       {{-- @endif--}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        <!-- Modal No Authenticate user-->
        <div class="modal" id="modal-error-auth">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header brbn">
                        <h5 id="error-auth-content" class="modal-title ml-10">
                        </h5>

                    </div>

                </div>
            </div>
        </div>



        <!-- ######################################################################## -->

    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')

    <!-- OWl Carousel -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>

    <script src="/public/web_assets/js/pagination.js"></script>


@endsection
