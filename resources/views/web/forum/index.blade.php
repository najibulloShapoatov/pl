@extends('layouts.main')

@section('title')
    @lang('lang.title')
@endsection
@section('styles')
    <!-- Custom Style CSS Only For Demo Purpose -->
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/style-primary.css">
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/custom.css">
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
            <div class="col-md-9">
                <div class="d-flex forum-header">
                    <span class="col-md-4 col-xs-4 col-sm-5" ><i style="font-size: 30px;" class="fas fa-users"></i>&nbsp;&nbsp;@lang('lang.forum')</span>
                    <div class="header-search forum-search col-md-8 col-sm-7 col-xs-8">
                        <div class="header-search-for forum-search-form">
                            <form >
                                <input id="search_forum_text" type="text" placeholder="@lang('lang.search_topics')">
                                <button id="search_forum_btn" class="category">
                                    <span>
                                        <i class="zmdi zmdi-search"></i>
                                    </span>
                                </button>
                            </form>

                        </div>

                    </div>
                </div>
                <div id="forum_main_list">
                    @if(count($forums) > 0)
                        <div class="infinite-scroll">
                        @foreach($forums as $item)
                        <div class="row f-item f-main-item">
                            <div class="col-lg-12 col-md-12 col-12 ">
                                <div class="box  forum-item ">
                                    <div class="box-body">
                                        <div class="media">
                                            <div data-id="{{$item->user->id}}" id="view_user_data" >
                                            @if($item->user->image)
                                                <img src="/public/uploads/users/{{ str_replace('@tspu.tj', '', $item->user->email)  }}/avatar/{{ $item->user->image }}" class="mr-3" alt="">
                                            @else
                                                <img src="/public/web_assets/images/users/default-avatar.png" class="mr-3" alt="">
                                            @endif
                                            </div>
                                            <div class="media-body pl-10">
                                                <h4 class="mt-0">

                                                    <a href="{{ url('/forum/' . $item->id ) }}">
                                                        {{ mb_substr($item->title, 0, 100) }}
                                                    </a>
                                                </h4>
                                                <div class=" pt-10 notification d-flex  justify-content-between align-items-center">
                                                    <span>{{ $item->category->title }}</span>
                                                    <div>
                                                        <span class="pr-10"><i class="ti-eye "></i>&nbsp;&nbsp;{{ $item->viewed }}</span>
                                                        <span class="pr-20"><i class="ti-time "></i>&nbsp;&nbsp;{{ date('Y.m.d', strtotime($item->created_at)) }}</span>
                                                    </div>

                                                </div>
                                            </div>
                                            <a href="{{ url('/forum/' . $item->id ) }}#forum_answers" class="media-notification d-flex justify-content-center">
                                                <span>{{ count($item->answers) }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        {{ $forums->links() }}
                        </div>
                    @endif
                </div>







            </div>
            <div class="col-md-3 ">
                <div class="second-column">

                    <div class="add_forum d-flex justify-content-between ">
                        <div class="col-8 pl-0">
                            <button data-toggle="modal" data-target="#exampleModal5"
                                    data-whatever=""
                                    class="button add button-square button-success d-flex justify-content-around align-items-center">
                                <span>@lang('lang.create_topic')</span><span>+</span>
                            </button>
                        </div>
                        <div class="col-4 pr-0">
                            <div class="forum-faq-link">
                            <a class="faq-link" href="/faq#Форум">
                                <img src="/public/web_assets/images/icons/faq-white.svg" alt="">
                            </a>
                            </div>
                        </div>

                    </div>


                    @if(Auth::check() && Auth::user()->role_id == 1)
                        <div class="add_forum_settings mt-30">
                            <a href="{{ url('/forum-manage') }}" class="button add button-square d-flex justify-content-around align-items-center">
                                <span>@lang('lang.manage')<span class=" ml-10 ti-settings"></span></span>

                            </a>

                        </div>
                    @endif

                {{--                    Modals --}}
                    @if(Auth::check())
                        <!-- Modal Authenticate user -->
                            <div class="modal fade" id="exampleModal5">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header  brbn">
                                            <h5 class="modal-title">@lang('lang.create')</h5>
                                            <button id="close_videocourse_player" type="button" class="close  p-0 m-btn-close " data-dismiss="modal" >
                                                <span aria-hidden="true">&times;</span>
                                            </button>

                                        </div>
                                        <div class="modal-body comm-form add-forum pt-0">
                                            <form>
                                                <div class="form-group">
                                                    <input autocomplete="off" id="new_forum_title" type="text" class="form-control mb-10 " id="tema" placeholder="@lang('lang.topic')">
                                                </div>
                                                <div class="form-group">
                                                    <select id="new_forum_category" class="form-control mb-10">
                                                        <option>@lang('lang.select_a_category')</option>
                                                        @if($f_category)
                                                            @foreach($f_category as $item)
                                                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                                                            @endforeach
                                                        @endif

                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <textarea id="new_forum_descr" class="form-control h-200" id="message-text" placeholder="@lang('lang.description')"></textarea>
                                                </div>
                                                <button data-dismiss="modal"  id="new_forum_add" class="button button-success std mt-20 mb-20 fz-16 pl-25 pr-25 pt-5 pb-5 float-sm-right">@lang('lang.create')</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @else
                        <!-- Modal No Authenticate user-->
                        <div class="modal fade" id="exampleModal5">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header brbn">
                                        <h5 class="modal-title ml-10">
                                            @lang('lang.to_crete_topic_complete')
                                            <a style="color: #1968df; text-decoration: underline;" href="{{ url('/login') }}">
                                                @lang('lang.login')</a></h5>

                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif






                    {{--##################################--}}

                    <div class="forum-category bor">
                        <div class="title">@lang('lang.category')</div>
                        @if(count($f_category) > 0)
                        @foreach($f_category as $item)
                            <div class="item  d-flex justify-content-between align-items-center">
                                <span> <a href="{{ url('/forum/category/' . $item->id ) }}">{{ mb_substr($item->title, 0, 100) }}</a></span>
                                <span>{{ count($item->catqnt) }}</span>
                            </div>
                        @endforeach
                        @endif
                    </div>
                    <div class="my-active-tem bor">
                        <div class="title">@lang('lang.my_active_topic')</div>
                        @if(count($myforums) > 0)
                            @foreach($myforums as $item)
                        <div class="item d-flex justify-content-between">
                            <a href="{{ url('/forum/' . $item->id ) }}">{{ mb_substr($item->title, 0, 50) }}</a>
                            <span id="edit_modal_show" data-id="{{ $item->id }}"
                                data-toggle="modal" data-target="#editModalForum"
                            data-whatever="" >
                                <i class="zmdi zmdi-edit"></i>
                            </span>
                        </div>
                            @endforeach
                        @endif
                    </div>



                </div>


            </div>

            <div class="modal" id="editModalForum">
            </div>
        </div>



        <div class="modal " id="view_info_user_modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header brbn">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close  p-0 pull-right pr-20" data-dismiss="modal" {{--style="margin-left: 40%;"--}}>
                            <span class="ti-close"></span></button>
                    </div>
                    <div class="modal-body comm-form pt-0 pl-20 pr-20" >
                        <div id="view_user_info_form">
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')
    <script type="text/javascript">
        $('ul.pagination').hide();
        $(function() {
            $('.infinite-scroll').jscroll({
                autoTrigger: true,
                loadingHtml: '<img class="center-block" style="width: 70px" src="/public/web_assets/images/loading-a.gif" alt="Loading..." />', // MAKE SURE THAT YOU PUT THE CORRECT IMG PATH
                padding: 0,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.infinite-scroll',
                callback: function() {
                    $('ul.pagination').remove();
                }
            });
        });
    </script>
    <!-- OWl Carousel -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>
    <script src="/public/web_assets/js/jquery.jscroll.min.js"></script>

@endsection
