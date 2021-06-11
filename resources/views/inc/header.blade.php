@php



@endphp
<!-- Header Section Start -->
<div class="header-section">
    <div class="container-fluid">
        <div class="row justify-content-around align-items-center mr-0">

            <!-- Header Logo (Header Left) Start -->
            <div class="header-logo col-auto pr-20" style="border-bottom: none">
                <a href="/">
                    <div class="d-flex pl-10" >
                        <img height="100%" width="70px" style="padding: 5px" src="/public/web_assets/images/logo/logo%20tgpu.png" alt="">
                        <div class="logo-text ml-15 pt-5 d-flex align-items-center">
                            <h5 style="color: #fff"> @lang('lang.logo_text')</h5>
                        </div>
                    </div>
                </a>
            </div><!-- Header Logo (Header Left) End -->

            <!-- Header Right Start -->
            <div class="header-right flex-grow-1 col-auto">
                <div class="row justify-content-between align-items-center">

                    <!-- Side Header Toggle & Search Start -->
                    <div class="col-auto">
                        <div class="row align-items-center">

                            <!--Side Header Toggle-->
                            <div class="col-auto"><button class="side-header-toggle"><i
                                        class="zmdi zmdi-menu"></i></button></div>

                            <!--Header Search-->
                            <div class="col-auto">

                                <div class="header-search">

                                    <button class="header-search-open d-block d-xl-none">
                                        <i style="color: #fff" class="zmdi zmdi-search"></i></button>

                                    <div class="header-search-form">
                                        <div class="d-flex">
                                        <form {{-- action="{{ route('search.index') }}"--}}>
                                            <button id="search_g_btn" class="btn-search">
                                                <i  class="zmdi zmdi-search"></i>
                                            </button>
                                            <input autocomplete="off" name="search_text" id="search_g_text" type="text" placeholder=" @lang('lang.search')">
                                            <input name="search_cat" id="search_cat_id" type="hidden" value="1">
                                            <button class="category">
                                                <div class="dropdown">
                                                    <span id="razdel_text" class="button dropdown-toggle toggle-btn"
                                                       data-toggle="dropdown" aria-expanded="false">@lang('lang.sections')
                                                        &nbsp; </span>
                                                    <div class="dropdown-menu" x-placement="bottom-start"
                                                         style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 40px, 0px);">
                                                        <span class="dropdown-item" data-id="1" id="search_radel_item">@lang('lang.news')</span>
                                                        <span class="dropdown-item" data-id="2" id="search_radel_item">@lang('lang.library')</span>
                                                        <span class="dropdown-item" data-id="3" id="search_radel_item">@lang('lang.forum')</span>
                                                        <span class="dropdown-item" data-id="4" id="search_radel_item">@lang('lang.community')</span>
                                                        <span class="dropdown-item" data-id="5" id="search_radel_item">@lang('lang.elon')</span>
                                                        <span class="dropdown-item" data-id="6" id="search_radel_item">@lang('lang.videocourses')</span>
                                                    </div>
                                                </div>
                                            </button>
                                        </form>
                                        <button style="position: relative" class=" header-search-close fl-right ml-10 d-block d-xl-none"><i
                                                class="zmdi zmdi-close"></i>
                                        </button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div><!-- Side Header Toggle & Search End -->

                    <!-- Header Notifications Area Start -->
                    <div class="col-auto justify-content-center">

                        <ul class="header-notification-area ">

                            <!-- Socials -->

                            <li class="social-item white">
                                <a href="{{ $Infodata->facebook_link }}"><i class="fab fa-facebook-square"></i></a>

                            </li>
                            <li class=" social-item white">
                                <a href="{{ $Infodata->instagram_link }}"><i class="fab fa-instagram"></i></a>
                            </li>
                            <li class=" social-item white">
                                <a href="{{ $Infodata->youtube_link }}"><i class="fab fa-youtube"></i></a>
                            </li>

                            <!--  -->

                            <!--Language-->
                            <li class="adomx-dropdown localization-site position-relative col-auto">
                                <a id="lang_header" class="toggle white" href="#">
                                    @if (App::isLocale('ru'))
                                        <img class="lang-flag " src="/public/web_assets/images/flags/flag-0.jpg" alt="">&nbsp;
                                        <span class="ml-5">@lang('lang.russian')</span>
                                    @endif
                                    @if(App::isLocale('tj'))
                                        <img class="lang-flag " src="/public/web_assets/images/flags/flag-2.jpg" alt="">&nbsp;
                                        <span class="ml-5">@lang('lang.tadjik')</span>
                                    @endif
                                    <i class=" ml-10 mt-1 zmdi zmdi-caret-down drop-arrow"></i>
                                </a>

                                <!-- Dropdown -->
                                <ul class="adomx-dropdown-menu dropdown-menu-language">
                                    <li data-id="tj" class="mb-10" id="set_lang">
                                        <a href="#"><img src="/public/web_assets/images/flags/flag-2.jpg" alt="">
                                            @lang('lang.tadjik')</a>
                                    </li>
                                    <li data-id="ru" class="mb-10" id="set_lang">
                                        <a href="#"><img src="/public/web_assets/images/flags/flag-0.jpg" alt=""> @lang('lang.russian')
                                        </a>
                                    </li>

                                </ul>

                            </li>

                           {{-- <!--Mail-->
                            <!-- <li class="adomx-dropdown col-auto">
                                <a class="toggle" href="#"><i class="zmdi zmdi-email-open"></i><span class="badge"></span></a> -->

                            <!-- Dropdown -->
                            <!-- <div class="adomx-dropdown-menu dropdown-menu-mail">
                                    <div class="head">
                                        <h4 class="title">You have 3 new mail.</h4>
                                    </div>
                                    <div class="body custom-scroll">
                                        <ul>
                                            <li>
                                                <a href="#">
                                                    <div class="image"><img src="assets/images/avatar/avatar-2.jpg" alt=""></div>
                                                    <div class="content">
                                                        <h6>Sub: New Account</h6>
                                                        <p>There are many variations of passages of Lorem Ipsum available. </p>
                                                    </div>
                                                    <span class="reply"><i class="zmdi zmdi-mail-reply"></i></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <div class="image"><img src="assets/images/avatar/avatar-1.jpg" alt=""></div>
                                                    <div class="content">
                                                        <h6>Sub: Mail Support</h6>
                                                        <p>There are many variations of passages of Lorem Ipsum available. </p>
                                                    </div>
                                                    <span class="reply"><i class="zmdi zmdi-mail-reply"></i></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <div class="image"><img src="assets/images/avatar/avatar-2.jpg" alt=""></div>
                                                    <div class="content">
                                                        <h6>Sub: Product inquiry</h6>
                                                        <p>There are many variations of passages of Lorem Ipsum available. </p>
                                                    </div>
                                                    <span class="reply"><i class="zmdi zmdi-mail-reply"></i></span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <div class="image"><img src="assets/images/avatar/avatar-1.jpg" alt=""></div>
                                                    <div class="content">
                                                        <h6>Sub: Mail Support</h6>
                                                        <p>There are many variations of passages of Lorem Ipsum available. </p>
                                                    </div>
                                                    <span class="reply"><i class="zmdi zmdi-mail-reply"></i></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </li> -->

                            <!--Notification-->
                            <!-- <li class="adomx-dropdown col-auto">
                                <a class="toggle" href="#"><i class="zmdi zmdi-notifications"></i><span class="badge"></span></a> -->

                            <!-- Dropdown -->
                            <!-- <div class="adomx-dropdown-menu dropdown-menu-notifications">
                                    <div class="head">
                                        <h5 class="title">You have 4 new notification.</h5>
                                    </div>
                                    <div class="body custom-scroll">
                                        <ul>
                                            <li>
                                                <a href="#">
                                                    <i class="zmdi zmdi-notifications-none"></i>
                                                    <p>There are many variations of pages available.</p>
                                                    <span>11.00 am   Today</span>
                                                </a>
                                                <button class="delete"><i class="zmdi zmdi-close-circle-o"></i></button>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="zmdi zmdi-block"></i>
                                                    <p>There are many variations of pages available.</p>
                                                    <span>11.00 am   Today</span>
                                                </a>
                                                <button class="delete"><i class="zmdi zmdi-close-circle-o"></i></button>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="zmdi zmdi-info-outline"></i>
                                                    <p>There are many variations of pages available.</p>
                                                    <span>11.00 am   Today</span>
                                                </a>
                                                <button class="delete"><i class="zmdi zmdi-close-circle-o"></i></button>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="zmdi zmdi-shield-security"></i>
                                                    <p>There are many variations of pages available.</p>
                                                    <span>11.00 am   Today</span>
                                                </a>
                                                <button class="delete"><i class="zmdi zmdi-close-circle-o"></i></button>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="zmdi zmdi-notifications-none"></i>
                                                    <p>There are many variations of pages available.</p>
                                                    <span>11.00 am   Today</span>
                                                </a>
                                                <button class="delete"><i class="zmdi zmdi-close-circle-o"></i></button>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="zmdi zmdi-block"></i>
                                                    <p>There are many variations of pages available.</p>
                                                    <span>11.00 am   Today</span>
                                                </a>
                                                <button class="delete"><i class="zmdi zmdi-close-circle-o"></i></button>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="zmdi zmdi-info-outline"></i>
                                                    <p>There are many variations of pages available.</p>
                                                    <span>11.00 am   Today</span>
                                                </a>
                                                <button class="delete"><i class="zmdi zmdi-close-circle-o"></i></button>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="zmdi zmdi-shield-security"></i>
                                                    <p>There are many variations of pages available.</p>
                                                    <span>11.00 am   Today</span>
                                                </a>
                                                <button class="delete"><i class="zmdi zmdi-close-circle-o"></i></button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="footer">
                                        <a href="#" class="view-all">view all</a>
                                    </div>
                                </div>

                            </li> -->

                            <!--User-->
                            <!-- <li class="adomx-dropdown col-auto">
                                <a class="toggle" href="#">
                                    <span class="user">
                                <span class="avatar">
                                    <img src="assets/images/avatar/avatar-1.jpg" alt="">
                                    <span class="status"></span>
                                    </span>
                                    <span class="name">Madison Howard</span>
                                    </span>
                                </a> -->

                            <!-- Dropdown -->
                            <!-- <div class="adomx-dropdown-menu dropdown-menu-user">
                                    <div class="head">
                                        <h5 class="name"><a href="#">Madison Howard</a></h5>
                                        <a class="mail" href="#">mailnam@mail.com</a>
                                    </div>
                                    <div class="body">
                                        <ul>
                                            <li><a href="#"><i class="zmdi zmdi-account"></i>Profile</a></li>
                                            <li><a href="#"><i class="zmdi zmdi-email-open"></i>Inbox</a></li>
                                            <li><a href="#"><i class="zmdi zmdi-wallpaper"></i>Activity</a></li>
                                        </ul>
                                        <ul>
                                            <li><a href="#"><i class="zmdi zmdi-settings"></i>Setting</a></li>
                                            <li><a href="#"><i class="zmdi zmdi-lock-open"></i>Sing out</a></li>
                                        </ul>
                                        <ul>
                                            <li><a href="#"><i class="zmdi zmdi-paypal"></i>Payment</a></li>
                                            <li><a href="#"><i class="zmdi zmdi-google-pages"></i>Invoice</a></li>
                                        </ul>
                                    </div>
                                </div>

                            </li> -->
--}}


                            @if(Auth::check())
                                <li class="adomx-dropdown ml-50 mr-0  col-auto">
                                    @if(Auth::user()->role_id != 1)
                                        <a class="toggle">
                                    @else
                                        <a href="{{ url('/notice-manage') }}">
                                    @endif
                                        <i class="zmdi zmdi-notifications text-white"></i>
                                        @if(Auth::user()->role_id != 1)
                                            <span id="notice_sts" class="badge {{ ($n_count > 0)? '': 'd-none' }}"></span>
                                        @endif
                                    </a>

                                    <!-- Dropdown -->
                                    <div class="adomx-dropdown-menu dropdown-menu-notifications">
                                        <div class="head bacground-white">
                                            <h5 id="not-readed-message" class="title">@lang('lang.you_have') {{ $n_count }} @lang('lang.not_read_notifications')</h5>
                                            <input type="hidden" id="count_not_readed_notice" value="{{ $n_count }}">
                                        </div>
                                        <div class="body custom-scroll bacground-white">
                                            <ul>
                                                @if(count($notices) > 0)
                                                    @foreach($notices as $item)
                                                        @php
                                                        $isReaded = false;
                                                            foreach ($notice_res_user as $nru){
                                                                if ($nru->notice_id == $item->id){ $isReaded = true; break;}
                                                            }
                                                        @endphp
                                                        <li id="notice_{{ $item->id }}" class="{{ ($isReaded)? 'notice-readed': 'notice-not-readed' }}">
                                                            <a data-id="{{ $item->id }}" id="notice_view_btn" data-toggle="modal" >
                                                                <i class="zmdi zmdi-notifications-none"></i>
                                                                <p>{{ mb_substr($item->title, 0, 100)   }}
                                                                   {{-- @foreach ($item->results as $res)
                                                                        {{ $res->user_id }}
                                                                    @endforeach--}}
                                                                </p>
                                                                <span class="text-black-50 ml-10" >{{ date_format($item->created_at, 'Y.m.d  H:i') }}</span>
                                                            </a>
                                                            <button data-id="{{ $item->id }}" id="mask-as-read" class="delete"><i class="zmdi zmdi-check-circle zmdi-hc-fw"></i></button>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                        {{--<div class="footer">
                                            <a href="#" class="view-all">view all</a>
                                        </div>--}}
                                    </div>

                                </li>
                            @endif


                            <!-- Registration -->
                            <li class=" adomx-dropdown col-auto  register ">
                                @if($userInfo)
                                    <!--User-->
                                <a class="toggle" href="#">
                                            <span class="user">
                                        <span class="avatar" id="user_avatar_h">
                                            @if($userInfo->image)
                                                <img src="/public/uploads/users/{{ str_replace('@tspu.tj', '', Auth::user()->email) }}/avatar/{{ $userInfo->image }}" alt="">
                                            @else
                                                <h5 style=" margin-top: 25%;">{{ mb_substr($userInfo->name, 0, 2) }}</h5>
                                            @endif
                                            </span>
                                            <span class="name">{!! mb_substr(str_replace('@tspu.tj', '', $userInfo->email), 0, 10) !!}</span>
                                            </span>
                                </a>

                                <!-- Dropdown -->
                                <div class="adomx-dropdown-menu dropdown-menu-user mt-20 h-name">
                                    <div class="head">
                                        <h5 class="name">{{ $userInfo->name  }}</h5>
                                    </div>
                                    <div class="body">
                                        <ul>
                                            <li >
                                                <a class="h-link" href="{{ url('/profile') }}"><i class="zmdi zmdi-account"></i>
                                                    @lang('lang.profile')</a>
                                            </li>
                                        </ul>
                                        <ul>
                                            <li>
                                                <a class="h-link" href="{{ url('/logout') }}"><i class="zmdi zmdi-lock-open"></i>
                                                    @lang('lang.exit')
                                                </a>
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                                @else
                                    <span>
                                        <i class="far fa-user-circle mr-1"></i>
                                        <a class=" white" href="{{ url('/register') }}">
                                        &nbsp;@lang('lang.register')
                                    </a>
                                    /</span>
                                   <span> <a class=" white" href="{{ url('/login') }}">
                                        &nbsp;@lang('lang.login')
                                    </a></span>
                                @endif
                            </li>
                        </ul>

                    </div><!-- Header Notifications Area End -->

                </div>
            </div><!-- Header Right End -->

        </div>
    </div>


    @if(Auth::check())
    <!-- Modal -->
    <div class="modal {{--fade--}}" id="notice-modal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('lang.notice')</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body p-20 pl-30 pr-30">
                    <h5></h5>
                    <p></p>
                </div>
               {{-- <div class="modal-footer">
                    <button class="button button-danger" data-dismiss="modal">Close</button>
                    <button class="button button-primary">Save changes</button>
                </div>--}}
            </div>
        </div>
    </div>
    @endif
</div><!-- Header Section End -->
