@php
    use Illuminate\Support\Facades\Auth;
@endphp
@extends('layouts.main')

@section('title')
    ТСПУ им. С. Айни
@endsection
@section('styles')
    <!-- Custom Style CSS Only For Demo Purpose -->
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/style-primary.css">
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/custom.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@endsection


<!-- ################################################################################################### -->


@section('content')
    @include('inc.header')
    @include('inc.side_bar')
    <!-- Content Body Start -->
    <div class="content-body">
        <!-- ---------------------------------------------------------------------------------------------- -->
        <!-- Page Headings Start -->
        <div class="row ">
            <!-- Page Heading Start -->
            <div class="col-12 col-lg-auto mb-20">
                <div class="page-heading appeal-title">
                    <h5 id="ticket_title" data-id="{{ $ticketData['ticket']->id }}">
                        {{ $ticketData['ticket']->title }}
                    </h5>
                </div>
            </div><!-- Page Heading End -->
            <!-- Chat Start -->
            <div class="col-xlg-12 col-lg-12 col-12 col-sm-12 col-xs-12 mb-30">
                <div class="box chat-ob">
                    <div class="box-body">


                        <div class="widget-chat-wra custom-scrol">
                            <ul id="ticket_detail_list" class="widget-appeal-chat-list pl-0 pr-0">
                                @if(count($ticketData['ticket_childs']) > 0)
                                @foreach($ticketData['ticket_childs'] as $item)
                                    <li class="{{ ( $item->user_id == Auth::user()->id )? 'user': 'admin' }}">
                                        <div class="widget-chat {{ ( $item->user_id == Auth::user()->id )? 'your': 'adm' }}">
                                            <div class="body">
                                                <div class="content col-sm-10 ml-0">
                                                    <p>{{ $item->title }}
{{--                                                        <span>{{ date('d.m.Y  g:i', strtotime($item->created_at)) }}</span>--}}
                                                        <span>{{ date_format($item->created_at, 'Y.m.d H:i') }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            @endif
                        </div>

                        <div class="col-lg-12 col-md-12 col-12 col-sm-12 col-xs-12 mt-70 pl-0 pr-0">
                            <div class="box forum-item chatform">
                                <div class="box-body">
                                    <div class="media">
                                        <div class="media-body pl-10">
                                            <div class="box-body">
                                                <textarea id="ticket_add_msg_text" class="form-control ml-5" placeholder="Напишите что нибуд..."></textarea>
                                                <button id="ticket_add_msg_btn" class="button button-outline appeal-btn mb-0 mt-20 std float-right">Опубликовать</button>
                                                <button id="ticket_close_btn" class="button button-outline mt-20 button-danger mr-30 std">
                                                    <span>Закрыть обращение</span>
                                                </button>
                                                <a href="{{ url('/tickets') }}" class="button button-outline mt-20 std-btn std">
                                                    <span>Все обращение</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div><!-- Chat End -->

        </div><!-- Page Headings End -->


    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')
    <script>
        $('#exampleModal5').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) ;// Button that triggered the modal
            var recipient = button.data('whatever') ;// Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.modal-title').text('Открыть обращение ' + recipient);
            modal.find('.modal-body input').val(recipient);
        })
    </script>

    <!-- OWl Carousel -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>

@endsection

