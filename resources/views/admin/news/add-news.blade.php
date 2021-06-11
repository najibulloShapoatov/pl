@extends('layouts.main')

@section('title')
    @lang('lang.title')

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
                    <h3>@lang('lang.add_news')</h3>
                </div>
                <span class="single-elon-header pt-1 pl-20">
                    <a href="{{ url('/news-manage') }}">
                        <span>@lang('lang.manage')</span>
                    </a>
                </span>

            </div>
            <div class="col-sm-12 mt-25">
                <div class="col-10 ">
                    <div class="row mbn-15">
                        <div class="col-12">
                            <div class="error hide"></div>
                        </div>
                        <div class="col-12 d-flex align-items-center mb-15 pl-0 pr-0">
                            <div class="col-sm-9 pl-0">
                                <input id="edit_news_title" type="text" class="form-control" value="" placeholder="@lang('lang.header')">
                            </div>
                        </div>
                        <div class="col-12 d-flex align-items-center mb-15 pl-0 pr-0">
                            <div class="col-sm-6 pl-0">
                                <input
                                    type="file"
                                    class="dropify-elon-img"
                                    id="update-file-news-img"
                                    data-default-file=""
                                    data-allowed-file-extensions="jpeg jpg png "
                                    data-max-file-size="5M"/>
                            </div>
                        </div>

                        <div class="col-12 d-flex align-items-center mb-15 pl-0 pr-0">
                            <div class="col-sm-9 pl-0">
                                <textarea maxlength="250"  id="anonce_text" class="form-control" placeholder="@lang('lang.annouce_text')" rows="5" ></textarea>
                            </div>
                        </div>

                        <div class="col-12 d-flex align-items-center mb-15 pl-0 pr-0">
                            <div class="col-sm-9 pl-0">
                                <textarea name="description" id="my-editor" class="form-control description_news" placeholder="@lang('lang.description')" rows="10" ></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-20 mb-15">
                    <div class="fl-right d-flex align-items-center">
                        <button  id="create_news_btn" class="button button-success">@lang('lang.add')</button>
                    </div>
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
