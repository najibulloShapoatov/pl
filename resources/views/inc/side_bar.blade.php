@php

@endphp



<!-- Side Header Start -->
<div class="side-header show">
    <button class="side-header-close d-none"><i class="zmdi zmdi-close"></i></button>
    <!-- Side Header Inner Start -->
    <div class="side-header-inner custom-scroll ">

        <nav class="side-header-menu white" id="side-header-menu">
            <ul class="nav navbar-nav " id="sidenav01">
                <li>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ url('/') }}" style="width: 100%;">
                            <img class="sidebar-icon" src="/public/web_assets/images/icons/home.svg"  alt="">
                            &nbsp;<span>@lang('lang.home')</span></a>

                        <!-- <a href="#" data-toggle="collapse" data-target="#toggleDemoStruc" data-parent="#sidenav01"
                            class="collapsed menu-e">
                            <i class="fas fa-chevron-down pt-2"></i>
                        </a> -->
{{--                        <a href="{{ url('/') }}" class="mini-menu-item">--}}
{{--                            <img class="sidebar-icon-sub" src="/public/web_assets/images/icons/home.svg"  alt="">--}}
{{--                        </a>--}}
                    </div>
                    <!-- <div class="collapse" id="toggleDemoStruc">
                        <ul class="nav nav-list">
                            <li><a href="temp2.html">Submenu2.1</a></li>
                            <li><a href="#">Submenu2.21</a></li>
                            <li><a href="#">Submenu2.32</a></li>
                            <li><a href="#">Submenu2.33</a></li>
                            <li><a href="#">Submenu2.34</a></li>
                            <li><a href="#">Submenu2.35</a></li>
                        </ul>
                    </div> -->
                </li>
                <li>
                    <div class="d-flex justify-content-between">
                        <a href="{{ url('/news') }}" style="width: 100%;">
                            <img class="sidebar-icon" src="/public/web_assets/images/icons/news.svg"  alt="">
                            &nbsp;<span>@lang('lang.news')</span></a>
                        <!-- <a href="#" data-toggle="collapse" data-target="#toggleDemoUcheba" data-parent="#sidenav01"
                            class="collapsed menu-e">
                            <i class="fas fa-chevron-down ml-20 pt-2"></i>
                        </a> -->
{{--                        <a href="{{ url('/news') }}" class="mini-menu-item">--}}
{{--                            <img class="sidebar-icon-sub" src="/public/web_assets/images/icons/news.svg"  alt="">--}}
{{--                        </a>--}}
                    </div>
                    <!-- <div class="collapse" id="toggleDemoUcheba">
                        <ul class="nav nav-list">
                            <li><a href="temp2.html">Submenu2.1</a></li>
                            <li><a href="#">Submenu2.21</a></li>
                            <li><a href="#">Submenu2.32</a></li>
                            <li><a href="#">Submenu2.33</a></li>
                            <li><a href="#">Submenu2.34</a></li>
                            <li><a href="#">Submenu2.35</a></li>
                        </ul>
                    </div> -->
                </li>
                <li>
                    <div class="d-flex justify-content-between">
                        <a href="{{ url('/library') }}" style="width: 100%;">
                            <img class="sidebar-icon" src="/public/web_assets/images/icons/book.svg"  alt="">
                            &nbsp;<span>@lang('lang.library')</span></a>

                    <!--<a href="#" data-toggle="collapse" data-target="#toggleDemoNauka" data-parent="#sidenav01"
                            class="collapsed menu-e">
                            <i class="fas fa-chevron-down ml-20 pt-2"></i>
                        </a>-->
{{--                        <a href="{{ url('/library') }}" class="mini-menu-item">--}}
{{--                            <img class="sidebar-icon-sub" src="/public/web_assets/images/icons/book.svg"  alt="">--}}
{{--                        </a>--}}
                    </div>
                    <!--<div class="collapse" id="toggleDemoNauka">
                        <ul class="nav nav-list">
                            <li><a href="#">Submenu2.1</a></li>
                            <li><a href="#">Submenu2.21</a></li>
                              <li><a href="#">Submenu2.32</a></li>
                             <li><a href="#">Submenu2.33</a></li>
                             <li><a href="#">Submenu2.34</a></li>
                             <li><a href="#">Submenu2.35</a></li>
                         </ul>
                     </div>-->
                </li>
                <li>
                            <span class="d-flex justify-content-between">
                                <a href="{{ url('/forum') }}" style="width: 100%;">
                                    <img class="sidebar-icon" src="/public/web_assets/images/icons/forum.svg"  alt="">
                                    &nbsp;<span>@lang('lang.forum')</span></a>
                                <!-- <a href="#" data-toggle="collapse" data-target="#toggleDemoVideo" data-parent="#sidenav01"
                                   class="collapsed menu-e">
                                    <i class="fas fa-chevron-down pt-2"></i>
                                </a> -->
{{--                                <a href="{{ url('/forum') }}" class="mini-menu-item">--}}
{{--                                    <img class="sidebar-icon-sub" src="/public/web_assets/images/icons/forum.svg"  alt="">--}}
{{--                                </a>--}}
                            </span>
                <!--<div class="collapse" id="toggleDemoVideo">
                        <ul class="nav nav-list">
                            <li><a href="{{ url('/video-les/genre/') }}">Названия раздела 1</a></li>
                            <li><a href="{{ url('/video-les/genre/') }}">Названия раздела 2</a></li>
                             <li><a href="#">Submenu2.21</a></li>
                            <li><a href="#">Submenu2.32</a></li>
                            <li><a href="#">Submenu2.33</a></li>
                            <li><a href="#">Submenu2.34</a></li>
                            <li><a href="#">Submenu2.35</a></li>
                        </ul>
                    </div>-->
                </li>
                <li>
                    <div class="d-flex justify-content-between"><a href="{{url('/community')}}" style="width: 100%;">
                            <img class="sidebar-icon" src="/public/web_assets/images/icons/community.svg"  alt="">
                            &nbsp;<span>@lang('lang.community')</span></a>

                    <!--<a href="#" data-toggle="collapse" data-target="#toggleDemoBook" data-parent="#sidenav01"
                           class="collapsed menu-e">
                            <i class="fas fa-chevron-down pt-2"></i>
                        </a> -->
{{--                        <a href="{{url('/community')}}" class="mini-menu-item">--}}
{{--                            <img class="sidebar-icon-sub" src="/public/web_assets/images/icons/community.svg"  alt="">--}}
{{--                        </a>--}}
                    </div>
                <!--<div class="collapse" id="toggleDemoBook">
                        <ul class="nav nav-list">


                            {{--<li><a href="books-pages2.html">Жанр 2</a></li>--}}
                             <li><a href="#">Submenu2.21</a></li>
                            <li><a href="#">Submenu2.32</a></li>
                            <li><a href="#">Submenu2.33</a></li>
                            <li><a href="#">Submenu2.34</a></li>
                            <li><a href="#">Submenu2.35</a></li>
                        </ul>
                    </div>-->
                </li>
                <li>
                    <div class="d-flex justify-content-between"><a href="{{ url('/elon') }}" style="width: 100%;">
                            <img class="sidebar-icon" src="/public/web_assets/images/icons/shout.svg"  alt="">
                            &nbsp;<span>@lang('lang.elon')</span></a>

                        <!-- <a href="#" data-toggle="collapse" data-target="#toggleDemo" data-parent="#sidenav01"
                            class="collapsed menu-e">
                            <i class="fas fa-chevron-down ml-20 pt-2"></i>
                        </a> -->
                        {{--                        <a href="{{ url('/video-course') }}" class="mini-menu-item">--}}
                        {{--                            <img class="sidebar-icon-sub" src="/public/web_assets/images/icons/video-course.svg"  alt="">--}}
                        {{--                        </a>--}}
                    </div>
                    <!-- <div class="collapse" id="toggleDemo">
                        <ul class="nav nav-list">
                            <li><a href="temp2.html">Submenu2.1</a></li>
                            <li><a href="#">Submenu2.21</a></li>
                            <li><a href="#">Submenu2.32</a></li>
                            <li><a href="#">Submenu2.33</a></li>
                            <li><a href="#">Submenu2.34</a></li>
                            <li><a href="#">Submenu2.35</a></li>
                        </ul>
                    </div> -->
                </li>
                <li>
                    <div class="d-flex justify-content-between"><a href="{{ url('/poolling') }}" style="width: 100%;">
                            <img class="sidebar-icon" src="/public/web_assets/images/icons/mdi_poll-box-outline.svg"  alt="">
                            &nbsp;<span>@lang('lang.pooling')</span></a>

                        <!-- <a href="#" data-toggle="collapse" data-target="#toggleDemo" data-parent="#sidenav01"
                            class="collapsed menu-e">
                            <i class="fas fa-chevron-down ml-20 pt-2"></i>
                        </a> -->
                        {{--                        <a href="{{ url('/video-course') }}" class="mini-menu-item">--}}
                        {{--                            <img class="sidebar-icon-sub" src="/public/web_assets/images/icons/video-course.svg"  alt="">--}}
                        {{--                        </a>--}}
                    </div>
                    <!-- <div class="collapse" id="toggleDemo">
                        <ul class="nav nav-list">
                            <li><a href="temp2.html">Submenu2.1</a></li>
                            <li><a href="#">Submenu2.21</a></li>
                            <li><a href="#">Submenu2.32</a></li>
                            <li><a href="#">Submenu2.33</a></li>
                            <li><a href="#">Submenu2.34</a></li>
                            <li><a href="#">Submenu2.35</a></li>
                        </ul>
                    </div> -->
                </li>
                <li>
                    <div class="d-flex justify-content-between"><a href="{{ url('/video-course') }}" style="width: 100%;">
                            <img class="sidebar-icon" src="/public/web_assets/images/icons/video-course.svg"  alt="">
                            &nbsp;<span>@lang('lang.videocourses')</span></a>

                        <!-- <a href="#" data-toggle="collapse" data-target="#toggleDemo" data-parent="#sidenav01"
                            class="collapsed menu-e">
                            <i class="fas fa-chevron-down ml-20 pt-2"></i>
                        </a> -->
{{--                        <a href="{{ url('/video-course') }}" class="mini-menu-item">--}}
{{--                            <img class="sidebar-icon-sub" src="/public/web_assets/images/icons/video-course.svg"  alt="">--}}
{{--                        </a>--}}
                    </div>
                    <!-- <div class="collapse" id="toggleDemo">
                        <ul class="nav nav-list">
                            <li><a href="temp2.html">Submenu2.1</a></li>
                            <li><a href="#">Submenu2.21</a></li>
                            <li><a href="#">Submenu2.32</a></li>
                            <li><a href="#">Submenu2.33</a></li>
                            <li><a href="#">Submenu2.34</a></li>
                            <li><a href="#">Submenu2.35</a></li>
                        </ul>
                    </div> -->
                </li>
                <li>
                    <div class="d-flex justify-content-between">
                        <a href="{{ url('/testing') }}" style="width: 100%;">
                            <img class="sidebar-icon" src="/public/web_assets/images/icons/testing.svg"  alt="">
                            &nbsp;<span>@lang('lang.testing')</span></a>

                        <!-- <a href="#" data-toggle="collapse" data-target="#toggleDemo" data-parent="#sidenav01"
                            class="collapsed menu-e">
                            <i class="fas fa-chevron-down ml-20 pt-2"></i>
                        </a>-->
{{--                        <a href="{{ url('/testing') }}" class="mini-menu-item">--}}
{{--                            <img class="sidebar-icon-sub" src="/public/web_assets/images/icons/testing.svg"  alt="">--}}
{{--                        </a>--}}
                    </div>
                    <!-- <div class="collapse" id="toggleDemo">
                        <ul class="nav nav-list">
                            <li><a href="temp2.html">Submenu2.1</a></li>
                            <li><a href="#">Submenu2.21</a></li>
                            <li><a href="#">Submenu2.32</a></li>
                            <li><a href="#">Submenu2.33</a></li>
                            <li><a href="#">Submenu2.34</a></li>
                            <li><a href="#">Submenu2.35</a></li>
                        </ul>
                    </div> -->
                </li>
                <li>
                    <div class="d-flex justify-content-between">
                        <a href="{{ url('/faylobmennik') }}" style="width: 100%;">
                            <img class="sidebar-icon" src="/public/web_assets/images/icons/faylobmennik.svg"  alt="">
                            &nbsp;<span>@lang('lang.file_share')</span></a>

                        <!-- <a href="#" data-toggle="collapse" data-target="#toggleDemo" data-parent="#sidenav01"
                            class="collapsed menu-e">
                            <i class="fas fa-chevron-down ml-20 pt-2"></i>
                        </a> -->
{{--                        <a href="{{ url('/faylobmennik') }}" class="mini-menu-item">--}}
{{--                            <img class="sidebar-icon-sub" src="/public/web_assets/images/icons/faylobmennik.svg"  alt="">--}}
{{--                        </a>--}}
                    </div>
                    <!-- <div class="collapse" id="toggleDemo">
                        <ul class="nav nav-list">
                            <li><a href="temp2.html">Submenu2.1</a></li>
                            <li><a href="#">Submenu2.21</a></li>
                            <li><a href="#">Submenu2.32</a></li>
                            <li><a href="#">Submenu2.33</a></li>
                            <li><a href="#">Submenu2.34</a></li>
                            <li><a href="#">Submenu2.35</a></li>
                        </ul>
                    </div> -->
                </li>
                <li>
                    <div class="d-flex justify-content-between"><a href="{{ url('/vebinar') }}" style="width: 100%;">
                            <img class="sidebar-icon" src="/public/web_assets/images/icons/vebinar.svg"  alt="">
                            &nbsp;<span>@lang('lang.vebinar')</span></a>

                        <!-- <a href="#" data-toggle="collapse" data-target="#toggleDemo" data-parent="#sidenav01"
                            class="collapsed menu-e">
                            <i class="fas fa-chevron-down ml-20 pt-2"></i>
                        </a> -->
{{--                        <a href="{{ url('/vebinar') }}" class="mini-menu-item">--}}
{{--                            <img class="sidebar-icon-sub" src="/public/web_assets/images/icons/vebinar.svg"  alt="">--}}
{{--                        </a>--}}
                    </div>
                    <!-- <div class="collapse" id="toggleDemo">
                        <ul class="nav nav-list">
                            <li><a href="temp2.html">Submenu2.1</a></li>
                            <li><a href="#">Submenu2.21</a></li>
                            <li><a href="#">Submenu2.32</a></li>
                            <li><a href="#">Submenu2.33</a></li>
                            <li><a href="#">Submenu2.34</a></li>
                            <li><a href="#">Submenu2.35</a></li>
                        </ul>
                    </div> -->
                </li>
                @if(Auth::check() && Auth::user()->role_id == 1)
                    <li>
                        <div class="d-flex justify-content-between"><a href="{{ url('/faculties-manage') }}" style="width: 100%;">
                                <img class="sidebar-icon" src="/public/web_assets/images/icons/faculty.svg"  alt="">
                                &nbsp;<span>@lang('lang.faculties')</span></a>
                        </div>
                        <!-- <div class="collapse" id="toggleDemo">
                            <ul class="nav nav-list">
                                <li><a href="temp2.html">Submenu2.1</a></li>
                                <li><a href="#">Submenu2.21</a></li>
                                <li><a href="#">Submenu2.32</a></li>
                                <li><a href="#">Submenu2.33</a></li>
                                <li><a href="#">Submenu2.34</a></li>
                                <li><a href="#">Submenu2.35</a></li>
                            </ul>
                        </div> -->
                    </li>
                @endif
                <li>
                    @if($userInfo)
                    <div class="d-flex justify-content-between"><a href="{{ url('/to-do') }}" style="width: 100%;">
                            <img class="sidebar-icon" src="/public/web_assets/images/icons/todo.svg"  alt="">
                            &nbsp;<span>@lang('lang.to_do')</span></a>

                        <!-- <a href="#" data-toggle="collapse" data-target="#toggleDemo" data-parent="#sidenav01"
                            class="collapsed menu-e">
                            <i class="fas fa-chevron-down ml-20 pt-2"></i>
                        </a> -->
{{--                        <a href="{{ url('/to-do') }}" class="mini-menu-item">--}}
{{--                            <img class="sidebar-icon-sub" src="/public/web_assets/images/icons/todo.svg"  alt="">--}}
{{--                        </a>--}}
                    </div>
                    <!-- <div class="collapse" id="toggleDemo">
                        <ul class="nav nav-list">
                            <li><a href="temp2.html">Submenu2.1</a></li>
                            <li><a href="#">Submenu2.21</a></li>
                            <li><a href="#">Submenu2.32</a></li>
                            <li><a href="#">Submenu2.33</a></li>
                            <li><a href="#">Submenu2.34</a></li>
                            <li><a href="#">Submenu2.35</a></li>
                        </ul>
                    </div> -->
                        @endif
                </li>
{{--                <li>--}}
{{--                    @if($userInfo)--}}
{{--                    <div class="d-flex justify-content-between">--}}
{{--                        <a href="{{ url('/tickets') }}" style="width: 100%;">--}}
{{--                            <img class="sidebar-icon" src="/public/web_assets/images/icons/my-appeal.svg"  alt="">--}}
{{--                            &nbsp;<span>Мои обращение</span>--}}
{{--                        </a>--}}

