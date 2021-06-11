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

        <div class="col-12 pr-0 pl-0 col-lg-auto mb-20">
            <div class="page-heading d-flex">
                <div class="col-11 d-flex">
                <h3>@lang('lang.pooling')</h3>
                @if(Auth::check()  && Auth::user()->role->id == 1)
                    <span class="my-tests pt-1 pl-20">
                    <a href="{{ url('/admin-pool') }}">
                        <h5>@lang('lang.pooling')</h5>
                    </a>
                </span>
                @endif
                </div>
                <div class="col-1 pr-0">
                <div class="d-flex align-items-center pull-right">
                    <a class="faq-link" href="/faq#Голосование">
                        <img src="/public/web_assets/images/icons/faq-black.svg" alt="">
                    </a>
                </div>
                </div>
            </div>

        </div>

        <div class="row mt-60">
            <div class="col-sm-12">
                <div class="row">

                    @if(count($pools) >0)

                        @foreach($pools as $pool)
                            @php
                                $isPolled=false;
                                $qnt = 0;
                                foreach ($pool->answers as $answer){
                                    foreach ($answer->poolres as $item ){ if($item->ip_cookie == $ip){$isPolled=true; break;}}
                                }
                            @endphp
                            @php
                                $check = \Carbon\Carbon::now()->between($pool->start_date,$pool->end_date);
                                foreach($pool->answers as $answer){
                                    $qnt += count($answer->poolres);
                                }
                            @endphp



                        <div class="col-md-4 mb-40">
                        <div class="voting" style=" height: 455px;">
                            <div class="title">@lang('lang.pooling')</div>

                            <div class="content">
                                <p>{{ $pool->title }}</p>
                                @if(!$check)
                                    <div id="pool_res_percent_{{$pool->id}}" class="box-body voting-progres ">
                                        @if(count($pool->answers) > 0)
                                            @foreach($pool->answers as $answer)
                                                <span class="pool-res-text">{{ $answer->title }}</span>
                                                <div class="progress">
                                                    @php
                                                    if ($qnt != 0){
                                                        $n = (count($answer->poolres)/$qnt)*100;
                                                     }else{ $n=0;}


                                                    @endphp
                                                    <div class="progress-bar" role="progressbar" style="width: {{ ($n < 13)? 13.5 : number_format($n, 1, '.', ' ') }}%" aria-valuenow="{{ number_format($n, 2, '.', ' ') }}"
                                                         aria-valuemin="0" aria-valuemax="100">{{ number_format($n, 1, '.', ' ') }}%</div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <span class="count-text-voting mt-50">@lang('lang.voted') {{ $qnt }} @lang('lang.people')</span>
                                    <span class="count-text-voting">@lang('lang.voting_closed_at'){{ $pool->end_date }}</span>
                                @else
                                    <div class="box-body pool_loading_{{$pool->id}} voting-loading hide d-flex justify-content-center align-items-center">
                                        <div class="spinner-border">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                    <div id="pool_res_percent_{{$pool->id}}" class="box-body voting-progres {{ ($isPolled)? '' : 'hide' }}">
                                        @if(count($pool->answers) > 0)
                                            @foreach($pool->answers as $answer)
                                                <span class="pool-res-text">{{ $answer->title }}</span>
                                                <div class="progress">
                                                    @php
                                                        if ($qnt != 0){
                                                        $n = (count($answer->poolres)/$qnt)*100;
                                                     }else{ $n=0;}
                                                    @endphp
                                                    <div class="progress-bar" role="progressbar" style="width: {{ ($n < 12)? 12 : number_format($n, 2, '.', ' ') }}%" aria-valuenow="{{ number_format($n, 2, '.', ' ') }}"
                                                         aria-valuemin="0" aria-valuemax="100">{{ number_format($n, 2, '.', ' ') }}%</div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="adomx-checkbox-radio-group mt-15 voting-radio_{{$pool->id}} {{ ($isPolled)? 'hide': 'show' }}">
                                        @if(count($pool->answers) > 0)
                                            <input type="hidden" id="pool_selected_{{$pool->id}}" value="">

                                            @foreach($pool->answers as $answer)
                                            <label  class="adomx-radio">
                                                <input data-id="{{ $answer->id }}" type="radio" class="poll-input_p" id="{{$pool->id}}" name="adomxRadio">
                                                <i class="icon"></i>
                                                {{ $answer->title }}</label>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-center btn-voting ">
                                        @if($isPolled)
                                            <span class="polled">@lang('lang.thanks')</span>
                                        @else
                                        <span class="btn_pooling_{{$pool->id}}" data-id="{{$pool->id}}" id="pooling" >@lang('lang.pool')</span>
                                        @endif

                                    </div>
                                    {{--<a data-id="{{ $pool->id }}" id="result_pool" style="font-weight: 400;" >Резултаты</a>--}}
                                    <span class="count-text-voting">@lang('lang.voted') {{ $qnt }} @lang('lang.people')</span>
                                @endif
                            </div>
                        </div>
                    </div>
                        @endforeach
                    @endif
               {{--

                    <div class="col-md-4 mb-40">
                        <div class="voting">
                            <div class="title">Голосoвание</div>
                            <div class="content">
                                <p>{{ $pool->title }}</p>
                                <div class="box-body voting-loading hide d-flex justify-content-center align-items-center">
                                    <div class="spinner-border">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div id="pool_res_percent" class="box-body voting-progres hide ">
                                    @if(count($pool->answers) > 0)
                                        @foreach($pool->answers as $answer)
                                            <div class="progress">
                                                @php($n = (count($answer->poolres)/$p_res)*100)
                                                <div class="progress-bar" role="progressbar" style="width: 20%" aria-valuenow="{{ number_format($n, 2, '.', ' ') }}"
                                                     aria-valuemin="0" aria-valuemax="100">{{ number_format($n, 2, '.', ' ') }}%</div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="adomx-checkbox-radio-group voting-radio show ">
                                    @if(count($pool->answers) > 0)
                                        <input type="hidden" id="pool_selected" value="">
                                        @foreach($pool->answers as $answer)
                                        <label  class="adomx-radio">
                                            <input data-id="{{ $answer->id }}" type="radio" class="pool-input" name="adomxRadio">
                                            <i class="icon"></i>
                                            {{ $answer->title }}</label>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="d-flex justify-content-center btn-voting">
                                    <span id="polling" >Голосовать</span>
                                </div>
                                <a data-id="{{ $pool->id }}" id="result_pool" style="font-weight: 400;" >Резултаты</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-40">
                        <div class="voting">
                            <div class="title">Голосoвание</div>
                            <div class="content">
                                <p>{{ $pool->title }}</p>
                                <div class="box-body voting-loading hide d-flex justify-content-center align-items-center">
                                    <div class="spinner-border">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div id="pool_res_percent" class="box-body voting-progres hide ">
                                    @if(count($pool->answers) > 0)
                                        @foreach($pool->answers as $answer)
                                            <div class="progress">
                                                @php($n = (count($answer->poolres)/$p_res)*100)
                                                <div class="progress-bar" role="progressbar" style="width: 20%" aria-valuenow="{{ number_format($n, 2, '.', ' ') }}"
                                                     aria-valuemin="0" aria-valuemax="100">{{ number_format($n, 2, '.', ' ') }}%</div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="adomx-checkbox-radio-group voting-radio show ">
                                    @if(count($pool->answers) > 0)
                                        <input type="hidden" id="pool_selected" value="">
                                        @foreach($pool->answers as $answer)
                                            <label  class="adomx-radio">
                                                <input data-id="{{ $answer->id }}" type="radio" class="pool-input" name="adomxRadio">
                                                <i class="icon"></i>
                                                {{ $answer->title }}</label>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="d-flex justify-content-center btn-voting">
                                    <span id="polling" >Голосовать</span>
                                </div>
                                <a data-id="{{ $pool->id }}" id="result_pool" style="font-weight: 400;" >Резултаты</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-40">
                        <div class="voting">
                            <div class="title">Голосoвание</div>
                            <div class="content">
                                <p>{{ $pool->title }}</p>
                                <div class="box-body voting-loading hide d-flex justify-content-center align-items-center">
                                    <div class="spinner-border">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div id="pool_res_percent" class="box-body voting-progres hide ">
                                    @if(count($pool->answers) > 0)
                                        @foreach($pool->answers as $answer)
                                            <div class="progress">
                                                @php($n = (count($answer->poolres)/$p_res)*100)
                                                <div class="progress-bar" role="progressbar" style="width: 20%" aria-valuenow="{{ number_format($n, 2, '.', ' ') }}"
                                                     aria-valuemin="0" aria-valuemax="100">{{ number_format($n, 2, '.', ' ') }}%</div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="adomx-checkbox-radio-group voting-radio show ">
                                    @if(count($pool->answers) > 0)
                                        <input type="hidden" id="pool_selected" value="">
                                        @foreach($pool->answers as $answer)
                                            <label  class="adomx-radio">
                                                <input data-id="{{ $answer->id }}" type="radio" class="pool-input" name="adomxRadio">
                                                <i class="icon"></i>
                                                {{ $answer->title }}</label>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="d-flex justify-content-center btn-voting">
                                    <span id="polling" >Голосовать</span>
                                </div>
                                <a data-id="{{ $pool->id }}" id="result_pool" style="font-weight: 400;" >Резултаты</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-40">
                        <div class="voting">
                            <div class="title">Голосoвание</div>
                            <div class="content">
                                <p>{{ $pool->title }}</p>
                                <div class="box-body voting-loading hide d-flex justify-content-center align-items-center">
                                    <div class="spinner-border">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div id="pool_res_percent" class="box-body voting-progres hide ">
                                    @if(count($pool->answers) > 0)
                                        @foreach($pool->answers as $answer)
                                            <div class="progress">
                                                @php($n = (count($answer->poolres)/$p_res)*100)
                                                <div class="progress-bar" role="progressbar" style="width: 20%" aria-valuenow="{{ number_format($n, 2, '.', ' ') }}"
                                                     aria-valuemin="0" aria-valuemax="100">{{ number_format($n, 2, '.', ' ') }}%</div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="adomx-checkbox-radio-group voting-radio show ">
                                    @if(count($pool->answers) > 0)
                                        <input type="hidden" id="pool_selected" value="">
                                        @foreach($pool->answers as $answer)
                                            <label  class="adomx-radio">
                                                <input data-id="{{ $answer->id }}" type="radio" class="pool-input" name="adomxRadio">
                                                <i class="icon"></i>
                                                {{ $answer->title }}</label>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="d-flex justify-content-center btn-voting">
                                    <span id="polling" >Голосовать</span>
                                </div>
                                <a data-id="{{ $pool->id }}" id="result_pool" style="font-weight: 400;" >Резултаты</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-40">
                        <div class="voting">
                            <div class="title">Голосoвание</div>
                            <div class="content">
                                <p>{{ $pool->title }}</p>
                                <div class="box-body voting-loading hide d-flex justify-content-center align-items-center">
                                    <div class="spinner-border">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div id="pool_res_percent" class="box-body voting-progres hide ">
                                    @if(count($pool->answers) > 0)
                                        @foreach($pool->answers as $answer)
                                            <div class="progress">
                                                @php($n = (count($answer->poolres)/$p_res)*100)
                                                <div class="progress-bar" role="progressbar" style="width: 20%" aria-valuenow="{{ number_format($n, 2, '.', ' ') }}"
                                                     aria-valuemin="0" aria-valuemax="100">{{ number_format($n, 2, '.', ' ') }}%</div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="adomx-checkbox-radio-group voting-radio show ">
                                    @if(count($pool->answers) > 0)
                                        <input type="hidden" id="pool_selected" value="">
                                        @foreach($pool->answers as $answer)
                                            <label  class="adomx-radio">
                                                <input data-id="{{ $answer->id }}" type="radio" class="pool-input" name="adomxRadio">
                                                <i class="icon"></i>
                                                {{ $answer->title }}</label>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="d-flex justify-content-center btn-voting">
                                    <span id="polling" >Голосовать</span>
                                </div>
                                <a data-id="{{ $pool->id }}" id="result_pool" style="font-weight: 400;" >Резултаты</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-40">
                        <div class="voting">
                            <div class="title">Голосoвание</div>
                            <div class="content">
                                <p>{{ $pool->title }}</p>
                                <div class="box-body voting-loading hide d-flex justify-content-center align-items-center">
                                    <div class="spinner-border">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div id="pool_res_percent" class="box-body voting-progres hide ">
                                    @if(count($pool->answers) > 0)
                                        @foreach($pool->answers as $answer)
                                            <div class="progress">
                                                @php($n = (count($answer->poolres)/$p_res)*100)
                                                <div class="progress-bar" role="progressbar" style="width: 20%" aria-valuenow="{{ number_format($n, 2, '.', ' ') }}"
                                                     aria-valuemin="0" aria-valuemax="100">{{ number_format($n, 2, '.', ' ') }}%</div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="adomx-checkbox-radio-group voting-radio show ">
                                    @if(count($pool->answers) > 0)
                                        <input type="hidden" id="pool_selected" value="">
                                        @foreach($pool->answers as $answer)
                                            <label  class="adomx-radio">
                                                <input data-id="{{ $answer->id }}" type="radio" class="pool-input" name="adomxRadio">
                                                <i class="icon"></i>
                                                {{ $answer->title }}</label>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="d-flex justify-content-center btn-voting">
                                    <span id="polling" >Голосовать</span>
                                </div>
                                <a data-id="{{ $pool->id }}" id="result_pool" style="font-weight: 400;" >Резултаты</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-40">
                        <div class="voting">
                            <div class="title">Голосoвание</div>
                            <div class="content">
                                <p>{{ $pool->title }}</p>
                                <div class="box-body voting-loading hide d-flex justify-content-center align-items-center">
                                    <div class="spinner-border">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div id="pool_res_percent" class="box-body voting-progres hide ">
                                    @if(count($pool->answers) > 0)
                                        @foreach($pool->answers as $answer)
                                            <div class="progress">
                                                @php($n = (count($answer->poolres)/$p_res)*100)
                                                <div class="progress-bar" role="progressbar" style="width: 20%" aria-valuenow="{{ number_format($n, 2, '.', ' ') }}"
                                                     aria-valuemin="0" aria-valuemax="100">{{ number_format($n, 2, '.', ' ') }}%</div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="adomx-checkbox-radio-group voting-radio show ">
                                    @if(count($pool->answers) > 0)
                                        <input type="hidden" id="pool_selected" value="">
                                        @foreach($pool->answers as $answer)
                                            <label  class="adomx-radio">
                                                <input data-id="{{ $answer->id }}" type="radio" class="pool-input" name="adomxRadio">
                                                <i class="icon"></i>
                                                {{ $answer->title }}</label>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="d-flex justify-content-center btn-voting">
                                    <span id="polling" >Голосовать</span>
                                </div>
                                <a data-id="{{ $pool->id }}" id="result_pool" style="font-weight: 400;" >Резултаты</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-40">
                        <div class="voting">
                            <div class="title">Голосoвание</div>
                            <div class="content">
                                <p>{{ $pool->title }}</p>
                                <div class="box-body voting-loading hide d-flex justify-content-center align-items-center">
                                    <div class="spinner-border">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div id="pool_res_percent" class="box-body voting-progres hide ">
                                    @if(count($pool->answers) > 0)
                                        @foreach($pool->answers as $answer)
                                            <div class="progress">
                                                @php($n = (count($answer->poolres)/$p_res)*100)
                                                <div class="progress-bar" role="progressbar" style="width: 20%" aria-valuenow="{{ number_format($n, 2, '.', ' ') }}"
                                                     aria-valuemin="0" aria-valuemax="100">{{ number_format($n, 2, '.', ' ') }}%</div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="adomx-checkbox-radio-group voting-radio show ">
                                    @if(count($pool->answers) > 0)
                                        <input type="hidden" id="pool_selected" value="">
                                        @foreach($pool->answers as $answer)
                                            <label  class="adomx-radio">
                                                <input data-id="{{ $answer->id }}" type="radio" class="pool-input" name="adomxRadio">
                                                <i class="icon"></i>
                                                {{ $answer->title }}</label>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="d-flex justify-content-center btn-voting">
                                    <span id="polling" >Голосовать</span>
                                </div>
                                <a data-id="{{ $pool->id }}" id="result_pool" style="font-weight: 400;" >Резултаты</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-40">
                        <div class="voting">
                            <div class="title">Голосoвание</div>
                            <div class="content">
                                <p>{{ $pool->title }}</p>
                                <div class="box-body voting-loading hide d-flex justify-content-center align-items-center">
                                    <div class="spinner-border">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div id="pool_res_percent" class="box-body voting-progres hide ">
                                    @if(count($pool->answers) > 0)
                                        @foreach($pool->answers as $answer)
                                            <div class="progress">
                                                @php($n = (count($answer->poolres)/$p_res)*100)
                                                <div class="progress-bar" role="progressbar" style="width: 20%" aria-valuenow="{{ number_format($n, 2, '.', ' ') }}"
                                                     aria-valuemin="0" aria-valuemax="100">{{ number_format($n, 2, '.', ' ') }}%</div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="adomx-checkbox-radio-group voting-radio show ">
                                    @if(count($pool->answers) > 0)
                                        <input type="hidden" id="pool_selected" value="">
                                        @foreach($pool->answers as $answer)
                                            <label  class="adomx-radio">
                                                <input data-id="{{ $answer->id }}" type="radio" class="pool-input" name="adomxRadio">
                                                <i class="icon"></i>
                                                {{ $answer->title }}</label>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="d-flex justify-content-center btn-voting">
                                    <span id="polling" >Голосовать</span>
                                </div>
                                <a data-id="{{ $pool->id }}" id="result_pool" style="font-weight: 400;" >Резултаты</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-40">
                        <div class="voting">
                            <div class="title">Голосoвание</div>
                            <div class="content">
                                <p>{{ $pool->title }}</p>
                                <div class="box-body voting-loading hide d-flex justify-content-center align-items-center">
                                    <div class="spinner-border">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div id="pool_res_percent" class="box-body voting-progres hide ">
                                    @if(count($pool->answers) > 0)
                                        @foreach($pool->answers as $answer)
                                            <div class="progress">
                                                @php($n = (count($answer->poolres)/$p_res)*100)
                                                <div class="progress-bar" role="progressbar" style="width: 20%" aria-valuenow="{{ number_format($n, 2, '.', ' ') }}"
                                                     aria-valuemin="0" aria-valuemax="100">{{ number_format($n, 2, '.', ' ') }}%</div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="adomx-checkbox-radio-group voting-radio show ">
                                    @if(count($pool->answers) > 0)
                                        <input type="hidden" id="pool_selected" value="">
                                        @foreach($pool->answers as $answer)
                                            <label  class="adomx-radio">
                                                <input data-id="{{ $answer->id }}" type="radio" class="pool-input" name="adomxRadio">
                                                <i class="icon"></i>
                                                {{ $answer->title }}</label>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="d-flex justify-content-center btn-voting">
                                    <span id="polling" >Голосовать</span>
                                </div>
                                <a data-id="{{ $pool->id }}" id="result_pool" style="font-weight: 400;" >Резултаты</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-40">
                        <div class="voting">
                            <div class="title">Голосoвание</div>
                            <div class="content">
                                <p>{{ $pool->title }}</p>
                                <div class="box-body voting-loading hide d-flex justify-content-center align-items-center">
                                    <div class="spinner-border">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div id="pool_res_percent" class="box-body voting-progres hide ">
                                    @if(count($pool->answers) > 0)
                                        @foreach($pool->answers as $answer)
                                            <div class="progress">
                                                @php($n = (count($answer->poolres)/$p_res)*100)
                                                <div class="progress-bar" role="progressbar" style="width: 20%" aria-valuenow="{{ number_format($n, 2, '.', ' ') }}"
                                                     aria-valuemin="0" aria-valuemax="100">{{ number_format($n, 2, '.', ' ') }}%</div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="adomx-checkbox-radio-group voting-radio show ">
                                    @if(count($pool->answers) > 0)
                                        <input type="hidden" id="pool_selected" value="">
                                        @foreach($pool->answers as $answer)
                                            <label  class="adomx-radio">
                                                <input data-id="{{ $answer->id }}" type="radio" class="pool-input" name="adomxRadio">
                                                <i class="icon"></i>
                                                {{ $answer->title }}</label>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="d-flex justify-content-center btn-voting">
                                    <span id="polling" >Голосовать</span>
                                </div>
                                <a data-id="{{ $pool->id }}" id="result_pool" style="font-weight: 400;" >Резултаты</a>
                            </div>
                        </div>
                    </div>

--}}
                </div>
            </div>

        </div>

   </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')



@endsection
