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
                <h3>@lang('lang.feedback') </h3>
            </div>
            <span class="single-elon-header pt-1 pl-20 ">
                <a id="show-add-fed-to-modal">
                    <span>@lang('lang.add')</span>
                </a>
            </span>
        </div>
        </div>
        <div class="row">

            <div class="col-12 mb-20">
                <div id="succes_form" class="alert alert-success d-none text-center" role="alert">
                    <strong>@lang('lang.succes')</strong>
                </div>
                <div class="row mbn-20">
                    <div class="col-6 mb-20">
                        <label for="formLayoutUsername3">@lang('lang.admin_mail')</label>
                        <div class="d-flex">
                            <input   type="text" id="formLayoutUsername3" class="form-control form-control-sm admin_mail_text" placeholder="" value="{!!  $adminMail !!}">
                            <button id="update_admin_mail" class="button button-box button-success mb-0 ml-10 h-100"><i class="zmdi zmdi-check"></i></button>
                        </div>
                    </div>
                    <div class="col-6 mb-20">
                        <label for="formLayoutUsername3">@lang('lang.booker_mail')</label>
                        <div class="d-flex">
                            <input   type="text" id="formLayoutUsername3" class="form-control form-control-sm booker_mail_text" placeholder="" value="{!!  $bookerMail !!}">
                            <button id="update_booker_mail" class="button button-box button-success mb-0 ml-10 h-100"><i class="zmdi zmdi-check"></i></button>
                        </div>
                    </div>

                </div>
            </div>


            <div class="col-sm-12">
                @if(count($fed) > 0)
                    <div class="">
                        <table class="table table-bordered table-hover m-0">
                            <thead>
                            <tr>
                                <th width="12%">@lang('lang.date')</th>
                                <th width="20%">@lang('lang.facult')</th>
                                <th width="15%">@lang('lang.position')</th>
                                <th>@lang('lang.fio')</th>
                                <th>@lang('lang.mail')</th>
                                <th class="text-center">@lang('lang.act')</th>
                            </tr>
                            </thead>
                            <tbody id="table-admin-body">
                            @foreach($fed as $item)
                                <tr id="adm_table_item_{{ $item->id }}">

                                    <td>{{date_format($item->created_at, 'Y.m.d  H:i')}}</td>
                                    <td>{!!  mb_substr($item->facultet->title, 0, 60) !!}</td>
                                    <td>{!!  $item->place !!}</td>
                                    <td>{!!  mb_substr($item->name, 0,  200) !!}</td>
                                    <td><a href="mailto:{{ $item->email }}">{{ $item->email }}</a></td>
                                    <td class="text-center adm-table-notification" width="170">
                                        {{--<a href="{{ url('/news-manage/edit/' . $item->id) }}" class="editableIcons mr-10" title="Редактировать">
                                            <span class="ti-pencil"></span>
                                        </a>--}}
                                        <span  data-id="{{ $item->id }}" id="edit_item_fed_to" class=" edit-item ti-pencil mr-20"></span>
                                        <span data-id="{{ $item->id }}" id="delete_item_fed_to" class=" remove-item ti-trash"></span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $fed->links() !!}
                        <div class="clearfix m-b-20"></div>
                    </div>
                @else
                    <p>@lang('lang.no_data')</p>
                @endif
            </div>
        </div>

        <!-- Modal No Authenticate user-->
        <div class="modal " id="ad_new_fed_to_modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header brbn">
                        <h5 class="modal-title">@lang('lang.adding_new_human')</h5>
                        <button type="button" class="close  p-0 " data-dismiss="modal" style="margin-left: 40%;">
                            <span class="ti-close"></span></button>
                    </div>
                    <div class="modal-body comm-form pt-0 pl-20 pr-20" >
                        <div class="form-group">
                            <div class="col-12 mb-10 pl-0 pr-0">
                                <div class="row mbn-15">
                                    <div class="col-12 mb-15">
                                        <div class="mb-10">
                                        <strong >@lang('lang.facult')</strong>
                                        </div>
                                        <select id="faculty-fed-to" class="form-control form-control-sm">
                                            @if(count($fac) > 0)
                                                @foreach($fac as $f)
                                                    <option value="{{ $f->id }}">{!! $f->title !!}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="col-12 mb-15">
                                        <div class="mb-10">
                                        <strong>@lang('lang.position')</strong>
                                        </div>
                                        <input autocomplete="off" id="place-fed-to" type="text" class="form-control form-control-sm" placeholder="">
                                    </div>
                                    <div class="col-12 mb-15">
                                        <div class="mb-10">
                                        <strong>@lang('lang.fio')</strong>
                                        </div>
                                        <input autocomplete="off" id="name-fed-to" type="text" class="form-control form-control-sm" placeholder="">
                                    </div>
                                    <div class="col-12 mb-15">
                                        <div class="mb-10">
                                        <strong>@lang('lang.email')</strong>
                                        </div>
                                        <input autocomplete="off" id="email-fed-to" type="text" class="form-control form-control-sm" placeholder="">
                                    </div>



                                </div>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-between">
                            <button data-id="" id="add-new-fed-to-btn" class="button button-primary std mt-20 mb-20 fz-15 fw-500 pl-25 pr-25 pt-5 pb-5">
                                @lang('lang.save')
                            </button>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal No Authenticate user-->
        <div class="modal " id="edit_fed_to_modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header brbn">
                        <h5 class="modal-title">@lang('lang.editing_human')</h5>
                        <button type="button" class="close  p-0 " data-dismiss="modal" style="margin-left: 40%;">
                            <span class="ti-close"></span></button>
                    </div>
                    <div class="modal-body comm-form pt-0 pl-20 pr-20" >
                        <div id="edit-fed-form">

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
