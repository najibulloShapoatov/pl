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
        <div class="col-12 col-sm-12 col-lg-auto mb-20 d-flex justify-content-between ">
            <div class="page-heading">
                <h3 data-id="{{ $dataCat->id }}" id="book_cat">{{ $dataCat->title }}</h3>
            </div>
        </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                @if(count($data) > 0)
                    <div class="">
                        <table class="table table-bordered table-hover m-0">
                            <thead>
                            <tr>
                                <th width="15%">@lang('lang.date')</th>
                                <th>@lang('lang.header')</th>
                                <th width="15%">@lang('lang.active')</th>
                                <th class="text-center">@lang('lang.act')</th>
                            </tr>
                            </thead>
                            <tbody id="f_c_t_b">
                            @foreach($data as $item)
                                <tr id="adm_table_item_{{ $item->id }}">
                                    <td>{{date_format($item->updated_at, 'Y.m.d  H:i')}}</td>
                                    <td id="title_{{ $item->id }}">{{ mb_substr($item->title, 0,  200) }}</td>
                                    <td>
                                        <label  data-id="{{ $item->id }}" id="change_bookC_active" class="adomx-switch">
                                            <input  id="sts_{{ $item->id }}" type="checkbox" {{ ($item->is_active == 1)? 'checked' : ""}}>
                                            <i class="lever"></i>
                                            <span id="sts_text_{{ $item->id }}" class="text">{{ ($item->is_active == 1)? __('lang.yes') : __('lang.no')}}</span>
                                        </label>
                                    </td>
                                    <td class="text-center adm-table-notification" width="170">
{{--                                        <a href="{{ url('/manage-book/category/' . $item->id) }}"> <span class=" edit-item ti-menu mr-10 "></span></a>--}}
                                        <span data-id="{{ $item->id }}" id="edit_cat_bCat" class=" edit-item ti-pencil mr-10 "></span>
                                        <span data-id="{{ $item->id }}" id="delete_item_bCat" class=" remove-item  ti-trash"></span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $data->links() !!}
                        <div class="clearfix m-b-20"></div>

                    </div>
                @else
                    <p>@lang('lang.no_data')</p>
                @endif
            </div>
            <!--Add Todo List Start-->
            <form  class="todo-list-add-new mt-30" data-date="false">
                <label class="status todos">
                    <i class="ti-plus"></i>
                </label>
                <input id="add_pcategory_book_text" class="content" type="text" placeholder="@lang('lang.add_category')">
                <button id="add_pcategory_book_btn" class=" button button-outline button-primary ">
                    <span>@lang('lang.add')</span>
                </button>
            </form>
            <!--Add Todo List End-->
        </div>
    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')

@endsection
