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
                <h3>@lang('lang.manage_community') </h3>
            </div>
            {{--<span class="single-elon-header pt-1 pl-20 ">
                <a href="{{ url('/add-new-news') }}">
                    <span>Добавить</span>
                </a>
            </span>--}}
        </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                @if(count($community) > 0)
                    <div class="">
                        <table class="table table-bordered table-hover m-0">
                            <thead>
                            <tr>
                                <th width="10%">#</th>
                                <th width="12%">@lang('lang.date')</th>
                                <th>@lang('lang.header')</th>
                                <th width="10%">@lang('lang.active')</th>
                                <th class="text-center">@lang('lang.act')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($community as $item)
                                <tr id="adm_table_item_{{ $item->id }}">
                                    <th scope="row">
                                        @if(!empty($item->image))
                                            <img style="border: 1px solid #ccc; height: 50px" src="/public//uploads/communities/{{ $item->id . '/' .$item->image}}" width="75" >
                                        @else
                                            @lang('lang.no_image')
                                        @endif
                                    </th>
                                    <td>{{date_format($item->updated_at, 'Y.m.d  H:i')}}</td>
                                    <td>{!!  mb_substr($item->title, 0,  200) !!}</td>
                                    <td>
                                        <label  data-id="{{ $item->id }}" id="change_comm_active" class="adomx-switch">
                                            <input  id="sts_{{ $item->id }}" type="checkbox" {{ ($item->is_active == 1)? 'checked' : ""}}>
                                            <i class="lever"></i>
                                            <span id="sts_text_{{ $item->id }}" class="text">{{ ($item->is_active == 1)? __('lang.yes') : __('lang.no')}}</span>
                                        </label>
                                    </td>
                                    <td class="text-center adm-table-notification" width="170">
                                        {{--<a href="{{ url('/news-manage/edit/' . $item->id) }}" class="editableIcons mr-10" title="Редактировать">
                                            <span class="ti-pencil"></span>
                                        </a>--}}
                                        <span  data-id="{{ $item->id }}" id="edit_item_comm" class=" edit-item ti-pencil mr-20"></span>
                                        <span data-id="{{ $item->id }}" id="delete_item_comm" class=" remove-item ti-trash"></span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $community->links() !!}
                        <div class="clearfix m-b-20"></div>
                    </div>
                @else
                    <p>@lang('lang.no_data')</p>
                @endif
            </div>
        </div>

        <!-- Modal No Authenticate user-->
        <div class="modal " id="community_edit_modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header brbn">
                        <h5 class="modal-title">@lang('lang.edit_community')</h5>
                        <button type="button" class="close  p-0 " data-dismiss="modal" style="margin-left: 40%;">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body comm-form pt-0" >
                        <div class="form-group">
                            <!--Live Search-->
                            <div class="col-12 mb-10 pl-0 pr-0">
                                <h5 class="sub-title">@lang('lang.moderator')</h5>
                                <div id="edited_mod"></div>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-between">
                            <button data-id="" id="comm_edit_moderator" class="button button-primary std mt-20 mb-20 fz-15 fw-500 pl-25 pr-25 pt-5 pb-5">
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
