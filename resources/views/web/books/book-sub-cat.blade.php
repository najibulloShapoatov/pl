@extends('layouts.main')

@section('title')
    @lang('lang.title')
@endsection
@section('styles')
    <!-- Custom Style CSS Only For Demo Purpose -->
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/style-primary.css">
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/custom.css">
@endsection




@section('content')
    @include('inc.header')
    @include('inc.side_bar')

    <!-- Content Body Start -->
    <div class="content-body">
        <div class="col-xs-12 col-sm-12 col-md-12 pl-0 pr-0">
            <!-- Page Heading Start -->
            <div class="col-12 col-lg-auto mb-20  ">
                <div class="page-heading d-flex ">
                    <h3>{{ $sub_cat->title }}</h3>
                    @if(Auth::check() && Auth::user()->role->id == 4 )
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
                <div class="col-4 mb-15 ml-40">
                    <select  id="new_book_section" class="form-control std">
                    </select>
                </div>
                <div class="col-4 mb-15 ml-40">
                    <button id="filter_book_btn" class="button button-primary button-outline lib-btn">
                        <span>@lang('lang.search')</span>
                    </button>
                </div>

            </form>
        </div>
        <!-- E_Materials -->
        <div class="row ">
            <div class="col-sm-12 ">
                <!-- Page Heading Start -->
                <div class="col-12 col-lg-auto mb-10 mt-25 genre">
                    <div class="page-heading">
                    </div>
                    <div class="mt-20">
                        @if(count($sub_cats) > 0)
                            @foreach($sub_cats as $item)
                                <span class=" lib-category  {{ ($item->id == $id_active)? 'active':'' }} mr-15"><a href="{{ url('/book-sub-category/' . $item->id) }}">{{ $item->title }}</a></span>
                            @endforeach
                        @endif
                    </div>
                </div><!-- Page Heading End -->
            </div>
        </div><!-- Page Headings End -->

        <div class="row e-mats">
            <div class="col-sm-12 pl-10 ematt">

                @if(count($books) > 0)
                    @foreach($books as $item)
                    <div class="emat-item">
                        <div class="image col-sm-10 col-md-3 ">
                            @if(Auth::check() && Auth::user()->role_id == 4)
                                <div class="control-book">
                                    <div class="wrap d-flex">
                                        <a href="{{ url('/edit-book/' . $item->id) }}"><i class="zmdi zmdi-edit"></i></a>
                                        <a href="{{ url('/book/' . $item->id) }}"><i class="zmdi zmdi-eye zmdi-hc-fw"></i></a>
                                        <a data-id="{{ $item->id }}" id="delete_book"><i class="ti-close"></i></a>
                                    </div>
                                </div>
                            @endif
                            @if(!empty($item->image))
                                <img class="cove" src="/public/uploads/books/{{ $item->id }}/{{$item->image}}" alt="{{ $item->title }}">
                            @else
                                <img class="cove" src="/public/web_assets/images/e-mat/steve_jobs.jpg" alt="no-image">
                            @endif
                        </div>
                        <div class="content">
                            <span class="title">{!! $item->title !!}</span><br>
                            <span class="autor">
                                @if(count($item->authorList) > 0)
                                    @foreach($item->authorList as $author)
                                        {{ $author->author->name . '.' }}&nbsp;
                                    @endforeach
                                @endif
                            </span>
                            <!--Score Start-->
                            <div class="box rating">
                                <div class="box-body">

                                    @php
                                    $rate = 0;
                                    foreach ($item->rating as $rt){$rate += $rt->point;}
                                    @endphp
                                    <input data-id="{{ count($item->rating) }}" type="hidden" name="rate[]" value="{!! $rate !!}">
                                    <div class="rating rating-read-only2"></div>
                                </div>

                            </div>

                            <!--Score End-->
                            <span class="golos">{{ count($item->rating) }} @lang('lang.ratings')</span>
                            <p>
                                {{ mb_substr($item->description, 0, 250) }}
                            </p>
                            <a href="{{ url('/book/' . $item->id ) }}">
                                <span class="sbg-btn badge badge-pill badge-primary">@lang('lang.detail')</span>
                            </a>

                        </div>
                    </div>
                    @endforeach
                    {{ $books->links() }}
                @endif

            </div>
        </div><!-- E_materials End -->

      {{--  <div class="col-lg-12 col-md-12 col-12 mb-30 paginat">
            <div class="box">
                <div class="box-body d-flex justify-content-center">
                    <ul class="pagination justify-content-center">
                        <li class="page-item"><a class="page-link" href="#"><i class="zmdi zmdi-chevron-left"></i></a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">...</a></li>
                        <li class="page-item"><a class="page-link" href="#">17</a></li>
                        <li class="page-item"><a class="page-link" href="#"><i class="zmdi zmdi-chevron-right"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
--}}
    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')

    <!-- OWl Carousel -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>

    <!-- Plugins & Activation JS For Only This Page -->
    <script src="/public/web_assets/js/plugins/plyr/plyr.min.js"></script>
    <script src="/public/web_assets/js/plugins/plyr/plyr.active.js"></script>
    <!-- Plugins & Activation JS For Only This Page -->
    <script src="/public/web_assets/js/plugins/raty/jquery.raty.js"></script>
    <script src="/public/web_assets/js/plugins/raty/raty.active.js"></script>
    <script !src="">
        (function ($) {
            "use strict";
            var rate = $('input[name^=rate]').map(function(idx, elem) {
                return $(elem).val();
            }).get();
            var count_rate = $('input[name^=rate]').map(function(idx, elem) {
                return $(elem).attr('data-id');
            }).get();

            $('.rating-read-only2').each( function(i) {
                if( $( this ).length ) {
                    $( this ).raty({
                        readOnly: true,
                        score: rate[i]/count_rate[i],
                        hints:       ['', '', '', '', '']
                    });}
            });

        })(jQuery);
    </script>
@endsection
