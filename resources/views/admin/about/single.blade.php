@extends('layouts.main')

@section('title')
    ТСПУ им. С. Айни
@endsection
@section('styles')
    <!-- Custom Style CSS Only For Demo Purpose -->
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/style-primary.css">
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/custom.css">
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/fortest2.css">
@endsection


<!-- ################################################################################################### -->


@section('content')
    @include('inc.header')
    @include('inc.side_bar')
    <!-- Content Body Start -->
    <div class="content-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-auto mb-20 d-flex ">
                <div class="page-heading">
                    <h3>Обрашение</h3>
                </div>
            </div>

            <div class="col-sm-12 mt-25 pl-0 pr-0 " style="width: 100%">
                <div class="col-12 d-flex">
                    <h5>Кому:</h5>
                    <h6 class="ml-20" style="padding-top: 3px;">
                        {{ $data->to_whom }}
                    </h6>
                </div>
                <div class="col-12 d-flex">
                    <h5>Тема:</h5>
                    <h6 class="ml-20" style="padding-top: 3px;">
                        {{ $data->topic }}
                    </h6>
                </div>
                <div class="col-12 ">
                    <h5>Текст:</h5>
                    <textarea readonly rows="15"  style="padding-top: 3px; padding-left: 10px; width: 100%">{!!   $data->text !!}</textarea>


                </div>
            </div>


                <div class="col-12 mt-20 mb-15">
                    <div class="fl-right d-flex align-items-center">
                        <button data-id="{{ $data->id }}"  id="delete_items_about_single" class="button button-danger">Удалить</button>
                    </div>
                </div>
        </div>
    </div><!-- Content Body End -->

    @include('inc.footer')
@endsection


@section('scripts')

    <script src="/public/web_assets/js/plugins/dropify/dropify.min.js"></script>
    <script src="/public/web_assets/js/plugins/dropify/dropify.active.js"></script>
    <script src="/public/web_assets/js/customize_dropify.js"></script>
    <script src="/public/web_assets/js/plugins/nice-select/jquery.nice-select.min.js"></script>
    <script src="/public/web_assets/js/plugins/nice-select/niceSelect.active.js"></script>



    <!-- Plugins & Activation JS For Only This Page -->
    <script src="/public/web_assets/js/plugins/summernote/summernote-bs4.min.js"></script>
    <script src="/public/web_assets/js/plugins/summernote/summernote.active.js"></script>


    {{-- FILE MANAGER--}}
    <script src="//cdn.ckeditor.com/4.9.2/full/ckeditor.js"></script>
    <script>
        var options = {
            filebrowserImageBrowseUrl: '/admin/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/admin/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
            filebrowserBrowseUrl: '/admin/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/admin/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}',
            height: 300,
            language: 'ru'
        };
        CKEDITOR.replace('my-editor', options);
    </script>



@endsection
