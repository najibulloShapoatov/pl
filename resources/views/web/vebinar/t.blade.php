@extends('layouts.main')

@section('title')
    ТСПУ им. С. Айни
@endsection
@section('styles')
    <base target="_blank">
    <!-- Custom Style CSS Only For Demo Purpose -->
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/style-primary.css">
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/custom.css">
@endsection
@section('content')
    @include('inc.header')
    @include('inc.side_bar')
    <!-- Content Body Start -->
    <div class="content-body">

        <div id="container">

            @if(Auth::check() && Auth::user()->id == 10)
            <video id="video1" playsinline autoplay muted></video>
            @endif
                <video id="video2" playsinline autoplay></video>

                {{--            <video id="video3" playsinline autoplay></video>--}}

            @if(Auth::check() && Auth::user()->id == 10)
            <div>
                <button id="startButton">Start</button>
                <button id="callButton">Call</button>
                <button id="hangupButton">Hang Up</button>
            </div>
            @endif

        </div>
    </div>

    @include('inc.footer')
@endsection

@section('scripts')
            <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
            <script src="/public/web_assets/js/vebinar.js" async></script>

@endsection
