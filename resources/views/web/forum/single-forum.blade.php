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
                <div class="d-flex forum-header mb-10">
                    <span class="col-md-4 col-xs-4 col-sm-5" ><i style="font-size: 30px;" class="fas fa-users"></i>&nbsp;&nbsp;@lang('lang.forum')</span>
                    <div class="header-search forum-search col-md-8 col-sm-7 col-xs-8">
                        <div class="header-search-form forum-search-form">
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
                    <div id="forum_single" data-id="{{ $forumData->id }}" class="row f-item ">
                        <div class="col-lg-12 col-md-12 col-12 mt-20">
                            <div class="box forum-item main">
                                <div class="box-body">
                                    <div class="media">
                                        <div  data-id="{{$forumData->user->id}}" id="view_user_data" >
                                        @if($forumData->user->image )
                                            <img src="/public/uploads/users/{{ str_replace('@tspu.tj', '', $forumData->user->email) }}/avatar/{{ $forumData->user->image }}" class="mr-3" alt="">
                                        @else
                                            <img src="/public/web_assets/images/users/default-avatar.png" class="mr-3" alt="">
                                        @endif
                                        </div>
                                        <div class="media-body pl-10">
                                            <h4 class="mt-0">
                                                {{ $forumData->title }}
                                            </h4>
                                            <p>
                                                {{ $forumData->text }}
                                            </p>
                                        </div>

                                    </div>
                                    <div class="f-notification">
                                        <div class=" pt-20 pb-10 notification ">

                                            <span id="forum_like" class="green pr-20 ">
                                                @if(Auth::check())
                                                    <i class="far fa-thumbs-up pr-10"></i>
                                                    {{ count($forumData->likes) }}
                                                @endif
                                            </span>

                                            <span><i class="far fa-clock"></i>  {{ date('d.m.Y', strtotime($forumData->created_at)) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="forum_answers" class="pt-40">
                        @if(count($f_answers) > 0)
                            @foreach($f_answers as $item)
                                <div class="row f-item ">
                                    <div class="col-lg-12 col-md-12 col-12 mt-20">
                                        <div class="box forum-item">
                                            @if($item->parent_id != 0)
                                                @php
                                                $prt=[];
                                                foreach($f_answers as $ans){
                                                    if($item->parent_id == $ans->id){
                                                        $prt = $ans;
                                                    }
                                                }
                                                @endphp

                                                <div class="box-head otv-forum-otv ">
                                                    <div class="d-flex align-items-center">
                                                        <div data-id="{{$prt->user->id}}" id="view_user_data">
                                                        @if($prt->user->image)
                                                            <img width="46px" height="46px" src="/public/uploads/users/{{ str_replace('@tspu.tj', '', $prt->user->email)  }}/avatar/{{ $prt->user->image }}" class="mr-3" alt="">
                                                        @else
                                                            <img width="46px" height="46px" src="/public/web_assets/images/users/default-avatar.png" class="mr-3" alt="">
                                                        @endif
                                                        </div>
                                                        <p>{{ mb_substr($prt->text, 0, 200) }}</p>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="box-body" id="answer_{{ $item->id }}">
                                                <div class="media">
                                                    <div  data-id="{{$item->user->id}}" id="view_user_data" >
                                                        @if($item->user->image)
                                                            <img src="/public/uploads/users/{{ str_replace('@tspu.tj', '', $item->user->email)  }}/avatar/{{ $item->user->image }}" class="mr-3" alt="">
                                                        @else
                                                            <img src="/public/web_assets/images/users/default-avatar.png" class="mr-3" alt="">
                                                        @endif
                                                    </div>
                                                    <div class="media-body pl-10 mb-20 ">
                                                        <input type="hidden" value="{!! $item->text !!}">
                                                        <p>
                                                          {!!  $item->text !!}
                                                        </p>
                                                    </div>

                                                </div>
                                                <div class="f-notification">
                                                    <div class=" pt-20 pb-10 notification d-flex  justify-content-between pr-20">
                                                        <span>
                                                            <i class="far fa-clock"></i> {{ date('Y.m.d', strtotime($item->created_at)) }}
                                                        </span>
                                                        <div class="d-flex pull-right">
                                                        @if(Auth::check())
                                                        <span id="forum_answer_like" data-id="{{ $item->id }}" class="green pr-20 forum_answer_{{ $item->id }}">
                                                            <i class="far fa-thumbs-up pr-10"></i> {{count($item->likes) }}
                                                        </span>
                                                            <span class="mr-20" data-id="{{ $item->id }}" id="reply_to_answer">
                                                                @lang('lang.reply')
                                                            </span>
                                                        @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>


                    @if(Auth::check())
                        <div id="create_answer" class="row f-item comment-add">
                            <div class="col-lg-12 col-md-12 col-12 mt-20">
                                <div  class="box forum-item  ">

                                    <div id="reply_head" class="box-head pl-0 d-none">
                                        <div class="d-flex align-items-center">
                                            <i style="font-size: 50px;" class="zmdi zmdi-mail-reply zmdi-hc-fw"></i>
                                            <img width="46px" height="46px" src="/public/web_assets/images/users/default-avatar.png" class="mr-3" alt="" style="border-radius: 50%">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <div class="media">
                                            @if(Auth::check() && Auth::user()->image)
                                                <img src="/public/uploads/users/{{ str_replace('@tspu.tj', '', \Illuminate\Support\Facades\Auth::user()->email) }}/avatar/{{ Auth::user()->image }}" class="mr-3" alt="">
                                            @else
                                                <img src="/public/web_assets/images/users/default-avatar.png" class="mr-3" alt="">
                                            @endif
                                                <div class="media-body pl-10">
                                                <div class="box-body">
                                                    <input type="hidden" id="parent_id_answer" value="0">
                                                    <textarea id="text_forum_answer" id="textareaClipboard" class="form-control" placeholder="@lang('lang.write_something')"></textarea>
                                                    <button id="add_forum_answer" class="button button-primary mb-0 mt-25 float-right">@lang('lang.publish')</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                               {{-- <div class="box forum-item">
                                    <div class="box-body">
                                        <div class="media">
                                            @if(Auth::check() && Auth::user()->image)
                                                <img src="/public/uploads/users/{{ str_replace('@tspu.tj', '', \Illuminate\Support\Facades\Auth::user()->email) }}/avatar/{{ Auth::user()->image }}" class="mr-3" alt="">
                                            @else
                                                <img src="/public/web_assets/images/users/default-avatar.png" class="mr-3" alt="">
                                            @endif
                                                <div class="media-body pl-10">
                                                <div class="box-body">
                                                    <textarea id="text_forum_answer" id="textareaClipboard" class="form-control" placeholder="Напишите что нибуд..."></textarea>
                                                    <button id="add_forum_answer" class="button button-primary mb-0 mt-25 float-right">Опубликовать</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>--}}
                            </div>
                        </div>
                    @endif

                </div>
            </div>
            <div class="col-md-3 ">
                <div class="second-column">

                    <div class="add_forum ">
                        <button data-toggle="modal" data-target="#exampleModal5"
                                data-whatever=""
                                class="button add button-square button-success d-flex justify-content-around align-items-center">
                            <span>@lang('lang.create_topic')</span><span>+</span>
                        </button>

                    </div>


                    @if(Auth::check() && Auth::user()->role_id == 1)
                        <div class="add_forum_settings mt-30">
                            <a href="{{ url('/forum-manage') }}" class="button add button-square d-flex justify-content-around align-items-center">
                                <span>@lang('lang.mange')<span class=" ml-10 ti-settings"></span></span>

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
                                           @lang('lang.to_create_topic_complete')
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
                        <div class="title"><a href="#">@lang('lang.my_active_topic')</a></div>
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

        </div>
    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')

    <!-- OWl Carousel -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>

@endsection
