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
        <!-- ---------------------------------------------------------------------------------------------- -->
        <!-- Page Headings Start -->
        <div class="row ">
            <!-- Page Heading Start -->
            <div class="col-12 col-lg-auto mb-20">
                <div class="page-heading d-flex">
                        <h3>@lang('lang.faq')&nbsp;&nbsp;</h3>

                    @if(Auth::check() && Auth::user()->role_id == 1)
                        <span class="my-tests pt-1 pl-20">
                                <a href="{{ url('/faq-manage') }}">
                                    <h5>@lang('lang.manage')</h5>
                                </a>
                            </span>
                    @endif
                </div>
            </div><!-- Page Heading End -->

            <!-- Page Button Group Start -->
            <!-- <div class="col-12 col-lg-auto mb-20">
                <div class="page-date-range">
                    <input type="text" class="form-control input-date-predefined">
                </div>
            </div> -->
            <!-- Page Button Group End -->

        </div><!-- Page Headings End -->
        @if(count($faqCat)>0)
            @php
                $i=0;
                $j=0;
            @endphp
            @foreach($faqCat as $category)
                <!--Accordion With Icon Start-->
                <div id="{{ $category->title }}">
                    <div class=" col-12 pl-0 pr-0 {{($i==0)? '': 'pt-90'}}">

                        <div class="box-head">
                            <h4 class="title" style="color: #4285F4">{{ $category->title }}</h4>
                        </div>
                        <!--Accordion Start-->
                        <div class="accordion accordion-icon" id="accordionExample{{ $i }}">
                            @if(count($category->faqs)>0)
                                @foreach($category->faqs as $item)




                                    <!--Card Start-->
                                        <div class="card faq-item">

                                            <!--Card Header Start-->
                                            <div class="card-header">
                                                <h2><button class="collapsed" data-toggle="collapse" data-target="#collapse{{ $j }}">{{ $item->title }}</button></h2>
                                            </div>
                                            <!--Card Header End-->

                                            <!--Collapse Start-->
                                            <div id="collapse{{ $j }}"  class="collapse" data-parent="#accordionExample{{ $i }}">
                                                <div class="card-body">
                                                    <p>{{ $item->description }}</p>
                                                </div>
                                            </div>
                                            <!--Collapse End-->

                                        </div>
                                        <!--Card End-->
                                    @php($j += 1)
                                @endforeach
                            @endif


                        </div>

                </div>
                <!--Accordion With Icon End-->
                    @php($i +=1)

                </div>

                @endforeach
        @endif
    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')

    <!-- OWl Carousel -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>

    @endsection
