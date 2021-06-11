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
                <h3>Обращение</h3>
            </div>
            <span class="single-elon-header pt-1 pl-20 ">
                <a href="{{ url('/fedback-to') }}">
                    <span>Обрашаемые</span>
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
                                <th width="10%">Дата</th>
                                <th width="15%">Кому</th>
                                <th width="15%">Тема</th>
                                <th>Текст</th>
                                <th width="10%" class="text-center">Действие</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $item)
                                <tr class="{{ ($item->sts == 0)? 'sts_0': 'sts_1' }}" id="adm_table_item_{{ $item->id }}">
                                    <td>{{date_format($item->created_at, 'Y.m.d  H:i')}}</td>
                                    <td>{{ mb_substr($item->to_whom, 0,  200) }}</td>
                                    <td>{{ mb_substr($item->topic, 0,  200) }}</td>
                                    <td>{!!  mb_substr($item->text, 0,  200) !!}</td>

                                    <td class="text-center adm-table-notification" width="170">
                                        <a href="{{ url('/about-manage/' . $item->id) }}" class="editableIcons mr-10" >
                                            <span class="ti-eye"></span>
                                        </a>
                                        <span data-id="{{ $item->id }}" id="delete_items_about" class="ti-trash"></span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $data->links() !!}
                        <div class="clearfix m-b-20"></div>
                    </div>
                @else
                    <p>Нет данных.</p>
                @endif
            </div>
        </div>
    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')

@endsection
