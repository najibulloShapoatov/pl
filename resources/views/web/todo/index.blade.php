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
            <div class=" todos    col-xlg-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 mb-30">
                <div class="box">
                    <div class="box-head">
                        <h4 class="title">@lang('lang.todos')</h4>
                    </div>
                    <div class="box-body p-0">


                            <!--Todo List Start-->
                            <ul class="todo-list task">
                                @if(count($tasks) > 0)
                                    @foreach($tasks as $item)
                                        <!--Todo Item Start-->
                                            <li class="task-{{ $item->id }} {{ ($item->status == 1) ? 'done' : ''}}" data-task-id="{{ $item->id }}">
                                                <div class="list-actio">
                                                    <label class="adomx-checkbox js-task-status">
                                                        <input type="checkbox">
                                                        <i class="icon"></i>
                                                    </label>
                                                </div>
                                                <div class="list-content" id="content-{{ $item->id }}">
                                                    <p id="task-text">{{ $item->content }}</p>
                                                </div>
                                                <div class="list-action right">
                                                    <button class="edit-task">
                                                        <i class="ti-pencil"></i>
                                                    </button>
                                                    <button class="remove">
                                                        <i class="ti-trash"></i>
                                                    </button>
                                                </div>
                                            </li>
                                            <!--Todo Item End-->
                                    @endforeach
                                @endif
                            </ul>
                            <!--Todo List End-->

                        <!--Add Todo List Start-->
                        <form action="#" class="todo-list-add-new" data-date="false">
                            <label class="status todos">
                                <i class="ti-plus"></i>
                            </label>
                            <input class="content" type="text" placeholder="@lang('lang.ad_todo')">
                            <button class="todos button button-outline button-primary ">
                                <span>@lang('lang.add')</span>
                            </button>
                        </form>
                        <!--Add Todo List End-->

                    </div>
                </div>
            </div>
        </div>
    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')

    <!-- OWl Carousel -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>

    @endsection
