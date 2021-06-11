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
                <h3>@lang('manage')</h3>
            </div>
        </div>
        </div>
        <div class="row">
           <div class="col-12">
               <div class="col-12 mb-10 pl-0">
                <a href="{{ url('/forum-manage/category') }}" class="forum-link">@lang('lang.categries')</a>
               </div>
               <div class="col-12 mb-10 pl-0">
               <a href="{{ url('/forum-manage/forums') }}" class="forum-link">@lang('lang.forums')</a>
               </div>
               <div class="question-item mt-50">
                   <h5>@lang('lang.create_new_topic')</h5>
                   <div class=" adomx-checkbox-radio-group">
                       <label class="adomx-radio forum_rad">
                           <input {{ ($isModerable == '0')? 'checked':'' }} data-id="0" class="pt-20 radioAnswer f-moderable" type="radio"  name="f-rad">
                           <i class="icon"></i> <span>@lang('lang.with_moderation')</span>
                       </label>
                       <label class="adomx-radio forum_rad">
                           <input {{ ($isModerable == '1')? 'checked':'' }} data-id="1" class="pt-20 radioAnswer f-moderable" type="radio" name="f-rad">
                           <i class="icon"></i> <span>@lang('lang.without_moderation')</span>
                       </label>
                   </div>
               </div>
               <div class="question-item mt-50">
                   <h5>@lang('lang.who_has_access_to_create_a_topic'):</h5>
                   <div class=" adomx-checkbox-radio-group">
                       @if(count($roles))
                           @foreach($roles as $item)
                               @php
                               $isPermited = false;
                                foreach ($f_perms as $per){
                                    if($per->role_id == $item->id && $per->sts == 1){ $isPermited = true; break;}
                                }
                               @endphp
                                <label class="adomx-checkbox">
                                    <input {{ ($isPermited)? 'checked' : '' }}  data-id="{{ $item->id }}" class="permission_forum" type="checkbox"> <i class="icon"></i>
                                   {{ $item->role }}
                                </label>
                           @endforeach
                       @endif
                   </div>
               </div>
           </div>
        </div>
    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')

@endsection
