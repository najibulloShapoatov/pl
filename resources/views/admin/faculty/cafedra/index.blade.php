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
                <h3>@lang('lang.manage_cafedra') </h3>
                <h3 class="mt-30" >{!! $fac->title !!} </h3>
            </div>
            <span class="single-elon-header pt-1 pl-20 ">
                <a id="add_new_caf_show_modal">
                    <span>@lang('lang.add')</span>
                </a>
            </span>
        </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                @if(count($fac->cafedra) > 0)
                    <div class="">
                        <table class="table table-bordered table-hover m-0">
                            <thead>
                            <tr>
                                <th width="12%">@lang('lang.date')</th>
                                <th>@lang('lang.header')</th>
                                <th class="text-center">@lang('lang.act')</th>
                            </tr>
                            </thead>
                            <tbody id="facs_tbody">
                            @foreach($fac->cafedra as $item)
                                <tr id="adm_table_item_{{ $item->id }}">

                                    <td>{{date_format($item->updated_at, 'Y.m.d  H:i')}}</td>
                                    <td>{!!  mb_substr($item->title, 0,  200) !!}</td>
                                    <td class="text-center adm-table-notification" width="170">
                                        <input type="hidden" id="title-caf-{{ $item->id }}" value="{!! $item->title !!}">
                                        <span  data-id="{{ $item->id }}" id="edit_item_caf" class=" edit-item ti-pencil mr-10"></span>
                                        <span data-id="{{ $item->id }}" id="delete_item_caf" class=" remove-item ti-trash"></span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                       {{-- {!! $facs->links() !!}--}}
                        <div class="clearfix m-b-20"></div>
                    </div>
                @else
                    <p>@lang('lang.no_data')</p>
                @endif
            </div>
        </div>

        <!-- Modal No Authenticate user-->
        <div class="modal " id="add_new_caf_modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header brbn">
                        <h5 class="modal-title">@lang('lang.add_cafedra')</h5>
                        <button type="button" class="close  p-0 pull-right " data-dismiss="modal" style="padding-right: 5%!important;">
                            <span class="ti-close"></span></button>
                    </div>
                    <div class="modal-body comm-form pt-0" >
                        <div class="row mbn-20">
                            <div class="col-12 mb-20">
                                <label for="cafedra_name">@lang('lang.name_cafedra')</label>
                                <input  type="text" id="cafedra_name" class="form-control" placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-between">
                            <button data-id="{{ $fac->id }}" id="add_new_cafedra" class="button button-primary std mt-20 mb-20 fz-15 pull-right fw-500 pl-25 pr-25 pt-5 pb-5">
                                @lang('lang.save')
                            </button>

                        </div>
                    </div>

                </div>
            </div>
        </div>



        <!-- Modal No Authenticate user-->
        <div class="modal " id="edit_caf_modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header brbn">
                        <h5 class="modal-title">@lang('lang.edit_cafedra')</h5>
                        <button type="button" class="close  p-0 pull-right " data-dismiss="modal" style="padding-right: 5%!important;">
                            <span class="ti-close"></span></button>
                    </div>
                    <div class="modal-body comm-form pt-0" >
                        <div class="row mbn-20">
                            <div class="col-12 mb-20">
                                <label for="facult_name">@lang('lang.add_cafedra')</label>
                                <input  type="text" id="cafedra_name_edit" class="form-control" placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-between">
                            <button data-id="" id="update_cafedra" class="button button-primary std mt-20 mb-20 fz-15 pull-right fw-500 pl-25 pr-25 pt-5 pb-5">
                                @lang('lang.save')
                            </button>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')

    <script src="/public/web_assets/js/plugins/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="/public/web_assets/js/plugins/bootstrap-select/bootstrapSelect.active.js"></script>

@endsection
