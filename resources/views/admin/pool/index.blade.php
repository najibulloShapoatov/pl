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
                <h3>@lang('lang.manage_pooling')</h3>
            </div>
            <span class="single-elon-header pt-1 pl-20 ">
                <a href="{{ url('/pool-add') }}">
                    <span>@lang('lang.add')</span>
                </a>
            </span>
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
                                <th width="15%">@lang('lang.to_main')</th>
                                <th class="text-center">@lang('lang.act')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $item)
                                <tr id="adm_table_item_{{ $item->id }}">
                                    <td>{{date_format($item->created_at, 'Y.m.d  H:i')}}</td>
                                    <td>{!!  mb_substr($item->title, 0,  200) !!}</td>
                                    <td>
                                        <label  data-id="{{ $item->id }}" id="change_pool_active" class="adomx-switch">
                                            <input  id="sts_{{ $item->id }}" type="checkbox" class="input_pool_sts" {{ ($item->is_active == 1)? 'checked' : ""}}>
                                            <i class="lever"></i>
                                            <span id="sts_text_{{ $item->id }}" class="text input_pool_sts_text">{{ ($item->is_active == 1)? __('lang.yes') : __('lang.no')}}</span>
                                        </label>
                                    </td>
                                    <td class="text-center adm-table-notification" width="170">
                                        <a href="{{ url('/pool-edit/' . $item->id) }}" class="editableIcons mr-10" title="@lang('lang.edit')">
                                            <span class="ti-pencil"></span>
                                        </a>
                                        <span data-id="{{ $item->id }}" id="pool_remove_btn" class=" remove-item ti-trash"></span>
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
        </div>
    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')

@endsection
