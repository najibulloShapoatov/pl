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
        <!-- ---------------------------------------------------------------------------------------------- -->
        <div class="row">
            <!-- Page Heading Start -->
            <div class=" col-md-12 col-sm-12 col-xs-12 col-12 col-lg-auto mb-20">
                <div class="course page-heading  d-flex">
                    <h3>@lang('lang.my_videocourses')</h3>
                    <span class="my-tests pt-1 pl-20">
                    <a href="{{ url('/add-course') }}">
                        <h5>@lang('lang.add')</h5>
                    </a>
                    </span>
                </div>
            </div>

        </div><!-- Page Headings End -->
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <table class=" my-course col-12 pl-0 pr-0">
                    <tbody>
                    @if(count($mycourse) > 0)
                        @foreach($mycourse as $item)
                    <tr class=" my-course-item">
                        <td width="50%">
                            <div class="my-course-item-title">
                                <a href="{{ url('/videocourse/' . $item->id) }}"> {!!   mb_substr($item->title, 0, 50) !!} </a>
                            </div>
                        </td>
                        <td>
                            <span class="float-left">
                                @lang('lang.duration'){{ ':   ' . timeConvert($item->duration) }}
                                </span>
                        </td>
                        <td>
                            <div class="content-my-course fl-right">
                                <a  href="{{ url('/edit-course/' . $item->id) }}"><i class="zmdi zmdi-edit"></i></a>
                                <a  href="{{ url('/videocourse/' . $item->id) }}"><i class="zmdi zmdi-eye zmdi-hc-fw"></i></a>
                                <a href="{{ url('/delete-course/' . $item->id) }}"><i class="ti-close"></i></a>
                            </div>
                        </td>
                    </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>


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
