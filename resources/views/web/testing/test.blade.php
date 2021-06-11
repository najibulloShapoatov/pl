@extends('layouts.main')

@section('title')
    ТСПУ им. С. Айни
@endsection
@section('styles')
    <!-- Custom Style CSS Only For Demo Purpose -->
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/style-primary.css">
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/custom.css">
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/fortest.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

@endsection




@section('content')
    @include('inc.header')
    @include('inc.side_bar')
    <!-- Content Body Start -->
    <div class="content-body" onload="document.all.q-items.reset()">
        <div class="row">
            <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                <input type="hidden" name="test" value="{{ $testData->id }}">
                <table class="table tes t">
                    <thead>
                    <tr>
                        <th>@lang('lang.subject')</th>
                        <th>@lang('lang.author')</th>
                        <th>@lang('lang.timer')</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $testData->subject }}</td>
                        <td>{{ $testData->user->name }}</td>
                        <td data-id="{{ $testData->test_timer }}" id="test_timer">{{ ($testData->test_timer<10)? '0'. $testData->test_timer . ': 00' : $testData->test_timer  . ': 00' }}</td>
                    </tr>

                    </tbody>
                </table>
            </div>

            <div class="col-sm-12 q-items"  name="q-items">
                @if(count($testData->questions) > 0)
                    @php
                        $i=1;
                    @endphp
                    @foreach($testData->questions as $question)
                        <div class="question-item mt-50">
                            <h5>{{ $i.'.  '. $question->title }}</h5>
                            <input type="hidden" name="question[]" value="{{ $question->id }}">

                            @if($question->image)
                                <img class="mb-20 col-5" src="/public/uploads/test/{{ $testData->id . '/' . $question->image }}" alt="">
                            @endif

                            @if(count($question->answers) > 0)
                                <div class=" adomx-checkbox-radio-group">
                                    <input type="hidden" name="answer[]" id="answ_id_{{ $question->id }}" value="">
                                    @foreach($question->answers as $item)
                                        <label class="adomx-radio">
                                            <input data-id="{{ $question->id }}" class="pt-20 radioAnswer" type="radio" name="{{ $i }}" value="{{ $item->id }}">
                                            <i class="icon"></i> <span>{{ $item->title }}</span>
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

            <div class="col-sm-12 mt-45">

                <button id="btn_result_test" class="button button-square button-success zav" data-toggle="modal">
                    <span>@lang('lang.finish')</span>
                </button>

                <!-- Modal -->
                <div class="modal " id="exampleModal5" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header brbn">
                                <h5 class="modal-title"></h5>
                                <a href="{{ url('/testing') }}" id="btn_close_res_test" class="close  p-0 fl-right" data-dismiss="modal" >
                                        <span class="modal-res"  aria-hidden="true">&times;</span>
                                </a>
                            </div>
                            <div class="modal-body pt-0 point">
                                <div class="title">@lang('lang.you_pointed'):</div>
                                <span></span>
                                <p>@lang('lang.points')</p>

                                <div class="proxodnoy-ball"></div>
                            </div>
                            <div class="modal-footer brtn">
                                <!-- <button class="button button-outline std appeal-btn">Отправить</button> -->
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
    <script src="/public/web_assets/js/testing.js"></script>



@endsection
