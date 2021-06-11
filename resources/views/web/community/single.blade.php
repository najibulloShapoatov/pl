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
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/croppie.css">

    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">





@endsection


<!-- ################################################################################################### -->


@section('content')
    @include('inc.header')
    @include('inc.side_bar')
    <!-- Content Body Start -->
    <div class="content-body">
        <div class="row">
            <div class="col-md-9">
                <div class="comm-title b-white">
                    <h3>{!!  $communityData->title !!}</h3>
                    <br>
                    <p style="color: #666666">
                        {!! $communityData->description !!}
                    </p>
                    <input id="comm-id" type="hidden" value="{{ $communityData->id }}">
                </div>



{{--                <div class="comm-descr b-white">--}}
{{--                    <div class="c-descr-text">Описание:</div>--}}
{{--                    <p>--}}
{{--                        {{ $communityData->description }}--}}
{{--                    </p>--}}
{{--                </div>--}}
                @if( Auth::check() &&  $communityData->user_id == Auth::user()->id)

                    <div class="p-post d-flex b-white mt-10">
                       {{-- <input id="new_post_text" type="text" placeholder="Публикация">--}}

                        <div class="col-10 pl-0">
                            <div class="box-body">
                                <div class="quill">

                                </div>
                            </div>

                            <div id="upload_image_video" class="d-none">
                                <div id="" class="p-post d-none d-flex  b-white mt-10">
                                    <div class="col-12 elon_img mb-15   p-20">
                                        <form class="d-flex justify-content-center" action="" enctype="multipart/form-data">
                                            <div class=" mr-40">
                                                <input
                                                    type="file"
                                                    class="dropify-comm-video"
                                                    id="input-file-community-video"
                                                    data-allowed-file-extensions=" mp4 flv mpg m4p 3gpp vmw avi "
                                                    data-max-file-size="128M"/>
                                            </div>
                                            <div class="">
                                                <input
                                                    type="file"
                                                    class="dropify-comm-img"
                                                    id="input-file-community-img"
                                                    data-allowed-file-extensions="jpg jpeg png gif "
                                                    data-max-file-size="3M"/>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-2 pr-0 d-flex align-items-end">
                            <div class="bottom d-flex align-items-center">
                                <i id="post_add_image" class="ti-image mr-10  post-add-img"></i>
                                <i  id="post_add_image" class="ti-video-clapper mr-10 post-add-video"></i>
                                <button id="add_new_post" data-id="{{ $communityData->id }}"  class="submit button button-box mb-0 button-round button-primary comm-post-btn">
                                    <i class="zmdi zmdi-mail-send"></i>
                                </button>
                            </div>
                        </div>

                    </div>
{{--                    <div class="p-post b-white">--}}
{{--                        <div class="box-body">--}}
{{--                            <div class="quill">--}}

