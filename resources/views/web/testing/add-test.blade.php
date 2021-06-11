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
                    <h3>@lang('lang.add')</h3>
                </div>
            </div>
          {{--  <div class=" col- md-4 col-sm-4 col-xs-12 col-lg-4 col-12 mb-30">
                <select id="facult_id"  class="form-control nice-select sel" title="Выберите">
                    <option>Выберите факултет</option>
                    @if(count($faculty)>0)
                        @foreach($faculty as $item)
                            <option value="{{ $item->id }}" >{{ $item->title }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class=" col- md-4 col-sm-4 col-xs-12 col-lg-4 col-12 mb-30">
                <select id="course_id" class="form-control nice-select sel" title="Выберите курс">
                    <option>Выберите курс</option>
                    @if(count($course)>0)
                        @foreach($course as $item)
                            <option value="{{ $item->id }}" >{{ $item->title }}</option>
                        @endforeach
                    @endif
                </select>
            </div>--}}
            <div class=" col- md-8 col-sm-8 col-xs-12 col-lg-8 col-12 mb-30 d-flex">
                <div class="col-6 pl-0">
                    <select id="faculty_id" class="form-control form-control-sm bSelect " >
                        <option>@lang('lang.add')</option>
                        @if(count($faculty)>0)
                            @foreach($faculty as $item)
                                <option value="{{ $item->id }}" >{!!   $item->title !!}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-6">
                    <div class="cafs">
                    <select id="cafedra_id" class="form-control form-control-sm nice-select  sel">
                        <option>@lang('select_a_cafedra')</option>
                    </select>
                    </div>
                </div>
            </div>
        <div class=" col- md-8 col-sm-8 col-xs-12 col-lg-8 col-12 mb-30 d-flex">
            <div class="col-6 pl-0">
                <input class="form-control form-control-sm" type="text" name="" id="lang" placeholder="@lang('lang.enter_lang_test')">
            </div>
            <div class="col-6">
                <input class="form-control form-control-sm" type="text" name="" id="subject" placeholder="@lang('lang.enter_name_subject')">
            </div>
        </div>

        <div class=" col- md-8 col-sm-8 col-xs-12 col-lg-8 col-12 mb-30 d-flex align-items-center">
            <div class="col-6 pl-0">
                <input type="file" name="" id="file_test">
            </div>
            <div class="col-6 d-flex align-items-center">
                <input type="hidden" value="1" id="hasExample">
                <div class="adomx-checkbox-radio-group inline">
                    <label class="adomx-radio-2">
                        <input data-id="1"  class="h_example" checked type="radio" name="inlineAdomxRadio2">
                        <i class="icon"></i> @lang('lang.with_example')
                    </label>
                    <label class="adomx-radio-2">
                        <input data-id="0" class="h_example" type="radio" name="inlineAdomxRadio2">
                        <i class="icon"></i> @lang('lang.without_example')
                    </label>
                </div>
            </div>
        </div>


        </div>
        <section id="example_test" class="">
            <div id="question_items" class="col-sm-12 pl-0 pr-0">
                <div class="col-sm-10 col-md-8 pl-0 ">


                    <div  id="add_ques_item" class="add-question-item mb-15">
                        <div class="row mbn-15">
                        <h5>@lang('lang.enter_question')</h5>
                        <div class="col-12 pl-40 mb-15">
                            <input id="ques_title1" name="add_question[]" type="text" class="form-control" placeholder="@lang('lang.enter_question')">
                            <span data-id="1" class="add-test-image">
                                <i class="fa fa-picture-o" aria-hidden="true"></i>
                            </span>
                        </div>
                            <div id="upload_image_test1" class=" d-none col-12">
                                <div class="col-12 elon_img mb-15   p-20">
                                    <form class="" action="" enctype="multipart/form-data">
                                        <div class="col-4">
                                            <input type="hidden" id="quest_img_1" value="">
                                            <input
                                                data-id="1"
                                                type="file"
                                                class="dropify-img-preview"
                                                id="ques_img1"
                                                name="add_question_img[]"
                                                data-allowed-file-extensions="jpg jpeg png gif "
                                                data-max-file-size="5M"/>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <h5 class="mt-20">@lang('lang.enter_answers'):</h5>
                        <div class=" col-12 mb-20">
                            <div id="answers1" class="test-checkbox-radio-group">
                                <input type="hidden" name="ans_checked" id="answ_id_1" value="">
                                <label class="test-radio">
                                    <input data-id="1" id="1" class="radio radioANS" type="radio" name="answer1">
                                    <i class="icon"></i>
                                    <input id="v1"  name="add_answer1[]" type="text" class="form-control" placeholder="">
                                </label>
                            </div>
                            <button data-id="1" id="add_test_p" class="button mt-10 std button-primary button-outline fl-right"> @lang('lang.add_pole')</button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-10 col-md-8 pl-0 mt-20">
                <input type="hidden" id="new_ques_id" value="1">
                <button  id="add_question_item" class="button std button-success fl-right">
                    <span>@lang('lang.add_question')</span>
                </button>
            </div>
            <div class="col-sm-10 col-md-8 col-12 pl-0 mt-55 mb-30">
                <div class="test-notifications ">
                    <div class="wrap">
                        <div class="col-12 pl-0 pr-0 d-flex">
                            <div class="col-6 pl-0 pr-0">
                                <div class="col-12 mb-10">
                                    <p class="test-notifications-title">@lang('lang.set_checkpoint'):</p>
                                </div>
                                <div class="col-12 mb-15">
                                    <input id="checkpoint"  type="text" class="form-control" placeholder="">
                                </div>
                                </div>
                            <div class="col-6 pl-0 pr-0">
                                    <div class="col-12 mb-10">
                                        <p class="test-notifications-title">@lang('lang.set_timer') {{--<span>(необязательно)</span>--}}</p>
                                    </div>
                                    <div class="col-12 mb-15">
                                        <input id="test_timer" type="text" class="form-control" placeholder="">
                                    </div>
                                </div>
                        </div>
                        <div class="col-12 pl-0  d-table ">

                            <button id="save_new_test" class="button button-primary fl-right test-notifications-btn">@lang('lang.save')</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="without_example" class="d-none">
            <div class=" col- md-8 col-sm-8 col-xs-12 col-lg-8 col-12 mb-30 ">
                <button id="save_without" class="button button-primary pull-right">@lang('lang.save')</button>
            </div>
        </section>


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

@endsection
