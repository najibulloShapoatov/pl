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
                    <h3>@lang('lang.authors')</h3>
                    <span class="single-elon-header fl-right pt-1 pl-20 ">
                    <a href="{{ url('/book-author-add') }}">
                        <span>@lang('lang.add')</span>
                    </a>
                </span>
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
                                <th class="text-center" width="15%">#</th>
                                <th width="15%">@lang('lang.date')</th>
                                <th>@lang('lang.header')</th>
                                <th class="text-center">Действие</th>
                            </tr>
                            </thead>
                            <tbody id="f_c_t_b">
                            @foreach($data as $item)
                                <tr id="adm_table_item_{{ $item->id }}">
                                    @if($item->image)
                                    <td class="d-flex justify-content-center">
                                        <img width="70px" height="60px"  src="/public/uploads/books/authors/{{ $item->id . '/' . $item->image }}" alt="">
                                    </td>
                                    @else
                                        <td>@lang('lang.no_image')</td>
                                    @endif
                                    <td>{{date_format($item->created_at, 'Y.m.d  H:i')}}</td>
                                    <td id="title_{{ $item->id }}">{{ mb_substr($item->name, 0,  200) }}</td>
                                    <td class="text-center adm-table-notification" width="170">
                                        <a href="{{ url('/book-author/' . $item->id) }}">
                                            <span  class=" edit-item ti-pencil mr-10 "></span>
                                        </a>
                                        <span data-id="{{ $item->id }}" id="delete_item_bAuthor" class=" remove-item  ti-trash"></span>
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
