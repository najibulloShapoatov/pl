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
            <div class="col-12 col-sm-12 col-lg-auto mb-20 d-flex justify-content-between">
                <div class="page-heading">
                    <h3>@lang('lang.editing')</h3>
                </div>
                <span class="single-elon-header pt-1 pl-20 float-right ">
                    <a href="{{ url('/elon') }}">
                        <span>@lang('lang.all_announcements')</span>
                    </a>
                    @if(Auth::check())
                        <a class="ml-15" href="{{ url('/my-elon') }}">
                            <span>@lang('lang.my_announcements')</span>
                        </a>
                    @endif
                </span>

            </div>
            <div class="col-sm-12 mt-25">
                <div class="col-6">
                    <div class="row mbn-15">
                        <div class="col-12">
                            <div class="error hide"></div>
                        </div>
                        <div class="col-12 mb-15">
                            <select id="edit_elon_cat" class="form-control">
                                <option>@lang('lang.select_a_category')</option>
                                @foreach($elon_cats as $item)
                                    @if($elonData->category_id == $item->id)
                                        <option value="{{ $item->id }}" selected>{{ $item->title }}</option>
                                    @else
                                        <option value="{{ $item->id }}" selected>{{ $item->title }}</option>
                                    @endif

                                @endforeach

                            </select>
                        </div>
                        <div class="col-12 mb-15">
                            <input id="edit_elon_title" type="text" class="form-control" value="{!!  $elonData->title !!}" placeholder="@lang('lang.header')">
                        </div>
                        <div class="col-12 mb-15">
                            <input id="edit_elon_price" type="text" class="form-control" placeholder="@lang('lang.enter_a_price')" value="{!!  $elonData->price !!}">
                        </div>
                        <div class="col-4 elon_img mb-15 p-20">
                            <input
                                type="file"
                                class="dropify-elon-img"
                                id="update-file-elon-img"
                                @if($elonData->image)
                                    data-default-file="/public/uploads/elons/{{ $elonData->id . '/' . $elonData->image }}"
                                @else
                                    data-default-file=""
                                @endif
                                data-allowed-file-extensions="jpeg jpg png "
                                data-max-file-size="5M"/>
                        </div>
                        <div class="col-12 mb-15">
                            <textarea id="edit_elon_descr" class="form-control" placeholder="" >{!!  $elonData->description !!}</textarea>
                        </div>
                        <div class="col-12 mb-15">
                            <input id="edit_elon_phone" type="text" class="form-control" value="{!!  $elonData->phone_no !!}" placeholder="@lang('lang.enter_the_phone_number')">
                        </div>
                        <div class="col-12 mt-20 mb-15 d-flex justify-content-between align-items-center elon-notifications">
                            <span  data-id="{{ $elonData->id }}" id="remove_elon" >@lang('lang.delete_ad')</span>
                            <button data-id="{{ $elonData->id }}" id="update_elon_btn" class="button">@lang('lang.save')</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div><!-- Content Body End -->

    @include('inc.footer')
@endsection


@section('scripts')

    <script src="/public/web_assets/js/plugins/dropify/dropify.min.js"></script>
    <script src="/public/web_assets/js/plugins/dropify/dropify.active.js"></script>
    <script src="/public/web_assets/js/customize_dropify.js"></script>
    <script src="/public/web_assets/js/plugins/nice-select/jquery.nice-select.min.js"></script>
    <script src="/public/web_assets/js/plugins/nice-select/niceSelect.active.js"></script>

@endsection
