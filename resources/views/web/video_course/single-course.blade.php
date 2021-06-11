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
        <div class="row  ">
            <!-- Page Heading Start -->
            <div class="col-12 col-lg-auto mb-20">
                <div class="page-heading">

                    <h3 data-id="{{ $videocourse->id }}" id="videocourse" class="mb-10">
                        {!!   $videocourse->title !!}
                    </h3>
                    <h5 class="mb-10">

                        @lang('lang.duration'){{ ':   ' . timeConvert($videocourse->duration) }}
                    </h5>
                    <p style="font-size: 16px;">
                        {!! $videocourse->description !!}
                    </p>

                </div>
            </div>
        </div><!-- Page Heading End -->


        <div class=" row mb-55">
            <div class="col-sm-12 pl-0 pr-0">
                @if(count($videocourse->galeries) > 0)
                    @foreach($videocourse->galeries as $item)

                        <div class=" col-md-4 col-lg-auto col-sm-12 mb-20 ">
                            <div class=" vl-ite ">
                                @if($item->image)
                                    <img src="/public/uploads/videocourse/{{$videocourse->id . '/' . $item->id . '/' . $item->image }}">
                                @else
                                    <img src="/public/web_assets/images/default-v-course.jpg">
                                @endif
                                <i data-id="{{ $item->id }}" id="videcourse_play_btn" data-toggle="modal" {{--data-target="#videcourse_player_modal"--}} data-whatever=""
                                   class="ply far fa-play-circle"></i>
                                <div class="content pl-20 pt-10">
                                <p>
                                    {{ mb_substr($item->title, 0, 75) }}
                                </p>
                                <span>@lang('lang.duration'){{ ':   ' . timeConvert($item->duration_video) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>




        <!-- Modal -->
        <div class="modal " id="videcourse_player_modal" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <button id="close_videocourse_player" type="button" class="close  p-0 m-btn-close " data-dismiss="modal" >
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <div class="modal-body p-0  pt-0">
                        <div class="box-body">
                            <video  preload="none"  id="videcourse_player" poster="" class="plyr-video" playsinline
                                   controls>
                                {{--<source src="" type="video/mp4"  />--}}
                            </video>
                        </div>
                    </div>
                </div>
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
