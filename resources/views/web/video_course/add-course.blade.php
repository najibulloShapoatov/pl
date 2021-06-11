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
                <div class="page-heading">
                    <h3>@lang('lang.add_videocourse')</h3>
                </div>
            </div>

        </div><!-- Page Headings End -->

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-12 mb-20">

            <div class="row mbn-15">
                <div class="row">
                    <div class="col-12 mb-15">
                        <input id="editing_course_title" type="text" class="form-control" placeholder="@lang('lang.name')">
                    </div>

                    <div class="col-12 mb-15">
                        <select id="videocourse_category" class="form-control std">
                            <option>@lang('lang.select_a_category')</option>
                            @if(count($categories)>0)
                                @foreach($categories as $item)
                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-12 mb-15">
                        <input id="editing_course_duration" type="text" class="form-control" readonly placeholder="@lang('lang.duration')">
                    </div>

                    <div class="col-12 mb-15">
                        <div class="video-course-image col-7 pt-20" >
                            <input
                                type="file"
                                class="dropify-cover-course"
                                id="course_cover"
                                data-allowed-file-extensions="jpg jpeg png gif "
                                data-max-file-size="2M"/>
                        </div>
                    </div>

                    <div class="col-12 mb-15">
                        <textarea id="editing_course_descr" class="form-control" placeholder="@lang('lang.description')"></textarea>
                    </div>
                    <div class="col-12 mb-15">
                        <button id="save_and_add_video" class="button button-success fl-right" style="text-transform: none">@lang('lang.save_and_add_video')</button>
                    </div>

                    <div id="add_video_section" class="d-none">
                        <div class="col-12 pt-15 mb-15 d-flex">
                        <div class=" col-4 pl-0  button-wrapper">
                            <div class="">
                                <input
                                    type="file"
                                    class="dropify-comm-video"
                                    id="input-file-corse_video"
                                    data-allowed-file-extensions="mp4 mpg avi wmv flv "
                                    data-max-file-size="512M"/>
                            </div>
                        </div>
                        <audio data-id="" class="d-none" id="audio"></audio>
                        <div class="col-8 pt-10 pl-0 pr-0">
                            <input id="video_title" type="text" class="form-control" placeholder="@lang('lang.name_video')">
                            <div class="d-flex">
                                <div class="video-course-image col-7 pt-20" >
                                    <input
                                        type="file"
                                        class="dropify-course-image"
                                        id="input-file-course-img"
                                        data-allowed-file-extensions="jpg jpeg png gif "
                                        data-max-file-size="2M"/>
                                </div>
                                <input type="hidden" id="imgthumbnail">
                                <div class="col-5 pr-0">
                                    <button data-id="" id="add_new_video_on_course" class="button button-primary button-outline float-sm-right mt-15">@lang('lang.upload')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div data-id="" id="course_editing_page" class="col-sm-12 col-xs-12-col-md-12 ">
            <div class="row mb-15 mt-20">
                <div class="row">

                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <button id="save_edited_course" class="button button-success s-btn d-none fl-right">@lang('lang.finaly')</button>
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

    <script src="/public/web_assets/js/plugins/dropify/dropify.min.js"></script>
    <script src="/public/web_assets/js/plugins/dropify/dropify.active.js"></script>
    <script src="/public/web_assets/js/customize_dropify.js"></script>


    {{--duration video--}}
    <script>
        // Code to get duration of audio /video file before upload - from: http://coursesweb.net/

        //register canplaythrough event to #audio element to can get duration
        var f_duration =0;  //store duration
        document.getElementById('audio').addEventListener('canplaythrough', function(e){
            //add duration in the input field #f_du
            f_duration = Math.round(e.currentTarget.duration);
            /*document.getElementById('f_du').value = f_duration;*/
            // console.log(f_duration);
            document.getElementById('audio').setAttribute('data-id', f_duration);
            URL.revokeObjectURL(obUrl);
        });

        //when select a file, create an ObjectURL with the file and add it in the #audio element
        var obUrl;
        document.getElementById('input-file-corse_video').addEventListener('change', function(e){
            var file = e.currentTarget.files[0];
            //check file extension for audio/video type
            if(file.name.match(/\.(avi|mp3|mp4|mpeg|ogg)$/i)){
                obUrl = URL.createObjectURL(file);
                document.getElementById('audio').setAttribute('src', obUrl);
            }
        });
    </script>

    {{--------------------}}
    {{--thubnails get--}}
    <script>
        document.querySelector("#input-file-corse_video").addEventListener('change', function(event) {
            var file = event.target.files[0];
            var fileReader = new FileReader();
            if (file.type.match('image')) {
                fileReader.onload = function() {
                    var img = document.createElement('img');
                    img.src = fileReader.result;
                    document.getElementsByTagName('div')[0].appendChild(img);
                };
                fileReader.readAsDataURL(file);
            } else {
                fileReader.onload = function() {
                    var blob = new Blob([fileReader.result], {type: file.type});
                    var url = URL.createObjectURL(blob);
                    var video = document.createElement('video');
                    var timeupdate = function() {
                        if (snapImage()) {
                            video.removeEventListener('timeupdate', timeupdate);
                            video.pause();
                        }
                    };
                    video.addEventListener('loadeddata', function() {
                        if (snapImage()) {
                            video.removeEventListener('timeupdate', timeupdate);
                        }
                    });
                    var snapImage = function() {
                        var canvas = document.createElement('canvas');
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;
                        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                        var image = canvas.toDataURL();
                        var success = image.length > 100000;
                        if (success) {
                            var img = document.createElement('img');
                            img.src = image;

                            document.querySelector('#imgthumbnail').value=image;
                            document.getElementsByTagName('div')[0].appendChild(img);
                            URL.revokeObjectURL(url);
                        }
                        return success;
                    };
                    video.addEventListener('timeupdate', timeupdate);
                    video.preload = 'metadata';
                    video.src = url;
                    // Load video in Safari / IE11
                    video.muted = true;
                    video.playsInline = true;
                    video.play();
                };
                fileReader.readAsArrayBuffer(file);

            }
        });
    </script>

@endsection
