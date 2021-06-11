@extends('layouts.main')

@section('title')
    @lang('lang.title')
@endsection
@section('styles')
    <!-- Custom Style CSS Only For Demo Purpose -->
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/style-primary.css">
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/custom.css">
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/community.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@endsection


<!-- ################################################################################################### -->


@section('content')
    @include('inc.header')
    @include('inc.side_bar')
    <!-- Content Body Start -->
    <div class="content-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="comm-title b-white d-flex justify-content-between align-items-center pr-20">
                    <h3>@lang('lang.community')</h3>
                    @if(Auth::check() && Auth::user()->role_id == 1)
                        <div class="d-flex">
                            <button class="button add-comm " data-toggle="modal" data-target="#community_new_modal"
                                    data-whatever="" >
                                <i class="ti-plus"></i><span>@lang('lang.create_community')</span>
                            </button>
                            <a href="{{ url('/community-manage') }}" class="button  ml-20 add-comm " >
                                <span class="ti-settings"></span>
                                <span>@lang('lang.manage')</span>
                            </a>

                        </div>
                    @endif
                {{--                    Modals --}}
                @if(Auth::check())
                    <!-- Modal Authenticate user -->
                        <!-- Modal -->
                        <div class="modal fade" id="community_new_modal">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header brbn">
                                        <h5 class="modal-title">@lang('lang.create_community')</h5>
                                        <button type="button" class="close  p-0 " data-dismiss="modal" style="margin-left: 40%;">
                                            <span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body comm-form pt-0" >
                                        <form>
                                            <div class="form-group">
                                                <input type="text" class="form-control mb-10 single-adm-comm-name" id="comm_new_name" placeholder="@lang('lang.enter_community_name')">
                                            </div>
                                            <div class="form-group">
                                                <!--Live Search-->
                                                <div class="col-12 mb-10 pl-0 pr-0">
                                                    <h5 class="sub-title">@lang('lang.moderator')</h5>
                                                    <select id="moderator_community" class="form-control bSelect" data-live-search="true">
                                                        <option value="1" selected>Админстратор</option>
                                                        @if(count($usrs) > 0)
                                                            @foreach($usrs as $u)
                                                            <option value="{{ $u->id }}">{!! $u->name !!}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <!--Live Search-->
                                            </div>
                                            <div class="form-group d-flex mb-20">
                                                <form  enctype="multipart/form-data" id="upload_image_form" action="javascript:void(0)">
                                                    <div class="row">
                                                        <div class="col-sm-6 mb-2">
                                                            <img id="image_preview_container" src="/public/no-image.png" alt="preview image" style="max-height: 150px;">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group mt-20">
                                                                <input type="file" name="image" placeholder="" id="new_comm_image" style="width: 100%">
                                                            </div>

                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="form-group">
                                                <textarea id="comm_new_descr" class="form-control h-200 single-adm-comm-text" id="message-text" placeholder="@lang('lang.description')"></textarea>
                                            </div>
                                            <div class="form-group d-flex justify-content-between">
                                                <button id="comm_add" class="button button-primary std mt-20 mb-20 fz-15 fw-500 pl-25 pr-25 pt-5 pb-5">
                                                    @lang('lang.create')
                                                </button>

                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                @else
                    <!-- Modal No Authenticate user-->
                        <div class="modal fade" id="community_new_modal">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header brbn">
                                        <h5 class="modal-title ml-10">
                                            @lang('lang.to_create_community_complete')
                                            <a style="color: #1968df; text-decoration: underline;" href="{{ url('/login') }}">
                                                @lang('lang.login')</a></h5>

                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif

                </div>

                <div id="community_items">
                    @if(count($communities))
                        @foreach($communities as $item)
                            <div class="post-item b-white mt-10">
                                <div class="post-header d-flex">
                                    @if($item->image)
                                        <img src="/public/uploads/communities/{{ $item->id . '/' . $item->image }} " alt="">
                                    @else
                                        <img src="/public/no-image.png" alt="">
                                    @endif
                                    <div class="p-header-content com">
                                        <div class="title">
                                            <a href="{{ url('/community/' . $item->id) }}">{{ $item->title }}</a>
                                        </div>
                                        <div class="time">
                                            {{ count($item->paricipants) }} @lang('lang.participants')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>




            </div>
{{--            <div class="col-md-3">--}}
{{--            </div>--}}
        </div>
    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')

    <!-- OWl Carousel -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>

    <!-- Plugins & Activation JS For Only This Page -->
  {{--  <script src="assets/js/plugins/select2/select2.full.min.js"></script>
    <script src="assets/js/plugins/select2/select2.active.js"></script>
    <script src="assets/js/plugins/nice-select/jquery.nice-select.min.js"></script>
    <script src="assets/js/plugins/nice-select/niceSelect.active.js"></script>--}}
    <script src="/public/web_assets/js/plugins/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="/public/web_assets/js/plugins/bootstrap-select/bootstrapSelect.active.js"></script>

@endsection
