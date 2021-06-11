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
@php
    function timeConvert($strtime){
        $time=(int)$strtime;
        $hours = floor($time  / 3600);
        $minutes = floor(($time / 60) % 60);
        $seconds = $time % 60;
       return (($hours<10)? '0'.$hours: $hours) . ':' . (($minutes<10)? '0'.$minutes: $minutes)  . ':' . (($seconds<10)? '0'.$seconds: $seconds);
    }
@endphp

@section('content')
    @include('inc.header')
    @include('inc.side_bar')
    <!-- Content Body Start -->
    <div class="content-body">
        <div class="col-xs-12 col-sm-12 col-md-12 pl-0 pr-0">
            <!-- Page Heading Start -->
            <div class="col-12 col-lg-auto mb-20  pl-0 ">
                <div class="page-heading d-flex">
                    <div class="col-11 pl-0 d-flex">
                    <h3>@lang('lang.videocourses')</h3>
                    @if(Auth::check() &&( Auth::user()->role->id == 2 || Auth::user()->role->id == 1))
                        <span class="my-tests pt-1 pl-20">
                            <a class="ml-20" href="{{ url('/my-course') }}">
                                <h5>@lang('lang.my_videocourses')</h5>
                            </a>
                        </span>
                    @endif
                    @if(Auth::check() && Auth::user()->role->id == 1)
                        <span class="my-tests pt-1 pl-20">
                            <a class="ml-20" href="{{ url('/manage-course') }}">
                                <h5>@lang('lang.manage')</h5>
                            </a>
                        </span>
                    @endif
                    </div>
                    <div class="col-1 pr-0">
                        <div class="d-flex align-items-center pull-right">
                            <a class="faq-link" href="/faq#Видеокурсы">
                                <img src="/public/web_assets/images/icons/faq-black.svg" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- Page Heading End -->
            <form class="d-flex">
            <div class="col-4 mb-15 pl-0">
                <select id="videocourse_category" class="form-control std">
                    <option>@lang('lang.select_a_category')</option>
                    @if(count($categories)>0)
                        @foreach($categories as $item)
                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
                <div class="col-4 mb-15 ml-40">
                    <button id="videocourse_category_btn" class="button button-primary button-outline lib-btn">
                        <span>@lang('lang.go_to')</span>
                    </button>
                </div>

            </form>
        </div>



    @php
        $i=1;
    @endphp
    @if(count($categories)>0 )
        @foreach($categories as $category)
        @if(count($category->courses) > 0)
            @php
            if(count($category->courses) == 1 && $category->courses[0]->is_active == 0){
                continue;
            }
            @endphp
        <!--With controls Start-->
        <div class="col-lg-12 col-sm-12 col-xs-12 col-12 mb-30 pl-0 pr-0">
            <div class="box bg-transparent">
                <div class="box-head library">
                    <h3 class="title">
                        <a href="{{ url('/course-cat/' . $category->id) }}">
                            <span>{{ $category->title }}</span>
                        </a>
                    </h3>
                </div>
                <div class="box-body">
                    <div id="carouselExampleControls{{$i}}" class="carousel slide v-course" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="row">
                                @if(count($category->courses)>0)
                                    @php
                                        $k=0;
                                        $l=0;
                                    @endphp
                                    @foreach($category->courses as $course)
                                    @if($course->is_active == 1)
                                    @if($k==0) <div class="carousel-item {{ ($l==0)? 'active' : '' }}"> @endif
                                                <div class = "col-md-4 col-lg-auto col-sm-12 mb-20 ">
                                                    <div class=" vl-ite pb-10">
                                                        @if($course->image)
                                                            <img src="/public/uploads/videocourse/{{ $course->id . '/' . $course->image }}">
                                                        @else
                                                            <img src="/public/web_assets/images/default-v-course.jpg">
                                                        @endif
                                                        <a href="{{ url('/videocourse/' . $course->id) }}" class="content pl-20 pt-10">
                                                            <p>
                                                               {!!  mb_substr($course->title, 0, 70 )!!}
                                                            </p>
                                                            <span >@lang('lang.duration_videocourse'){{ ':   ' . timeConvert($course->duration)  }} </span>
                                                        </a>
                                                    </div>
                                                </div>
                                        @php
                                        $k +=1;
                                        $l +=1;
                                        @endphp
                                    @if($k==3)
                                    </div>
                                        @php
                                            $k=0;
                                        @endphp
                                    @endif
                                        @if(count($category->courses)>3)
                                            @if($k==2 && $l==count($category->courses))
                                                <div class = "col-md-4 col-lg-auto col-sm-12 mb-20 ">
                                                    <div class=" vl-ite pb-10">
                                                        @if($category->courses[0]->image)
                                                            <img src="/public/uploads/videocourse/{{ $category->courses[0]->id . '/' . $category->courses[0]->image }}">
                                                        @else
                                                            <img src="/public/web_assets/images/default-v-course.jpg">
                                                        @endif
                                                        <a href="{{ url('/videocourse/' . $category->courses[0]->id) }}" class="content pl-20 pt-10">
                                                            <p>
                                                                {!!  mb_substr($category->courses[0]->title, 0, 70 )!!}
                                                            </p>
                                                            <span >@lang('lang.duration'){{ ':   ' . timeConvert($category->courses[0]->duration) . ' час' }} </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @if($k==1 && $l==count($category->courses))
                                                <div class = "col-md-4 col-lg-auto col-sm-12 mb-20 ">
                                                    <div class=" vl-ite pb-10">
                                                        @if($category->courses[0]->image)
                                                            <img src="/public/uploads/videocourse/{{ $category->courses[0]->id . '/' . $category->courses[0]->image }}">
                                                        @else
                                                            <img src="/public/web_assets/images/default-v-course.jpg">
                                                        @endif
                                                        <a href="{{ url('/videocourse/' . $category->courses[0]->id) }}" class="content pl-20 pt-10">
                                                            <p>
                                                                {!! mb_substr($category->courses[0]->title, 0, 70 )!!}
                                                            </p>
                                                            <span >@lang('lang.duration'){{ ':   ' . timeConvert($category->courses[0]->duration) . ' ' }}@lang('lang.hours') </span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class = "col-md-4 col-lg-auto col-sm-12 mb-20 ">
                                                    <div class=" vl-ite pb-10">
                                                        @if($category->courses[1]->image)
                                                            <img src="/public/uploads/videocourse/{{ $category->courses[1]->id . '/' . $category->courses[1]->image }}">
                                                        @else
                                                            <img src="/public/web_assets/images/default-v-course.jpg">
                                                        @endif
                                                        <a href="{{ url('/videocourse/' . $category->courses[1]->id) }}" class="content pl-20 pt-10">
                                                            <p>
                                                                {!! mb_substr($category->courses[1]->title, 0, 70 )!!}
                                                            </p>
                                                            <span >@lang('lang.duration'){{ ':   ' . timeConvert($category->courses[1]->duration) . ' ' }} @lang('lang.hours')</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @endif
                                    @endif
                                    @endforeach
                                    @php
                                        $l=0;
                                    @endphp

                                @endif
                            </div>
                        </div>
                        @if(count($category->courses) > 3)
                            <a class="carousel-control-prev" href="#carouselExampleControls{{$i}}" data-slide="prev">
                                <div class="pre-slide"><span class="zmdi zmdi-chevron-left zmdi-hc-fw"></span></div>
                                <span class="sr-only"><-</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls{{$i}}" data-slide="next">
                                <div class="nex-slide"><span class="zmdi zmdi-chevron-right zmdi-hc-fw"></span></div>
                                <span class="sr-only">-></span>
                            </a>
                        @endif
                    </div>


                </div>
            </div>
        </div>
        @php
            $i +=1;
        @endphp
        <!--With controls End-->
        @endif
        @endforeach
    @endif

    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')
    <!-- Plugins & Activation JS For Only This Page -->
    <script src="/public/web_assets/js/plugins/plyr/plyr.min.js"></script>
    <script src="/public/web_assets/js/plugins/plyr/plyr.active.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

@endsection
