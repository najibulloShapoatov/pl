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
        <div class="row">
            <div class="col-sm-12 col-md-12 col-xs-12 col-12  pl-0 pr-0 mb-30">
                <!-- Page Heading Start -->
                <div class="col-12 col-lg-auto mb-20  ">
                    <div class="page-heading d-flex ">
                        <h3>@lang('lang.elon')</h3>
                        @if(Auth::check() && Auth::user()->role_id == 1)
                            <span class="my-tests pt-1 pl-20">
                                <a href="{{ url('/elon-manage') }}">
                                    <h5>@lang('lang.manage')</h5>
                                </a>
                            </span>
                        @endif
                    </div>
                </div><!-- Page Heading End -->
                <div class=" search-box header-search forum-search col-12 d-flex justify-content-between pl-0">
                    <div class="search-box-form col-9 header-search-for forum-search-form">
                        <form action="{{ route('elon-search.index') }}">
                            <input autocomplete="off"  name="search" type="text" placeholder="@lang('lang.search_by_advertisement')">
                            <button type="submit"  class="elon category">
                                <span>
                                    <i class="zmdi zmdi-search"></i>
                                </span>
                            </button>
                        </form>

                    </div>
                    @if(Auth::check())
                         <span class="add-ads">
                             <a href="{{ url('/add-elon') }}">@lang('lang.post_an_ad')</a>
                         </span>
                    @endif
                    <div class="d-flex align-items-center">
                        <a class="faq-link" href="/faq#Доска объявлений">
                            <img src="/public/web_assets/images/icons/faq-black.svg" alt="">
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-12 pl-0 pr-0 d-flex ads-tab-header">
                <div class="col-10">
                    <ul class="nav nav-pills elon-cats col-12 mb-15">
                        <li class="nav-item pl-0 ml-0 ">
                            <a href="{{ url('/elon') }}" class="nav-link {{ ($id_active == 0)? 'active' :'' }}"><span>@lang('lang.all')</span></a>
                        </li>
                        @if( count($elon_cats) > 0)
                            @foreach($elon_cats as $item)
                                <li class="nav-item ">
                                    <a href="{{ url('/elon_cat/' . $item->id ) }}" class="nav-link {{ ($id_active == $item->id)? 'active' :'' }} " >
                                        <span>{{ $item->title }}</span></a>
                                </li>
                            @endforeach
                        @endif

                    </ul>
                </div>
                <div class="col-2 text-center my-ads-class">
                    @if(Auth::check())
                        <a href="{{ url('/my-elon') }}"><span>@lang('lang.my_announcements')</span></a>
                    @endif
                </div>
            </div>

            <div class="col-10 mb-30">
                <div class="box search">
                    <div id="elon-content" class="box-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="allads">
                                <h5 class="mb-30">@lang('lang.new_announcements')</h5>
                                @foreach($elon_data as $item)
                                    @if($item->status == 1)
                                <div class="ads-item mb-20 d-flex">
                                    <div class="cv col-3 pl-0">
                                        @if($item->image)
                                            <img class="cove" src="/public/uploads/elons/{{ $item->id . '/' . $item->image }}" alt="no-image">
                                        @else
                                            <img class="cove" src="/public/no-image.png" alt="no-image">
                                        @endif
                                    </div>
                                    <div class="content col-5">
                                        <a href="{{ url('/elon/' . $item->id) }}" class="ads-title">
                                            {{ mb_substr($item->title, 0, 100) }}
                                        </a>
                                        <p class="pt-5 mb-0">{{ date_format($item->created_at, 'Y.m.d H:i') }}</p>
                                        <p class="pt-5">{{ $item->category->title }}</p>
                                        <span class="ads-price">{{ $item->price }}</span>
                                    </div>

                                </div>
                                    @endif
                                @endforeach
                                @if(!isset($_GET['search']))
                                    {{ $elon_data->links() }}
                                @endif

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
