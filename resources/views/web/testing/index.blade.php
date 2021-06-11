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
            <div class="col-12 col-sm-12 col-lg-auto mb-20 d-flex">
                <div class="col-11 pl-0 d-flex">
                <div class="page-heading">
                    <h3>@lang('lang.testing')</h3>
                </div>
                @if(Auth::check() &&( Auth::user()->role->id == 2 || Auth::user()->role->id == 1))
                    <span class="my-tests pt-1 pl-20">
                        <a href="{{ url('/my-tests') }}">
                            <h5>@lang('lang.my_tests')</h5>
                        </a>
                    </span>
                @endif
                </div>
                <div class="col-1 pr-0">
                    <div class="d-flex align-items-center pull-right">
                        <a class="faq-link" href="/faq#Тестирование">
                            <img src="/public/web_assets/images/icons/faq-black.svg" alt="">
                        </a>
                    </div>
                </div>



            </div>
            <div class=" col-12 mb-30 d-flex">
                <div class="col-5 pl-0">
                    <select id="faculty_id" class="form-control form-control-sm " >
                        <option value="">@lang('lang.select_facult')</option>
                        @if(count($faculty)>0)
                            @foreach($faculty as $item)
                                <option value="{{ $item->id }}" >{!!   $item->title !!}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-5">
                    <div class="cafs">
                        <select id="cafedra_id" class="form-control form-control-sm nice-select  sel">
                            <option value="">@lang('lang.select_a_cafedra')</option>
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <button id="filter_test" class="button button-primary floatr std" >
                        <span>@lang('lang.search2')</span>
                    </button>
                </div>
            </div>
           {{-- <div class="col-sm-12">--}}

           {{-- </div>--}}

        </div>

        <div class="row mt-35">
            <div class="col-sm-12">
                <table class="table tes ">
                    <thead>
                    <tr>
                        <th width="15%">@lang('lang.facult')</th>
                        <th width="15%">@lang('lang.subject')</th>
                        <th>@lang('lang.lang')</th>
                        <th>@lang('lang.author')</th>
                        <th class="text-center">@lang('lang.file')</th>
                        <th>@lang('lang.check_you')</th>
                    </tr>
                    </thead>
                    <tbody id="tests_body">
                    @if(count($test)>0)
                        @foreach($test as $item)
                            <tr>
                                <td>{{ mb_substr($item->faculty->title, 0, 30 )}}</td>
                                <td>{{mb_substr($item->subject, 0, 30) }}</td>
                                <td>{{ $item->lang }}</td>
                                <td>{{ mb_substr($item->user->name, 0, 25 )}}</td>
                                <td >
                                    @if($item->file)
                                        <a href="{{ url('/public/uploads/tests/'. $item->id .'/' . $item->file) }}" target="_blank" download="{{ $item->subject . substr ($item->file, -5)}}" class="download-test text-center ">
                                            <i class="zmdi zmdi-format-valign-bottom zmdi-hc-fw"></i>
                                        </a>
                                    @endif
                                </td>
                                <td class="d-flex align-items-center text-center">
                                    @if($item->has_example == 1)
                                    <a href="{{ url('/test/' . $item->id) }}">Пройти тест</a>
                                        @endif
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
    <script src="/public/web_assets/js/plugins/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="/public/web_assets/js/plugins/bootstrap-select/bootstrapSelect.active.js"></script>
    <script src="/public/web_assets/js/testing.js"></script>

@endsection
