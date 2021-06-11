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
                <div class="page-heading">
                    <h3>@lang('lang.my_announcements')</h3>
                </div>
                <span class="my-tests pt-1 pl-20 float-right">
                    <a href="{{ url('/elon') }}">
                        <h5>@lang('lang.all_announcements')</h5>
                    </a>
                </span>

            </div>
            <div class="col-sm-12">
                <div class="my-ads">
                    <ul class="pl-0">
                        @foreach( $elons as $item)
                        <li class="pl-0 pr-0">
                            <div class="my-ads-item mb-20 d-flex">
                                <div class="cv col-2 pl-0">
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
                                    <span class="pt-15 mb-0">{{ date_format($item->created_at, 'Y.m.d H:i') }}</span>
                                    <span class="pt-15 pl-20">{{ $item->category->title }}</span>
                                    <div class="ads-price">{{ $item->price }}&nbsp;c.</div>
                                </div>
                                <div class="col-5 d-flex pr-0 align-items-center">
                                    <div class="wrap" style=" width: 100%;">
                                        <div class="notification-ads float-right">
                                            <a href="{{ url('/edit-elon/' . $item->id) }}"><i class="zmdi zmdi-edit"></i></a>
                                            <a href="{{ url('/elon/' . $item->id) }}"><i class="zmdi zmdi-eye zmdi-hc-fw"></i></a>
                                            <span data-id="{{ $item->id }}" id="remove_elon"><i class="ti-close"></i></span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                {{ $elons->links() }}
            </div>

        </div>
    </div><!-- Content Body End -->

    @include('inc.footer')
@endsection


@section('scripts')


    <script src="/public/web_assets/js/plugins/nice-select/jquery.nice-select.min.js"></script>
    <script src="/public/web_assets/js/plugins/nice-select/niceSelect.active.js"></script>

@endsection