{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                @endif

                @if($isUserSubscribed == 1 ||(Auth::check() && Auth::user()->id == $communityData->user_id))

                    <div id="community_post_items">
                        @if(count($posts) >0)
                            <div class="infinite-scroll">
                            @foreach($posts as $item)
                                <div class="post-item b-white mt-10" id="post-{{ $item->id }}">
                                    <div class="post-header d-flex">
                                        @if($communityData->image)
                                            <img src="/public/uploads/communities/{{ $communityData->id . '/' . $communityData->image }} " alt="">
                                        @else
                                            <img src="/public/no-image.png" alt="">
                                        @endif
                                        <div class="p-header-content">
                                            <div class="title">{{ mb_substr($communityData->title, 0, 30) . '...' }}</div>
                                            <div class="time">{{ date('d.m.Y', strtotime($item->created_at)) }}</div>
                                        </div>
                                    </div>
                                    <div class="post-content">
                                        <div class="post-text">
                                            {!!  html_entity_decode($item->text) !!}
                                        </div>
                                        <div class="col-12 pl-0 pr-0 d-flex" style="max-height: 300px">
                                            @if($item->image)
                                                <div class="col-6 pl-0 ">
                                                <img src="/public/uploads/communities/{{ $communityData->id . '/posts/' . $item->id . '/' . $item->image }} " alt="">
                                                </div>
                                            @endif
                                            @if($item->video)
                                                <div class="col-6 pr-0 d-flex align-items-center ">
                                                    <div class="box-body" style="width: 100%;">
                                                       <video width="100%" {{-- poster="/public/web_assets/images/bg/video-1-poster.jpg"--}} class="plyr-video-{{ $item->id }}"
                                                               playsinline controls>
                                                            <source src="/public/uploads/communities/{{ $communityData->id . '/posts/' . $item->id . '/' . $item->video }} " type="video/mp4"
                                                                  />

                                                        </video>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                            <div class="notification" >
                                            <span >
                                               {{-- <i class="fas fa-heart d-none pr-10"></i>
                                                <i class="far fa-heart pr-10"></i>--}}
                                                @php
                                                $postlikes  = 0;
                                                $postdislikes  = 0;
                                                foreach ($item->likes as $like){
                                                    ($like->sts == 1)? $postlikes += 1 : $postdislikes += 1;
                                                }
                                                @endphp
                                                <span class="ml-10" id="c_like" data-id="{{ $item->id }}">
                                                    <span data-id="1" id="count_like">{{ $postlikes  }}</span>
                                                    <i class="fa fa-thumbs-up ml-5" aria-hidden="true"></i>
                                                </span>
                                                <span class="ml-15" id="c_dislike" data-id="{{ $item->id }}">
                                                    <span data-id="0" id="count_like">{{ $postdislikes }}</span>
                                                    <i class="fa fa-thumbs-down ml-5" aria-hidden="true"></i>
                                                </span>

                                            </span >
                                                @php
                                                $c_post_count = 0;
                                                foreach ($postsComs as $c){
                                                    if($c->is_active == 1 && $c->post_id == $item->id){$c_post_count+=1;}
                                                }
                                                @endphp
                                                <span class="ml-20">{{ $c_post_count }}</span>
                                                <span data-id="{{ $item->id }}" id="comment-room-toggle" class="comment-toggle ml-10">
                                                    <i class="fa fa-comment" aria-hidden="true"></i>
                                                </span>
                                        </div>

                                        <div class="comment_room_{{ $item->id }} hide">

                                            {{--<pre>
                                                {{ print_r($postsComs) }}
                                            </pre>--}}
                                            <!-- Chat Start -->
                                            <div class="chat-wrap chat-wrap-my  custom-scroll mt-20 mr-0">
                                                <input id="post-id" type="hidden" value="{{$item->id}}">
                                                <ul id="chat-list-{{ $item->id }}" class="chat-li">
                                                    @if(count($postsComs)>0)
                                                        @foreach($postsComs as $comment)
                                                            @if($comment->post_id == $item->id && $comment->parent_id == 0 && $comment->is_active == 1)
                                                            <li>
                                                                <div class="chat">
                                                                    <div class="head">
                                                                        <h5>{{ $comment->user->name }}</h5>
                                                                       {{-- <span>Yesterday 05.30 am</span>--}}
                                                                        {{-- <a href="#"><i class="zmdi zmdi-replay"></i></a>--}}
                                                                    </div>
                                                                    <div class="body">
                                                                        <div data-id="{{$comment->user->id}}" id="view_user_data" class="image">
                                                                            @if($comment->user->image)
                                                                                <img src="{{ '/public/uploads/users/' .  str_replace('@tspu.tj', '', $comment->user->email)  . '/avatar/' . $comment->user->image }}"  alt="">
                                                                            @else
                                                                                <img src="/public/uploads/users/default-avatar.png"  alt="">
                                                                            @endif

                                                                        </div>
                                                                        <div class="content">
                                                                            <p>{!!   $comment->text !!}</p>
                                                                            <div class="footer">
                                                                                <span>{{ date_format($comment->created_at, 'Y.m.d  H:i') }}</span>
                                                                                <span data-id="{{ $comment->id }}" id="reply_comment_form" class="reply-comment ml-10">
                                                                                    <strong>Ответить</strong>
                                                                                </span>
                                                                            </div>

                                                                            <div class="replied col-12 pl-0 mt-15">
                                                                                <div id="reply-comment-form-{{ $comment->id }}" class="chat-submission reply hide">
                                                                                    <form id="form-reply-{{ $comment->id }}" action="#">
                                                                                        <input id="comment-reply-{{ $comment->id }}" type="text" placeholder="@lang('lang.write_something')">
                                                                                        <div class="buttons">
                                                                                            <button  data-id="{{ $comment->id }}" id="add-reply-comment" class="submit button button-box button-round button-primary mb-0"><i class="zmdi zmdi-mail-send"></i></button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div><!-- Chat End -->
                                                                                <ul id="coment-replies-{{ $comment->id }}" class="pl-0">
                                                                                    @foreach($postsComs as $comment_reply)
                                                                                        @if($comment_reply->parent_id == $comment->id && $comment_reply->is_active == 1)
                                                                                            <li>
                                                                                                <div class="chat">
                                                                                                    <div class="head mb-0">
                                                                                                        <h6 class="mb-0">{{ $comment_reply->user->name }}</h6>
                                                                                                    </div>
                                                                                                    <div class="body">
                                                                                                        <div  data-id="{{$comment_reply->user->id}}" id="view_user_data" class="image">
                                                                                                            @if($comment_reply->user->image)
                                                                                                                <img src="{{ '/public/uploads/users/' .  str_replace('@tspu.tj', '', $comment_reply->user->email)  . '/avatar/' . $comment_reply->user->image }}"  alt="">
                                                                                                            @else
                                                                                                                <img src="/public/uploads/users/default-avatar.png"  alt="">
                                                                                                            @endif
                                                                                                        </div>
                                                                                                        <div class="content">
                                                                                                            <p>{!! $comment_reply->text !!}</p>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                </div>
                                                                                            </li>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </ul>

                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </li>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                </ul>
                                            </div>

                                            <div class="chat-submission">
                                                <form action="#">
                                                    <input id="commet-text-{{ $item->id }}" type="text" placeholder="@lang('lang.write_something')">
                                                    <div class="buttons">
                                                        {{-- <label class="file-upload button button-box button-round button-primary" for="chat-file-upload">
                                                             <input type="file" id="chat-file-upload" multiple>
                                                             <i class="zmdi zmdi-attachment-alt"></i>
                                                         </label>--}}
                                                        <button data-id="{{$item->id}}" id="comment_post" class="submit button button-box button-round button-primary"><i class="zmdi zmdi-mail-send"></i></button>
                                                    </div>
                                                </form>
                                            </div><!-- Chat End -->

                                        </div>

                                    </div>
                                </div>
                            @endforeach
                                {{ $posts->links() }}
                            </div>
                        @endif
                    </div>

                @else
                    <div class="col-12 d-flex justify-content-center mt-80">
                    <h4 class="unsubscibed">@lang('lang.subscribe_to_view_posts')</h4>
                    </div>
                @endif


            </div>
            <div class="col-md-3">
                @if($communityData->image)
                    <img src="/public/uploads/communities/{{ $communityData->id . '/' . $communityData->image }} " alt="">
                @else
                    <img src="/public/no-image.png" alt="">
                @endif

                @if(Auth::check() && $communityData->user_id == Auth::user()->id)
                        <a data-toggle="modal" data-target="#exampleModal5"
                           data-whatever=""  class="btn-subcribe b-white d-flex justify-content-center align-items-center">
                            <span>@lang('lang.settings')</span>
                        </a>
                        <a href="{{ url('/community-post-manage/'. $communityData->id) }}"  class="btn-subcribe b-white d-flex justify-content-center align-items-center">
                            <span>@lang('lang.comment')</span>
                        </a>
                @elseif(Auth::check())
                    <span id="subcribe_community_single" data-id="{{ $communityData->id }}" class="  btn-subcribe b-white d-flex justify-content-center align-items-center">
                        @if($isUserSubscribed == 1)
                           <span>@lang('lang.you_subscribed')</span>
                        @else
                           <span>@lang('lang.subscribe')</span>
                        @endif
                    </span>
                @endif
                <div class="members b-white mt-10">
                    <div class="title"> @lang('lang.participant') <span data-id="{{ count($communityData->paricipants) }}" class="pl-15" id="count_parts">{{ count($communityData->paricipants) }}</span>
                    </div>
                    @foreach($communityData->paricipants as $item)
                    <span data-id="{{$item->user->id}}" id="view_user_data">
                        @if($item->user->image)
                        <img src="/public/uploads/users/{{ str_replace('@tspu.tj', '', $item->user->email) . '/avatar/' . $item->user->image }}" alt="">
                        @else
                            <img src="/public/uploads/users/default-avatar.png" alt="">
                        @endif
                    </span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal5">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header brbn">
                        <h5 class="modal-title">@lang('lang.edit_community')</h5>
                        <button type="button" class="close  p-0 " data-dismiss="modal" style="margin-left: 40%;">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body comm-form pt-0" id="comm_modal_body" data-id="{{ $communityData->id }}">
                        <form>
                            <div class="form-group">
                                <input type="text" class="form-control mb-10 single-adm-comm-name" id="comm_single_name" value="{!!  $communityData->title !!}">
                            </div>
                            <div class="form-group d-flex mb-20">
                                <form  enctype="multipart/form-data" id="upload_image_form" action="javascript:void(0)">

                                    <div class="row">
                                        <div class="col-sm-6 mb-2">
                                            @if($communityData->image)
                                                <img id="image_preview_container" src="/public/uploads/communities/{{ $communityData->id . '/' . $communityData->image }} " alt="preview image" style="max-height: 150px;">
                                            @else
                                                <img id="image_preview_container" src="/public/no-image.png" alt="preview image" style="max-height: 150px;">
                                            @endif
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mt-20">
                                                <input type="file" name="image"  id="image_comm" style="width: 100%">
                                                <span class="text-danger"></span>
                                            </div>
                                            <div class="col-md-12 pl-0 pr-0 mt-20 ">
                                                <button type="submit" id="upload_image_btn" class="button button-primary d-none std">@lang('lang.upload')</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="form-group">
                                <textarea id="comm_single_descr" class="form-control h-200 single-adm-comm-text" id="message-text" placeholder="@lang('lang.description')">{!!  $communityData->description !!}</textarea>

                            </div>
                            <div class="form-group d-flex justify-content-between">
                                <button id="comm_edit" class="button button-primary std mt-20 mb-20 fz-15 fw-500 pl-25 pr-25 pt-5 pb-5">
                                    @lang('lang.save')
                                </button>
                                <span id="remove_community" class="mt-25 pt-5 delete-community">@lang('lang.delete_community')</span>
                            </div>

                        </form>
                    </div>
                </div>
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

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>

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
    <script src="/public/web_assets/js/plugins/dropify/dropify.min.js"></script>
    <script src="/public/web_assets/js/plugins/dropify/dropify.active.js"></script>
    <script src="/public/web_assets/js/customize_dropify.js"></script>

    <!-- Plugins & Activation JS For Only This Page -->
    <script src="/public/web_assets/js/plugins/plyr/plyr.min.js"></script>
    <script src="/public/web_assets/js/plugins/plyr/plyr.active.js"></script>

    <script src="/public/web_assets/js/jquery.jscroll.min.js"></script>
    <script src="/public/web_assets/js/croppie.js"></script>
    <script src="/public/web_assets/js/exif.js"></script>


    <script src="/public/web_assets/js/plugins/quill/quill.min.js"></script>
    <script src="/public/web_assets/js/plugins/quill/quill.active.js"></script>
    <script src="/public/web_assets/js/katex.min.js"></script>

@endsection
