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
                <h3>@lang('lang.manage_category')</h3>
            </div>
            <span class="single-elon-header pt-1 pl-20 ">
                <a href="{{ url('/elon-manage') }}">
                    <span>@lang('lang.elon')</span>
                </a>
            </span>
        </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                @if(count($elon) > 0)
                    <div class="">
                        <table class="table table-bordered table-hover m-0">
                            <thead>
                            <tr>
                                <th width="15%">@lang('lang.date')</th>
                                <th>@lang('lang.header')</th>
                                <th class="text-center">@lang('lang.act')</th>
                            </tr>
                            </thead>
                            <tbody id="f_c_t_b">
                            @foreach($elon as $item)
                                <tr id="adm_table_item_{{ $item->id }}">
                                    <td>{{date_format($item->updated_at, 'Y.m.d  H:i')}}</td>
                                    <td id="title_{{ $item->id }}">{!! mb_substr($item->title, 0,  200) !!}</td>
                                    <td class="text-center adm-table-notification" width="170">
                                        <span data-id="{{ $item->id }}" id="edit_cat_elon" class=" edit-item ti-pencil mr-10 "></span>
                                        <span data-id="{{ $item->id }}" id="delete_item_elonCat" class=" remove-item  ti-trash"></span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                       {{-- {!! $elon->links() !!}--}}
                        <div class="clearfix m-b-20">
                        <!--Add Todo List Start-->
                        <form  class="todo-list-add-new mt-30" data-date="false">
                            <label class="status todos">
                                <i class="ti-plus"></i>
                            </label>
                            <input id="new_e_c_title" class="content" type="text" placeholder="@lang('lang.add_category')">
                            <button id="add_e_cat_btn" class=" button button-outline button-primary ">
                                <span>@lang('lang.add')</span>
                            </button>
                        </form>
                        <!--Add Todo List End-->

                    </div>
                @else
                    <p>@lang('lang.no_data')</p>
                @endif
            </div>
        </div>
    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')

@endsection
