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
                <div class="page-heading d-flex">
                    <h3>@lang('lang.write_to_everyone')</h3>
                </div>
                    <span id="notice-create" class="single-elon-header pt-1 pl-20 ">
                    <a {{--href="{{ url('/forum-manage/category') }}"--}}>
                        <span>@lang('lang.write')</span>
                    </a>
                </span>
            </div>
            <div class="col-6 mb-15 d-flex justify-content-between">
                <select id="notice_role" class="form-control form-control-sm">
                    <option value="0">@lang('lang.all')</option>
                    @if(count($roles) > 0)
                        @foreach($roles as $item)
                            <option value="{{ $item->id }}">{{ $item->role }}</option>
                        @endforeach
                    @endif
                </select>
                <button id="filter_notice" class="button button-primary ml-30 mt-0 mb-0 std">@lang('lang.give_up')</button>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                @if(count($notices) > 0)
                    <div class="">
                        <table class="table table-bordered table-hover m-0">
                            <thead>
                            <tr>
                                <th width="15%">@lang('lang.date')</th>
                                <th>@lang('lang.header')</th>
                                <th width="15%">@lang('lang.to_who')</th>
                                <th class="text-center">@lang('lang.act')</th>
                            </tr>
                            </thead>
                            <tbody id="notice_table">
                            @foreach($notices as $item)
                                <tr id="adm_table_item_{{ $item->id }}">

                                    <td>{{date_format($item->created_at, 'Y.m.d  H:i')}}</td>

                                    <td>{!!  mb_substr($item->title, 0,  200) !!}</td>

                                    <td class="text-center">{{ ($item->who_can_see == 0)? 'Все': $item->role['role'] }}</td>
                                    <td class="text-center adm-table-notification" width="170">
                                        <span data-id="{{ $item->id }}" id="view_notice" class=" edit-item ti-eye mr-15"></span>
                                        <span data-id="{{ $item->id }}" id="edit_notice" class=" edit-item ti-pencil mr-15"></span>
                                        <span data-id="{{ $item->id }}" id="delete_notice" class=" remove-item ti-trash"></span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{--{!! $forum->links() !!}--}}
                        <div class="clearfix m-b-20"></div>
                    </div>
                @else
                    <p>@lang('lang.no_data')</p>
                @endif
            </div>
        </div>


    <!-- Modal -->
        <div class="modal {{--fade--}}" id="notice-modal">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('lang.notice')</h4>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body p-20 pl-30 pr-30">
                        <h5></h5>
                        <p></p>
                    </div>
                    {{-- <div class="modal-footer">
                         <button class="button button-danger" data-dismiss="modal">Close</button>
                         <button class="button button-primary">Save changes</button>
                     </div>--}}
                </div>
            </div>
        </div>


    <!-- Modal -->
        <div class="modal {{--fade--}}" id="notice-create-modal">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('lang.write')</h4>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body p-20 pl-30 pr-30">
                        <div id="error" class="alert alert-danger d-none" role="alert">
                        </div>
                        <div class="row mbn-15">

                            <div class="col-12 mb-15">
                                <input id="notice_title" type="text" class="form-control form-control-sm" placeholder="@lang('lang.header')"></div>
                            <div class="col-12 mb-15">
                                <select id="notice_who" class="form-control form-control-sm">
                                    <option value="0">@lang('lang.all')</option>
                                    @if(count($roles) > 0)
                                        @foreach($roles as $item)
                                            <option value="{{ $item->id }}">{{ $item->role }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-12 mb-15">
                                <textarea id="notice_text" class="form-control"  placeholder="@lang('lang.text')"></textarea>
                            </div>
                        </div>
                    </div>
                     <div class="modal-footer">
                         <button id="send_notice" class="button button-primary mt-20">@lang('lang.send')</button>
                     </div>
                </div>
            </div>
        </div>






        <!-- Modal -->
        <div class="modal {{--fade--}}" id="notice-edit-modal">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('lang.write')</h4>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body p-20 pl-30 pr-30">
                        <div id="error" class="alert alert-danger d-none" role="alert">
                        </div>
                        <div class="row mbn-15">

                            <div class="col-12 mb-15">
                                <input id="notice_u_title" type="text" class="form-control form-control-sm" placeholder="@lang('lang.header')"></div>
                            <div class="col-12 mb-15">
                                <select id="notice_u_who" class="form-control form-control-sm">
                                    <option value="0">@lang('lang.all')</option>
                                    @if(count($roles) > 0)
                                        @foreach($roles as $item)
                                            <option value="{{ $item->id }}">{{ $item->role }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-12 mb-15">
                                <textarea id="notice_u_text" class="form-control"  placeholder="@lang('lang.text')"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button data-id="" id="update_notice" class="button button-primary mt-20">@lang('lang.save')</button>
                    </div>
                </div>
            </div>
        </div>



    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')

@endsection
