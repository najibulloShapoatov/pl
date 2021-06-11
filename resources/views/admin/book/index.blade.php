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
        <div class="row">
        <div class="col-12 col-sm-12 col-lg-auto mb-20 d-flex justify-content-between ">
            <div class="page-heading">
                <h3>@lang('lang.manage_handbook')</h3>
            </div>

        </div>
        </div>
        <ul class="list-group">
            <li class="list-group-item"><a style="width: 100%" href="{{ url('/manage-book/category') }}">@lang('lang.categries')</a></li>
            <li class="list-group-item"><a style="width: 100%" href="{{ url('/manage-book/langs') }}">@lang('lang.langs')</a></li>
            <li class="list-group-item"><a style="width: 100%" href="{{ url('/manage-book/authors') }}">@lang('authors')</a></li>
            <li class="list-group-item"><a style="width: 100%" href="{{ url('/manage-book/licenses') }}">@lang('lang.lics')</a></li>
            <li class="list-group-item"><a style="width: 100%" href="{{ url('/manage-book/genre') }}">@lang('lang.genres')</a></li>
        </ul>




    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')

@endsection
