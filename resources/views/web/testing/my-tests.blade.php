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
            <div class="col-12 col-sm-12 col-lg-auto mb-20 d-flex">
                <div class="page-heading">
                    <h3>@lang('lang.my_tests')</h3>
                </div>
                <span class="my-tests pt-1 pl-20">
                    <a href="{{ url('/add-test') }}">
                        <h5>@lang('lang.add')</h5>
                    </a>
                </span>

            </div>
            <div class="col-sm-12">
                <table class="table tes ">
                    <thead>
                    <tr>
                        <th>@lang('lang.facult')</th>
                        <th>@lang('lang.subject')</th>
                        <th>@lang('lang.lang')</th>
                        <th>@lang('lang.teacher')</th>

                    </tr>
                    </thead>
                    <tbody>
                    @if(count($test)>0)
                        @foreach($test as $item)
                            <tr>
                                <td>{{ $item->faculty->title }}</td>
                                <td>{{ $item->subject }}</td>
                                <td>{{ $item->lang }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td >
                                    <div class="notification float-right">
                                        <a href="{{ url("/edit-test/" . $item->id) }}"><i class="zmdi zmdi-edit"></i></a>
                                        <a href="{{ url("/test/" . $item->id) }}"><i class="zmdi zmdi-eye zmdi-hc-fw"></i></a>
                                        <a href="{{ url("/test-delete/" . $item->id) }}"><i class="ti-close"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif



                    </tbody>
                </table>
            </div>

        </div>
    </div><!-- Content Body End -->

    @include('inc.footer')
@endsection


@section('scripts')


    <script src="/public/web_assets/js/plugins/nice-select/jquery.nice-select.min.js"></script>
    <script src="/public/web_assets/js/plugins/nice-select/niceSelect.active.js"></script>

@endsection
