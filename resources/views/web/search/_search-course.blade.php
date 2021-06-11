
<div class="row">
    <div class="col-sm-12 col-md-12 col-xs-12 col-12 mb-30">
        <div class="box search">
            <div class="box-body">
                <ul class="nav nav-pills mb-15">
                    <input type="hidden" id="search_value" value="{{ $search }}">
                    <li data-id="1" id="search_tab_item" class="nav-item">
                        <a class="nav-link {{ ($id_active == 1)? ' active': ''}}">@lang('lang.news')</a>
                    </li>
                    <li  data-id="2" id="search_tab_item"  class="nav-item">
                        <a class="nav-link {{ ($id_active == 2)? ' active': ''}}" >@lang('lang.library')</a>
                    </li>
                    <li  data-id="3" id="search_tab_item"  class="nav-item">
                        <a class="nav-link{{ ($id_active == 3)? ' active': ''}}">@lang('lang.forum')</a>
                    </li>
                    <li  data-id="4" id="search_tab_item"  class="nav-item">
                        <a class="nav-link{{ ($id_active == 4)? ' active': ''}}" >@lang('lang.community')</a>
                    </li>
                    <li  data-id="5" id="search_tab_item"  class="nav-item">
                        <a class="nav-link{{ ($id_active == 5)? ' active': ''}}" >@lang('lang.elon')</a>
                    </li>
                    <li  data-id="6" id="search_tab_item"  class="nav-item">
                        <a class="nav-link{{ ($id_active == 6)? ' active': ''}}">@lang('lang.videocourses')</a>
                    </li>
                </ul>
                <div class="tab-content pb-30">
                    @if(count($data)>0)
                        @foreach($data as $item)
                            @if($item->is_active == 1)
                                <div class=" search-item ne-item d-flex pt-20 ">
                                    <div class="content pl-0 col-md-12 col-xs-10 col-sm-12 col-lg-auto">
                                        <a href="{{ url('/videocourse/' . $item->id) }}" class="d-flex justify-content-between">
                                            <h5 class="col-10 pl-0">
                                                {!!  $item->title !!}
                                            </h5>
                                            <span class="mb-10 pl-30">
                                                <i class="ti-calendar"></i>
                                                &nbsp;{{ date('d.m.Y', strtotime($item->created_at)) }}
                                            </span>
                                        </a>
                                        <p class="pb-10 col-sm-10 col-md-10 col-xs-12 pl-0">
                                            {!! mb_substr($item->description, 0,  20) !!}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
