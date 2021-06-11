@extends('layouts.main')

@section('title')
    ТСПУ им. С. Айни
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
        <div class="col-md-12 col-12 ">
            <div class="box vsp">
                <div class="box-body">
                    <video poster="/public/web_assets/images/bg/video-1-poster.jpg" class="plyr-video"
                           playsinline controls>
                        <source src="/public/web_assets/media/video-1-576p.mp4" type="video/mp4"
                                data-res="576" />
                        <source src="/public/web_assets/media/video-1-720p.mp4" type="video/mp4"
                                data-res="720" />
                        <source src="/public/web_assets/media/video-1-1080p.mp4" type="video/mp4"
                                data-res="1080" />
                    </video>
                </div>
                <h3>Павел Гуров Лексии Вебинар (Vkontakte Twitter Facebook)</h3>
                <span class="viewed">620 просмотров </span>
                <span class="date">15 окт 2019</span>
            </div>
        </div>
        <p class="t-black">
            Программа лекции:<br>
            1. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ducimus, corporis?<br>
            1. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ducimus, corporis?<br>
            1. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ducimus, corporis?<br>
            1. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ducimus, corporis?<br>
            1. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ducimus, corporis?<br>
            1. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ducimus, corporis?<br>
            1. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ducimus, corporis?<br>
            1. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ducimus, corporis?<br>
            1. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ducimus, corporis?<br>
            1. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ducimus, corporis?<br>
            1. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ducimus, corporis?<br>
            1. Lorem, ipsum dolor sit ametconsectetur adipisicing elit. Ducimus, corporis?<br>

        </p>


    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')
    <!-- Plugins & Activation JS For Only This Page -->
    <script src="/public/web_assets/js/plugins/plyr/plyr.min.js"></script>
    <script src="/public/web_assets/js/plugins/plyr/plyr.active.js"></script>
    <!-- OWl Carousel -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>

    @endsection