{{--                        <!-- <a href="#" data-toggle="collapse" data-target="#toggleDemo" data-parent="#sidenav01"--}}
{{--                            class="collapsed menu-e">--}}
{{--                            <i class="fas fa-chevron-down ml-20 pt-2"></i>--}}
{{--                        </a> -->--}}
{{--                        <a href="{{ url('/my-appeal') }}" class="mini-menu-item">--}}
{{--                            <img class="sidebar-icon-sub" src="/public/web_assets/images/icons/my-appeal.svg"  alt="">--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    <!-- <div class="collapse" id="toggleDemo">--}}
{{--                        <ul class="nav nav-list">--}}
{{--                            <li><a href="temp2.html">Submenu2.1</a></li>--}}
{{--                            <li><a href="#">Submenu2.21</a></li>--}}
{{--                            <li><a href="#">Submenu2.32</a></li>--}}
{{--                            <li><a href="#">Submenu2.33</a></li>--}}
{{--                            <li><a href="#">Submenu2.34</a></li>--}}
{{--                            <li><a href="#">Submenu2.35</a></li>--}}
{{--                        </ul>--}}
{{--                    </div> -->--}}
{{--                        @endif--}}
{{--                </li>--}}
                <li>
                    @if($userInfo)
                    <div class="d-flex justify-content-between"><a href="{{ url('/profile') }}" style="width: 100%;">
                            <img class="sidebar-icon" src="/public/web_assets/images/icons/profile.svg"  alt="">
                            &nbsp;<span>@lang('lang.profile')</span></a>
{{--                        <a href="{{ url('/profile') }}" class="mini-menu-item">--}}
{{--                            <img class="sidebar-icon-sub" src="/public/web_assets/images/icons/profile.svg"  alt="">--}}
{{--                        </a>--}}
                    </div>
                        @endif
                </li>
                @if(Auth::check() && Auth::user()->role_id == 1)
                    <li>
                        <div class="d-flex justify-content-between"><a href="{{ url('/site-customize') }}" style="width: 100%;">
                                <img class="sidebar-icon" src="/public/web_assets/images/icons/settings.svg"  alt="">
                                &nbsp;<span>@lang('lang.site_setting')</span></a>
                            {{--                            <a href="{{ url('/logout') }}" class="mini-menu-item">--}}
                            {{--                                <img class="sidebar-icon-sub" src="/public/web_assets/images/icons/logout.svg"  alt="">--}}
                            {{--                            </a>--}}
                        </div>
                    </li>
                @endif
                <li>
                    <div class="d-flex justify-content-between"><a href="{{ url('/faq') }}" style="width: 100%;">
                            <img class="sidebar-icon" src="/public/web_assets/images/icons/faq.svg"  alt="">
                            &nbsp;<span>@lang('lang.faq')</span></a>
                        {{--                            <a href="{{ url('/logout') }}" class="mini-menu-item">--}}
                        {{--                                <img class="sidebar-icon-sub" src="/public/web_assets/images/icons/logout.svg"  alt="">--}}
                        {{--                            </a>--}}
                    </div>
                </li>
                <li>
                    @if($userInfo)
                        <div class="d-flex justify-content-between"><a href="{{ url('/logout') }}" style="width: 100%;">
                                <img class="sidebar-icon" src="/public/web_assets/images/icons/logout.svg"  alt="">
                                &nbsp;<span>@lang('lang.exit')</span></a>
{{--                            <a href="{{ url('/logout') }}" class="mini-menu-item">--}}
{{--                                <img class="sidebar-icon-sub" src="/public/web_assets/images/icons/logout.svg"  alt="">--}}
{{--                            </a>--}}
                        </div>
                    @endif
                </li>
                <li class="authentication">
                    <div class="d-flex justify-content-between">
                        @if(empty($userInfo))
                            <a href="{{ url('/login') }}" style="width: 100%;">
                            <i class="far fa-user-circle mr-1"></i>
                            &nbsp;@lang('lang.login')</a>
                        @endif
                    </div>
                </li>
                <li class="authentication">
                    <div class="d-flex justify-content-between">
                        @if(empty($userInfo))
                            <a href="{{ url('/register') }}" style="width: 100%;">
                                <i class="far fa-user-circle mr-1"></i>
                                &nbsp;@lang('lang.register')</a>
                        @endif
                    </div>
                </li>


            </ul>
        </nav>
    </div><!-- Side Header Inner End -->
</div><!-- Side Header End -->
