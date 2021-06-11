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
            {{--<div class=" col- md-4 col-sm-4 col-xs-12 col-lg-4 col-12 mb-30">
                <select id="facult_id"  class="form-control nice-select sel" title="Выберите">
                    <option>Выберите факултет</option>
                    @if(count($faculty)>0)
                        @foreach($faculty as $item)
                            @if($testData->facult_id == $item->id)
                                <option selected value="{{ $item->id }}" >{{ $item->title }}</option>
                            @endif
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
                            @if($testData->course_id == $item->id)
                                <option selected value="{{ $item->id }}" >{{ $item->title }}</option>
                            @endif
                            <option value="{{ $item->id }}" >{{ $item->title }}</option>
                        @endforeach
                    @endif
                </select>
            </div>--}}
            <div class=" col- md-4 col-sm-4 col-xs-12 col-lg-4 col-12 mb-30">
                {{--<select id="subject_id" class="form-control nice-select sel" title="Выберите курс">
                    <option>Выберите предмет</option>
                    @if(count($subject)>0)
                        @foreach($subject as $item)
                            @if($testData->subject_id == $item->id)
                                <option selected value="{{ $item->id }}" >{{ $item->title }}</option>
                            @endif
                            <option value="{{ $item->id }}" >{{ $item->title }}</option>
                        @endforeach
                    @endif
                </select>--}}
               {{-- <select id="subject_id" class="form-control bSelect" data-live-search="true">
                    @if(count($subject)>0)
                        @foreach($subject as $item)
                            @if($subID ?? '')
                                @if( $item->id == $subID ?? '')
                                    <option selected value="{{ $item->id }}" >{{ $item->title }}</option>
                                @endif
                                <option  value="{{ $item->id }}" >{{ $item->title }}</option>
                            @endif
                            <option  value="{{ $item->id }}" >{{ $item->title }}</option>
                        @endforeach
                    @endif
                </select>--}}
            </div>


        </div>
        <div data-id="{{ $testData->id }}" id="question_items" class="col-sm-12 pl-0 pr-0">
            <div class="col-sm-10 col-md-8 pl-0 ">


               {{-- <div  id="add_ques_item" class="add-question-item mb-15">
                    <div class="row mbn-15">
                    <h5>Введите вопрос</h5>
                    <div class="col-12 pl-40 mb-15">
                        <input id="ques_title1" name="add_question[]" type="text" class="form-control" placeholder="Введите вопрос">
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
                    <h5 class="mt-20">Введите варианты ответов и веберите правильный ответ:</h5>
                    <div class=" col-12 mb-20">
                        <div id="answers1" class="test-checkbox-radio-group">
                            <input type="hidden" name="ans_checked" id="answ_id_1" value="">
                            <label class="test-radio">
                                <input data-id="1" id="1" class="radio radioANS" type="radio" name="answer1">
                                <i class="icon"></i>
                                <input id="v1"  name="add_answer1[]" type="text" class="form-control" placeholder="">
                            </label>
                        </div>
                        <button data-id="1" id="add_test_p" class="button mt-10 std button-primary button-outline fl-right"> Добавить поле</button>
                    </div>
                </div>
                </div>--}}

                @php
                    $i=1;
                @endphp
                @if(count($testData->questions) > 0)

                    @foreach($testData->questions as $question)
                        <div id="q_i_{{ $question->id }}"  class="question-item mt-50">
                            <div class="q-item-header d-flex justify-content-between">
                                <h5>{{ $i.'.  '}}<span> {{ $question->title }} </span></h5>
                                <span data-id="{{ $question->id }}" id="edit_test_btn" style="font-size: 20px;">
                                    <i class="zmdi zmdi-edit"></i>
                                </span>
                            </div>
                            {{--<input type="hidden" name="question[]" value="{{ $question->id }}">--}}
                            @if($question->image)
                                <img class="mb-20 col-5" src="/public/uploads/test/{{ $testData->id . '/' . $question->image }}" alt="">
                            @endif

                            @if(count($question->answers) > 0)
                                <div class=" adomx-checkbox-radio-group">
{{--                                    <input type="hidden" name="ans" id="answ_id_{{ $question->id }}" value="">--}}
                                    @foreach($question->answers as $item)
                                        @if($item->is_true == 1)
                                            <input type="hidden" name="ans" id="answ_id_{{ $question->id }}" value="{{ $item->title }}">
                                        @endif
                                        <label class="adomx-radio">
                                            <input data-id="{{ $item->id }}"  type="hidden" name="{{ 'answers'.$question->id.'[]' }}" value="{{ $item->title }}">
{{--                                            <i class="icon"></i> --}}
                                            <span>{{ $item->title }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                            @php
                                $i += 1;
                            @endphp

                        </div>
                    @endforeach

                @endif


            </div>
        </div>
        <div class="col-sm-10 col-md-8 pl-0 mt-20">
            <input type="hidden" id="new_ques_id" value="{{ $i }}">
            <button  id="add_question_item_edited" class="button std button-success fl-right">
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
                                <input id="checkpoint"  type="text" class="form-control" placeholder="макс 100" value="{!! $testData->check_point !!}">
                            </div>
                            </div>
                        <div class="col-6 pl-0 pr-0">
                                <div class="col-12 mb-10">
                                    <p class="test-notifications-title">@lang('lang.set_timer') {{--<span>(необязательно)</span>--}}</p>
                                </div>
                                <div class="col-12 mb-15">
                                    <input id="test_timer" type="text" class="form-control" placeholder="мин" value="{!! $testData->test_timer !!}">
                                </div>
                            </div>
                    </div>
                    <div class="col-12 pl-0  d-table ">

                        <button id="save_edited_test" class="button button-primary fl-right test-notifications-btn">@lang('lang.save')</button>
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

@endsection
