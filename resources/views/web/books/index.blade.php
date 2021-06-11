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
        <div class="col-xs-12 col-sm-12 col-md-12 pl-0 pr-0">
            <!-- Page Heading Start -->
            <div class="col-12 col-lg-auto mb-20  pl-0 ">
                <div class="page-heading d-flex ">
                    <h3>@lang('lang.library')</h3>
                    @if(Auth::check() && Auth::user()->role_id == 4 )
                        <span class="my-tests pt-1 pl-20">
                            <a href="{{ url('/add-book') }}">
                                <h5>@lang('lang.add')</h5>
                            </a>
                        </span>
                        <span class="my-tests pt-1 pl-20">
                            <a href="{{ url('/handbook') }}">
                                <h5>@lang('lang.handbook')</h5>
                            </a>
                        </span>
                    @endif
                </div>
            </div><!-- Page Heading End -->
            <form class="d-flex">
                <div class="col-4 mb-15 pl-0">
                    <select id="new_book_cat" class="form-control std">
                       <option>@lang('lang.select_a_category')</option>
                        @if(count($bookCats) > 0)
                            @foreach($bookCats as $item)
                            <option value="{{ $item->id }}" >{{ $item->title }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-4 mb-15">
                    <div class="ml-30">
                        <select  id="new_book_section" class="form-control std">
                        </select>
                    </div>
                </div>
                <div class="col-4 mb-15">
                    <div class="d-flex justify-content-between">
                    <button id="filter_book_btn" class="button button-primary button-outline lib-btn ">
                        <span>Искать</span>
                    </button>
                    <a class="faq-link" href="/faq#Библиотека">
                        <img src="/public/web_assets/images/icons/faq-black.svg" alt="">
                    </a>
                    </div>
                </div>
            </form>
        </div>
        @if(count($data) > 0)
            @php
                $i=1;
            @endphp
            @foreach($data as $cat)
                @php
                if(count($cat['books']) == 0)
                    continue;
                @endphp
                <!--With controls Start-->
                <div class="col-lg-12 col-sm-12 col-xs-12 col-12 mb-30 pl-0 pr-0">
                    <div class="box bg-transparent">
                        <div class="box-head library">
                            <h3 class="title"><a href="{{ url('/book-category/' . $cat->id) }}"> <span>{{ $cat->title }}</span></a></h3>
                        </div>
                        <div class="box-body">
                            <div id="carouselExampleControls{{$i}}" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="row">
                                        @if(count($cat['books']) > 0)
                                            @php
                                                $k=0;
                                                $l=0;
                                            @endphp
                                            @foreach($cat['books'] as $book)

                                            @if($k==0) <div class="carousel-item {{ ($l==0)? 'active' : '' }}"> @endif
                                                <div class="col-sm-3">
                                                    <div data-id="{{$book->id}}" class="em-item bb">
                                                        @if(Auth::check() && Auth::user()->role_id == 4)
                                                            <div class="control-book">
                                                                <div class="wrap d-flex">
                                                                    <a href="{{ url('/edit-book/' . $book->id) }}"><i class="zmdi zmdi-edit"></i></a>
                                                                    <a href="{{ url('/book/' . $book->id) }}"><i class="zmdi zmdi-eye zmdi-hc-fw"></i></a>
                                                                    <a data-id="{{ $book->id }}" id="delete_book"><i class="ti-close"></i></a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="book-cover">
                                                        <img src="/public/uploads/books/{{ $book->id . '/' . $book->image }}" alt="">
                                                        </div>
                                                        <div class="d-flex justify-content-center">
                                                            <a style="margin: 17px 0 21.5px;" href="{{ url('/book/' . $book->id) }}">@lang('lang.view')</a>
                                                        </div>
                                                        <p>{!!  mb_substr($book->title, 0, 27) !!}<br>
                                                            <span>
                                                                @if(count($book->authorList) > 0)
                                                                    @foreach($book->authorList as $author)
                                                                        {{ mb_substr($author->author->name . '.', 0, 17) }}&nbsp;
                                                                        @break
                                                                    @endforeach
                                                                @endif
                                            </span>
                                                        </p>
                                                    </div>
                                                </div>
                                                    @php
                                                        $k +=1;
                                                        $l +=1;
                                                    @endphp
                                                    @if($k==4)
                                                        </div>
                                                        @php
                                                            $k=0;
                                                        @endphp
                                                    @endif
                                            @endforeach


                                            @if(count($cat['books']) > 4 && $k < 4)
                                                @for($j=0; $j <= 3-$k; $j++)
                                                    <div class="col-sm-3">
                                                        <div data-id="{{$cat['books'][$j]->id}}"  class="em-item bb" >
                                                            @if(Auth::check() && Auth::user()->role_id == 4)
                                                                <div class="control-book">
                                                                    <div class="wrap d-flex">
                                                                        <a href="{{ url('/edit-book/' . $cat['books'][$j]->id) }}"><i class="zmdi zmdi-edit"></i></a>
                                                                        <a href="{{ url('/book/' . $cat['books'][$j]->id) }}" ><i class="zmdi zmdi-eye zmdi-hc-fw"></i></a>
                                                                        <a  data-id="{{ $cat['books'][$j]->id }}" id="delete_book" ><i class="ti-close"></i></a>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="book-cover">
                                                                <img src="/public/uploads/books/{{ $cat['books'][$j]->id . '/' . $cat['books'][$j]->image }}" alt="">
                                                            </div>
                                                            <div class="d-flex justify-content-center"><a style="margin: 17px 0 21.5px;" href="{{ url('/book/' . $cat['books'][$j]->id) }}">Посмотреть</a></div>
                                                            <p>{{ mb_substr($cat['books'][$j]->title, 0, 27) }}<br>
                                                                <span>
                                                                    @if(count($cat['books'][$j]->authorList) > 0)
                                                                        @foreach($cat['books'][$j]->authorList as $author)
                                                                            {{ mb_substr($author->author->name . '.', 0, 17) }}&nbsp;
                                                                            @break
                                                                        @endforeach
                                                                    @endif
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endfor
                                                </div>
                                            @endif

                                            @php
                                                $l=0;
                                            @endphp
                                        @endif
                                    </div>
                                </div>
                                @if(count($cat['books']) > 4)
                                    <a class="carousel-control-prev" href="#carouselExampleControls{{$i}}" data-slide="prev">
                                        <div class="pre-slide"><span class="zmdi zmdi-chevron-left zmdi-hc-fw"></span></div>
                                        <span class="sr-only"></span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleControls{{$i}}" data-slide="next">
                                        <div class="nex-slide"><span class="zmdi zmdi-chevron-right zmdi-hc-fw"></span></div>
                                        <span class="sr-only"></span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    $i +=1;
                @endphp
            @endforeach
                    </div>
        @endif
    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')

@endsection
