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
        <!-- -------------------------------------------------------------------------------------------------- -->
        <div class="col-xs-12 col-sm-12 col-md-12 pl-0 pr-0 mb-20">
            <!-- Page Heading Start -->
            <div class="col-12 col-lg-auto mb-20  pl-0 ">
                <div class="page-heading d-flex">
                    <h3>{{ $categorySelected->title }}</h3>
                    @if(Auth::check() &&( Auth::user()->role->id == 2 || Auth::user()->role->id == 1))
                        <span class="my-tests pt-1 pl-20">
                        <a class="ml-20" href="{{ url('/my-course') }}">
                            <h5>@lang('lang.my_videocourses')</h5>
                        </a>
                    </span>
                    @endif
                </div>
            </div><!-- Page Heading End -->
            <form class="d-flex">
                <div class="col-4 mb-15 pl-0">
                    <select id="videocourse_category" class="form-control std">
                        <option>@lang('lang.select_a_category')</option>
                        @if(count($categories)>0)
                            @foreach($categories as $item)
                                @if( $item->id == $categorySelected->id)
                                <option selected value="{{ $item->id }}">{{ $item->title }}</option>
                                @else
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endif
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


        <div class=" row mb-55">
            <div class="col-sm-12 pl-0 pr-0">

                @if(count($categorySelected->courses) > 0)
                    @foreach($categorySelected->courses as $item)
                        @if($item->is_active == 1)
                        <div class=" col-md-4 col-lg-auto col-sm-12 mb-20 ">
                        <div class=" vl-ite pb-20">
                            @if($item->image)
                                <img src="/public/uploads/videocourse/{{ $item->id . '/' . $item->image }}">
                            @else
                                <img src="/public/web_assets/images/default-v-course.jpg">
                            @endif
                            <a href="{{ url('/videocourse/' . $item->id) }}"  class="content pl-20 pt-10 pr-15">
                                <p class="mb-10">
                                    {!!  mb_substr($item->title, 0, 70 ) !!}
                                </p>
                                <span>@lang('lang.duration'){{ ':   ' . timeConvert($item->duration)  }} </span>
                            </a>
                        </div>

                    </div>
                        @endif
                    @endforeach
                @endif
            </div>

        </div>
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
