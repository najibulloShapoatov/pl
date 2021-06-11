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
                    <h3>@lang('lang.manage_comments') </h3>
                </div>

            </div>
            <div class="question-item mb-20">
                <h5>@lang('lang.new_comments')</h5>
                <div class=" adomx-checkbox-radio-group">
                    <label class="adomx-radio com_rad">
                        <input {{ ($isModerable == '0')? 'checked':'' }} data-id="0" class="pt-20 radioAnswer c-moderable" type="radio"  name="f-rad">
                        <i class="icon"></i> <span>@lang('lang.with_moderable')</span>
                    </label>
                    <label class="adomx-radio com_rad">
                        <input {{ ($isModerable == '1')? 'checked':'' }} data-id="1" class="pt-20 radioAnswer c-moderable" type="radio" name="f-rad">
                        <i class="icon"></i> <span>@lang('lang.without_moderable')</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                @if(count($coments) > 0)
                    <div class="">
                        <table class="table table-bordered table-hover m-0">
                            <thead>
                            <tr>
                                <th width="10%">@lang('lang.date')</th>
                                <th >@lang('lang.header')</th>
                                <th width="15%">@lang('lang.active')</th>
                                <th class="text-center">@lang('lang.act')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($coments as $item)
                                    <tr id="adm_table_item_{{ $item->id }}">
                                        <td>{{date_format($item->created_at, 'Y.m.d  H:i')}}</td>
                                        <td>
                                            {!!  mb_substr($item->text, 0, 100) !!}
                                        </td>
                                        <td>
                                            <label  data-id="{{ $item->id }}" id="change_comment_active" class="adomx-switch">
                                                <input  id="sts_{{ $item->id }}" type="checkbox" {{ ($item->is_active == 1)? 'checked' : ""}}>
                                                <i class="lever"></i>
                                                <span id="sts_text_{{ $item->id }}" class="text">{{ ($item->is_active == 1)? 'Да' : 'Нет'}}</span>
                                            </label>
                                        </td>
                                        <td style="vertical-align: middle" class="text-center adm-table-notification" width="170">
                                            {{--<a href="{{ url('/') }}" class="editableIcons mr-5" title="Редактировать">
                                                <span class="ti-pencil"></span>
                                            </a>--}}
                                            <span data-id="{{ $item->id }}" id="view_comment" class="ti-eye mr-10 edit-item"></span>
                                            <span data-id="{{ $item->id }}" id="delete_comment" class="ti-trash remove-item"></span>
                                        </td>
                                    </tr>
                            @endforeach
                            </tbody>
                        </table>
                       {!! $coments->links() !!}
                        <div class="clearfix m-b-20"></div>
                    </div>

                    <!-- Modal -->
                    <div class="modal {{--fade--}}" id="comment-modal">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">@lang('lang.comment')</h4>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span class="ti-close"></span>
                                    </button>
                                </div>
                                <div class="modal-body p-20 pl-30 pr-30">
                                    <p></p>
                                </div>
                                {{-- <div class="modal-footer">
                                     <button class="button button-danger" data-dismiss="modal">Close</button>
                                     <button class="button button-primary">Save changes</button>
                                 </div>--}}
                            </div>
                        </div>
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
