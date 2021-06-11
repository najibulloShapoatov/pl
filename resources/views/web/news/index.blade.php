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

        <div class="row ">
            <div class="col-12 col-lg-auto mb-20">
                <div class="page-heading d-flex">
                    <h3>@lang('lang.latest_news')</h3>
                    @if(Auth::check()  && Auth::user()->role->id == 1)
                        <span class="my-tests pt-1 pl-20">
                        <a class="ml-20" href="{{ url('/news-manage') }}">
                            <h5>@lang('lang.manage')</h5>
                        </a>
                    </span>
                    @endif
                </div>
                <div class="yearBlk">
                @for($i=(int)date('Y'); $i >= (int)date('Y')-3; $i--)
                    <button data-id="{{$i}}" class="button std mt-30 select-year {{ ($i == date('Y') ? 'button-primary isActive' : 'button-apple') }}">{{ $i }}</button>
                @endfor
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 col-xs-12  resultNews">
                    @foreach($news as $item)
                    <div class="new-item d-flex">
                        <div class="cv col-md-4 col-sm-4 col-xs-4 col-lg-auto">
                            @if(!empty($item->image))
                                <img class="cove" src="/public/uploads/news/{{ $item->id }}/{{$item->image}}" alt="{{ $item->title }}">
                            @else
                                <img class="cove" src="/public/web_assets/images/news/Layer.png" alt="no-image">
                            @endif
                        </div>
                        <div class="content col-md-7 col-xs-7 col-sm-7 col-lg-auto">
                            <a href="{{ url('/news/' . $item->id) }}">
                                <h5>{{ $item->title }}</h5></a>
                            <div>
                            <span class="pt-10 mb-10"><i class="ti-calendar"></i>
                                &nbsp; {{ date('d.m.Y', strtotime($item->created_at)) }}
                            </span>
                            <span class="pl-40 pt-10 mb-10"><i class="ti-eye"></i>&nbsp;{{$item->viewed}}</span>
                            </div>
                            <p class= " col-10 pl-0">
                                {{ $item->annonce_text }}
                            </p>
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-sm-12 col-xs-12 newsLM">
                <div class=" newsbtn d-flex justify-content-center align-items-center ">
                    <button id="loadMore" data-page="1" class=" button button-outline button-primary ">
                         <span>@lang('lang.more')</span>
                    </button>
                </div>
            </div>

        </div>

    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')

@endsection
