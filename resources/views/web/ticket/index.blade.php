@extends('layouts.main')

@section('title')
    ТСПУ им. С. Айни
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
        <!-- Page Headings Start -->
        <div class="row align-items-center mb-10">

            <!-- Page Heading Start -->
            <div class="col-12 col-lg-auto mb-20">
                <div class="page-heading">
                    <h3>Мои обращение</h3>
                </div>
            </div><!-- Page Heading End -->

        </div><!-- Page Headings End -->

        <div class="row mbn-50">
            <!--Right Sidebar Start-->
            <div class="col-xlg-4 col-12 mb-50">
                <div class="row mbn-30">
                    <div class=" col-sm-12 col-12 mt-20 mb-20 ">
                        <div class="col-sm-12 mal">
                            <button class="button button-primary button-outline std "
                                    data-toggle="modal" data-target="#exampleModal5"
                                    data-whatever="">
                                Открыть обращение</button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal5">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header brbn">
                                        <h5 class="modal-title">Открыть обращение</h5>
                                        <button type="button" class="close p-0" data-dismiss="modal" style="margin-left: 40%;">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body pt-0">
                                        <form>
                                            <div class="form-group">
                                                <input id="new_ticket_title" type="text" class="form-control mb-10 " id="recipient-name" placeholder="Тема">
                                            </div>
                                            <div class="form-group">
                                                <textarea id="new_ticket_content" class="form-control h-200" id="message-text" placeholder="Обращения"></textarea>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer brtn">
                                        <button data-dismiss="modal"  id="add_new_ticket" class="button button-outline std appeal-btn">Открыть</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- To Do List Start -->
                    <div class="col-xlg-12 col-lg-12 col-12 mb-30 appeal">
                        <div class="box">
                            <div class="box-body p-0">

                                <!--Todo List Start-->
                                <ul id="my_tickets_list" class="todo-list appeal-list">
                                    @if(count($myTickets) > 0)
                                        @foreach($myTickets as $item)
                                            <!--Todo Item Start-->
                                                <li class="d-flex justify-content-between align-items-center">
                                                    <div class="appeal-content d-flex">
    {{--                                                    <div class="appeal-status {{ ($item->status == 0)? 'green' : ($item->status == 1)? 'red': 'grey' }} mr-15"></div>--}}
                                                        @if($item->status == 0)
                                                            <div class="appeal-status green  mr-15"></div>
                                                        @elseif($item->status == 1)
                                                            <div class="appeal-status red mr-15"></div>
                                                        @else
                                                            <div class="appeal-status grey mr-15"></div>
                                                        @endif
                                                        <a href="{{url('/tickets/' . $item->id) }}">
                                                            {{ $item->title }}
                                                        </a>
                                                    </div>
                                                    <div class="appeal-time">
                                                        <span> {{ date('d.m.Y', strtotime($item->created_at)) }}</span>
                                                    </div>
                                                </li>
                                                <!--Todo Item End-->
                                        @endforeach
                                    @endif
                                </ul>
                                <!--Todo List End-->

                            </div>
                        </div>

                        <div id="loadTickets"  class=" newsbtn mt-40 mb-20  d-flex justify-content-center align-items-center">
                            <button id="loadMoreTicket" data-page="1" class=" button button-outline button-primary pl-30 pr-30 ">
                                <span>Загрузить ещё</span>
                            </button>
                        </div>
                        <!--Todo List Start-->
                        <ul class="todo-list appeal-list">

                            <!--Todo Item Start-->
                            <li class="d-flex justify-content-between align-items-center">
                                <div class="appeal-content d-flex">
                                    <div class="appeal-status green mr-15"></div>
                                    В ожидание
                                </div>
                            </li>
                            <!--Todo Item End-->
                            <!--Todo Item Start-->
                            <li class="d-flex justify-content-between align-items-center">
                                <div class="appeal-content d-flex">
                                    <div class="appeal-status red mr-15"></div>
                                    Получил ответ
                                </div>
                            </li>
                            <!--Todo Item End-->
                            <!--Todo Item Start-->
                            <li class="d-flex justify-content-between align-items-center">
                                <div class="appeal-content d-flex">
                                    <div class="appeal-status grey mr-15"></div>
                                    Обращение закрыто
                                </div>
                            </li>
                            <!--Todo Item End-->

                        </ul>
                        <!--Todo List End-->
                    </div><!-- To Do List End -->

                </div>
            </div>
            <!--Right Sidebar End-->
        </div>
    </div>
    <!-- Content Body -->
    @include('inc.footer')
@endsection


@section('scripts')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- OWl Carousel -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>

@endsection

