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
            <div class="col-12 col-sm-12 col-lg-auto mb-20 d-flex justify-content-between">
                <div class="page-heading d-flex">
                    <h3>@lang('lang.ad')</h3>
                    @if(Auth::check() && Auth::user()->role_id == 1)
                        <span class="my-tests pt-1 pl-20">
                                <a href="{{ url('/elon-manage') }}">
                                    <h5>@lang('lang.manage')</h5>
                                </a>
                            </span>
                    @endif
                </div>
                <span class="single-elon-header pt-1 pl-20 float-right ">
                    <a href="{{ url('/elon') }}">
                        <span>@lang('lang.all_announcements')</span>
                    </a>
                    @if(Auth::check())
                        <a class="ml-15" href="{{ url('/my-elon') }}">
                            <span>@lang('lang.my_announcements')</span>
                        </a>
                    @endif
                </span>

            </div>
            <div class="col-sm-12 mt-25">
                <div class="my-ads">
                     @php($item = $elons)
                    <div class="header-elon col-9 mb-30">
                        <h4 >{{ $item->title }}</h4>
                        <p class="pt-5 mb-0">{{ date_format($item->created_at, 'Y.m.d H:i') }}</p>
                        <p class="pt-5">{{ $item->category->title }}</p>
                    </div>
                    <div class="col-12 pl-0 pr-0 d-flex">
                        <div class="col-9 pl-0">
                            @if($item->image)
                                <img class="cove" src="/public/uploads/elons/{{ $item->id . '/' . $item->image }}" alt="no-image">
                            @else
                                <img class="cove" src="/public/no-image.png" alt="no-image">
                            @endif
                            <p class="mt-20">
                                {{ $item->description }}
                            </p>
                        </div>
                        <div class="col-3 pr-0">
                            <p class="elon-single-price mb-20"><span>{{ $item->price }}</span></p>
                            <p class="elon-single-tel mb-20">
                                <a href="tel:+992{{ $item->phone_no }}">{{ $item->phone_no }}</a>
                            </p>
                            <div class="autor-elon-single d-flex align-items-center">
                                @if($item->user->image)
                                    <img src="/public/uploads/users/{{ str_replace('@tspu.tj', '', $item->user->email) }}/avatar/{{ $item->user->image }}" alt="">
                                @else
                                    <img src="/public/uploads/users/default-avatar.png" alt="">
                                @endif
                                <h4 class="ml-15">{{ $item->user->name }}</h4>
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


    <script src="/public/web_assets/js/plugins/nice-select/jquery.nice-select.min.js"></script>
    <script src="/public/web_assets/js/plugins/nice-select/niceSelect.active.js"></script>

@endsection
