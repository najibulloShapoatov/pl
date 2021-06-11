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
                    <h3>@lang('lang.edit')</h3>
                </div>
            </div>



        </div>
        <div id="question_items" class="col-sm-12 pl-0 pr-0">
            <div class="col-sm-10 col-md-8 pl-0 ">
                <div id="err" class="alert alert-danger d-none" role="alert">
                </div>
                <div  id="add_ques_item" class="add-question-item mb-15">
                    <div class="row mbn-15">
                    <h5>@lang('lang.enter_question')</h5>
                    <div class="col-12  mb-15">
                        <input id="pool_title" type="text" class="form-control" placeholder="" value="{!!   $data->title !!}">

                    </div>
                        </div>
                    <h5 class="mt-20">@lang('lang.enter_variant_answer'):</h5>
                    @if(count($data->answers) > 0)
                        @foreach($data->answers as $item)
                            <div class=" col-12 mb-20">
                                <div  class="test-checkbox-radio-group">
                                    <input  type="text" name="pool-ads[]" class="form-control pol-ans" placeholder="" value="{!! $item->title !!}">
                                </div>
                            </div>
                        @endforeach
                    @endif
                <!--Single Date Picker-->
                    <div class="col-12 mb-20 d-flex align-items-end">
                        <div class="col-8">
                            <h6 class="mb-15">@lang('lang.enter_date_start_pool')</h6>
                            <input id="start_date_pool" type="text" class="form-control input-date-single" value="{{ $data->start_date }}">
                        </div>
                        {{--<div class="col-4">
                            <button  id="pool_add_btn" class="button mt-10 std button-primary button-outline fl-right"> Сохранить</button>
                        </div>--}}
                    </div>

                    <div class="col-12 mb-20 d-flex align-items-end">
                        <div class="col-8">
                            <h6 class="mb-15">@lang('lang.enter_date_end_pool')</h6>
                            <input id="end_date_pool" type="text" class="form-control input-date-single" value="{{ $data->end_date }}">
                        </div>
                        {{--<div class="col-4">
                            <button  id="pool_add_btn" class="button mt-10 std button-primary button-outline fl-right"> Сохранить</button>
                        </div>--}}
                    </div>

                    <!--Single Date Picker-->
                    <div class=" col-12 mb-20">
                        <button data-id="{{ $data->id }}" id="pool_edit_btn" class="button std button-primary button-outline fl-right"> @lang('lang.save')</button>
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

    <!-- OWl Carousel -->
    <script src="/public/web_assets/js/plugins/dropify/dropify.min.js"></script>
    <script src="/public/web_assets/js/plugins/dropify/dropify.active.js"></script>
    <script src="/public/web_assets/js/customize_dropify.js"></script>
    <script src="/public/web_assets/js/testing.js"></script>

    <script src="/public/web_assets/js/plugins/moment/moment.min.js"></script>
    <script src="/public/web_assets/js/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="/public/web_assets/js/plugins/daterangepicker/daterangepicker.active.js"></script>

@endsection
