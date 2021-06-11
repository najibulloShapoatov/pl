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
                <div class="page-heading">
                    <h3>@lang('lang.edit')</h3>
                </div>
            </div>

        </div><!-- Page Headings End -->

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-12 mb-20">

            <div class="row mbn-15">
                <div class="row">


                    <div class="col-12 mb-15">
                        <select id="edited_faq_cat" class="form-control std">
                            <option>@lang('lang.select_a_category')</option>
                            @if(count($faqCats)>0)
                                @foreach($faqCats as $item)
                                    <option  {{ ($item->id == $faq->category_id)? 'selected' : '' }}  value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-12 mb-15">
                        <input id="edited_faq_que" type="text" class="form-control" placeholder="@lang('lang.question')" value="{!! $faq->title !!}">
                    </div>

                    <div class="col-12 mb-15">
                        <textarea id="edited_faq_ans" rows="10" class="form-control" placeholder="@lang('lang.answer')">{!! $faq->description !!}</textarea>
                    </div>
                    <div class="col-12 mb-15">
                        <button data-id="{{ $faq->id }}" id="save_edited_faq" class="button button-success fl-right" style="text-transform: none">@lang('lang.save')</button>
                    </div>


                </div>
            </div>
        </div>
    </div><!-- Content Body End -->




    @include('inc.footer')
@endsection


@section('scripts')
    <!-- Plugins & Activation JS For Only This Page -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

@endsection
