@extends('layouts.main')

@section('title')
    @lang('lang.title')

@endsection
@section('styles')
    <!-- Custom Style CSS Only For Demo Purpose -->
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/style-primary.css">
    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/custom.css">

    <link id="cus-style" rel="stylesheet" href="/public/web_assets/css/croppie.css">

@endsection





@section('content')
    @include('inc.header')
    @include('inc.side_bar')
    <!-- Content Body Start -->
    <div class="content-body">
        <!-- Page Headings Start -->
        <div class="row align-items-center mb-10">

            <!-- Page Heading Start -->
            <div class="col-12 col-lg-auto mb-20">
                <div class="page-heading">
                    <h3>@lang('lang.profile2')</h3>
                </div>
            </div><!-- Page Heading End -->

        </div><!-- Page Headings End -->

        <div class="row mbn-50">

            <!--Author Top Start-->
            <div class="col-12 mb-50">
                <div class="author-top">
                    <div class="inner">
                        <div class="author-profile">
                            <div class="image" >
                                <div id="user_avatar">
                                    @if($userData->image)
                                        <img src="{{ '/public/uploads/users/' .  str_replace('@tspu.tj', '', $userData->email)  . '/avatar/' . $userData->image }}"  alt="">

                                    @else
                                        <h2>{{ mb_substr($userData->name, 0, 2) }}</h2>
                                    @endif
                                </div>
                                <button data-toggle="modal" data-target="#exampleModalIMG"
                                        data-whatever=""  id="updateImage" class="edit">@lang('lang.change')</button>
                            </div>
                            <div class="info">
                                <h5>{{ $userData->name }}</h5>
{{--                                <a href="#" class="edit"><i class="zmdi zmdi-edit"></i></a>--}}
                                <span> {{ $userData->role->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Author Top End-->
            <!-- modal-->
            <div class="modal fade" id="exampleModalIMG">
                <div class="modal-dialog modal-xl modal-dialog-centered ">
                    <div class="modal-content">
                        <div class="modal-header brbn">
                            <h5 class="modal-title">@lang('lang.change_photo')</h5>
                            <button type="button" class="close  p-0 " data-dismiss="modal" style="margin-left: 50%;">
                                <span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body pt-0">
                            <div class="con">
                                <div class="form-group">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6" >
                                            <div id="image-preview"></div>
                                        </div>
                                        <div class="col-md-6" style=" padding-left: 50px;padding-top: 10%;">
                                            <p>
                                                <label for="upload_image" class="btn button-primary button-outline">
                                                   @lang('lang.choise_photo')
                                                </label>
                                                <input name="upload_image" id="upload_image" style="visibility:hidden;" type="file">
                                            </p>
                                            <div id="file_name_avatar">
                                            <label></label>
                                            </div>
                                            <br />
                                            <br />
                                            <button id="crop_save_ava" data-dismiss="modal" class="btn btn-success crop_image d-none">
                                                @lang('lang.crop_and_save')
                                            </button>
                                        </div>
{{--                                                <div class="col-md-4" style="padding:75px;background-color: #333">--}}
{{--                                                    <div id="uploaded_image" align="center"></div>--}}
{{--                                                </div>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <!--Right Sidebar Start-->
            <div class="col-12 mb-50">
                <div class="row mbn-30">

                    <!--Author Information Start-->
                    <div class="col-xlg-6 col-lg-6 col-12 mb-30 autor-information">
                        <div class="box">
                            <div class="box-head">
                                <h3 class="title">@lang('lang.personal_data')</h3>
                            </div>




                            @if(Auth::user()->role_id == 3 && $usrProps != null)
                                <div class="box-body">
                                    <form>
                                        <div class="row mbn-20">
                                            @foreach($usrProps as $p)
                                                @if($p->prop_key == 'RecordBookNumber')
                                                    <div class="col-12 mb-20">
                                                        <label for="formLayoutUsername3">@lang('lang.record_book_number')</label>
                                                        <input readonly  type="text" id="formLayoutUsername3" class="form-control"  value="{!!  $p->prop_value !!}">
                                                    </div>
                                                    @continue
                                                @endif
                                                @if($p->prop_key == 'FullName_TJ')
                                                    <div class="col-12 mb-20">
                                                        <label for="formLayoutEmail3">@lang('lang.fio')</label>
                                                        <input readonly  type="text" id="formLayoutEmail3" class="form-control" value="{!!  $p->prop_value !!}">
                                                    </div>
                                                    @continue
                                                @endif
                                                @if($p->prop_key == 'Faculty_TJ')
                                                    <div class="col-12 mb-20">
                                                        <label for="formLayoutPassword3">@lang('lang.facult')</label>
                                                        <input readonly type="text" id="formLayoutPassword3" class="form-control" value="{!!  $p->prop_value !!}">
                                                    </div>
                                                    @continue
                                                @endif
                                                @if($p->prop_key == 'Specialty_TJ')
                                            <div class="col-12 mb-20">
                                                <label for="formLayoutAddress1">@lang('lang.speciality')</label>
                                                <input readonly  type="text" id="formLayoutAddress1" class="form-control" value="{!!  $p->prop_value !!}">
                                            </div>
                                                @continue
                                            @endif
                                            @if($p->prop_key == 'CodeSpecialty')
                                                <div class="col-12 mb-20">
                                                    <label for="formLayoutAddress2">@lang('lang.code_speciality')</label>
                                                    <input readonly  type="text" id="formLayoutAddress2" class="form-control"  value="{!!  $p->prop_value !!}">
                                                </div>
                                                @continue
                                            @endif
                                            @if($p->prop_key == 'TrainingForm')
                                            <div class="col-12 mb-20">
                                                <label for="formLayoutAddress2">@lang('lang.trainning_form')</label>
                                                <input  readonly  type="text" id="formLayoutAddress2" class="form-control"  value="{!!  $p->prop_value !!}">
                                            </div>
                                                @continue
                                            @endif
                                            @if($p->prop_key == 'TrainingLevel')
                                            <div class="col-12 mb-20">
                                                <label for="formLayoutAddress2">@lang('lang.trainning_level')</label>
                                                <input readonly  type="text" id="formLayoutAddress2" class="form-control" value="{!!  $p->prop_value !!}">
                                            </div>
                                                @continue
                                            @endif
                                            @if($p->prop_key == 'Course')
                                            <div class="col-12 mb-20">
                                                <label for="formLayoutAddress2">@lang('lang.course')</label>
                                                <input readonly type="text" id="formLayoutAddress2" class="form-control" value="{!!  $p->prop_value !!}">
                                            </div>
                                                @continue
                                            @endif
                                            @if($p->prop_key == 'Group')
                                            <div class="col-12 mb-20">
                                                <label for="formLayoutAddress2">@lang('lang.group')</label>
                                                <input readonly type="text" id="formLayoutAddress2" class="form-control"  value="{!!  $p->prop_value !!}">
                                            </div>
                                                @continue
                                            @endif
                                            @if($p->prop_key == 'YearUniversityEntrance')
                                            <div class="col-12 mb-20">
                                                <label for="formLayoutAddress2">@lang('lang.year_university_entrance')</label>
                                                <input readonly type="text" id="formLayoutAddress2" class="form-control" value="{!!  $p->prop_value !!}">
                                            </div>
                                                @continue
                                            @endif
                                            @if($p->prop_key == 'TrainingPeriod')
                                            <div class="col-12 mb-20">
                                                <label for="formLayoutAddress2">@lang('lang.trainning_period')</label>
                                                <input readonly type="text" id="formLayoutAddress2" class="form-control"  value="{!!  $p->prop_value !!}">
                                            </div>
                                            @endif
                                        @endforeach
                                        </div>
                                    </form>
                                </div>
                            @endif




                            @if((Auth::user()->role_id == 5 || Auth::user()->role_id == 4 || Auth::user()->role_id == 1 )&& $userInfo != null)
                                <div class="box-body">
                                    <form>
                                        <div id="status" class="alert d-none" role="alert">
                                        </div>
                                        <div class="row mbn-20">
                                            <div class="col-12 mb-20">
                                                <label for="formLayoutUsername3">@lang('lang.fio')</label>
                                                <div class="d-flex">
                                                <input   type="text" id="formLayoutUsername3" class="form-control name_user"  value="{!!  $userInfo->name !!}">
                                                <button data-id="{{ $userInfo->id }}" id="save_name_user" class="button button-box button-success mb-0 ml-10 h-100"><i class="zmdi zmdi-check"></i></button>
                                                </div>
                                            </div>

                                            <div class="col-12 mb-20">
                                                <label for="formLayoutEmail3">@lang('text_login')</label>
                                                <input disabled readonly  type="text" id="formLayoutEmail3" class="form-control"  value="{!!  str_replace('@tspu.tj','', $userInfo->email) !!}">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif








                           {{-- <div class="box-body">
                                <div class="form">
                                    <div id="profileResult" class="mb-10"></div>
                                    <form>
                                        <div class="row row-10 mbn-20">
                                            <div class="col-12 mb-20">
                                                <input type="text" disabled="disabled" class="form-control" value="{!! str_replace('@tspu.tj', '', $userData->email) !!}">
                                            </div>
                                            <div class="col-12 mb-20">
                                                <input id="name" type="text" class="form-control" value="{{ $userData->name }}"></div>
                                            <div class="col-sm-12 col-12 mb-20">
                                                <select id="facultId" class="form-control nice-select sel" title="Факултет">
                                                    <option value="">Факултет</option>
                                                    @if(count($faculties) > 0)
                                                        @foreach($faculties as $f)
                                                            <option {{ ($f->id == $userData->facult_id)? 'selected': '' }} value="{{ $f->id }}">{!! $f->title !!}</option >
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-sm-12 col-12 mb-20">
                                                <select id="specialId" class="form-control nice-select sel" title="Факултет">
                                                    <option value="">Курс</option>
                                                    @if(count($courses) > 0)
                                                        @foreach($courses as $c)
                                                            <option {{ ($c->id == $userData->course_id)? 'selected': '' }} value="{{ $c->id }}">{!! $c->title !!}</option >
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-sm-12 col-12 mb-20">
                                                <select id="specialId" class="form-control nice-select sel" title="Факултет">
                                                    <option value="">Курс</option>
                                                    @if(count($courses) > 0)
                                                        @foreach($courses as $c)
                                                            <option {{ ($c->id == $userData->course_id)? 'selected': '' }} value="{{ $c->id }}">{!! $c->title !!}</option >
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-12 mt-10 mb-20 ">
                                                <button id="updateInfo" class="button button-primary button-outline fr std">Изменить</button>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>--}}

                        </div>
                    </div>



                   {{-- <div class="col-xlg-6 col-lg-6 col-12 mb-30 autor-information">
                        <div class="box">
                            <div class="box-head">

                                <h3 class="title">Изменить пароль</h3>
                            </div>
                            <div class="box-body">
                                <div class="form">
                                    <form>
                                        <div id="passwordResult" class="mb-10"></div>
                                        <div class="row row-10 mbn-20">
                                            <div class="col-sm-12 col-12 mb-20">
                                                <input type="text" id="old_pass" class="form-control" placeholder="Старый пароль">
                                            </div>
                                            <div class="col-sm-12 col-12 mb-20">
                                                <input type="text" id="new_pass" class="form-control" placeholder="Новый пароль">
                                            </div>

                                            <div class="col-12 mt-10 mb-20 ">
                                                <button  id="changePassword" class="button button-primary button-outline fr std"
                                                         >Изменить</button>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>--}}
                    <!--Author Information End-->

{{--                    <!-- To Do List Start -->--}}
{{--                    <div class="col-xlg-12 col-lg-12 col-12 mb-30 appeal">--}}
{{--                        <div class="box">--}}

{{--                            <div class="box-head">--}}
{{--                                <h3 class="title">Мои обрашения</h3>--}}
{{--                            </div>--}}

{{--                            <div class="box-body p-0">--}}

{{--                                <!--Todo List Start-->--}}
{{--                                <ul id="my_tickets_list" class="todo-list appeal-list">--}}
{{--                                    @if(count($myTickets) > 0)--}}
{{--                                        @foreach($myTickets as $item)--}}
{{--                                            <!--Todo Item Start-->--}}
{{--                                                <li class="d-flex justify-content-between align-items-center">--}}
{{--                                                    <div class="appeal-content d-flex">--}}
{{--                                                        @if($item->status == 0)--}}
{{--                                                            <div class="appeal-status green  mr-15"></div>--}}
{{--                                                        @elseif($item->status == 1)--}}
{{--                                                            <div class="appeal-status red mr-15"></div>--}}
{{--                                                        @else--}}
{{--                                                            <div class="appeal-status grey mr-15"></div>--}}
{{--                                                        @endif--}}
{{--                                                        <a href="{{url('/tickets/' . $item->id) }}">--}}
{{--                                                            {{ $item->title }}--}}
{{--                                                        </a>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="appeal-time">--}}
{{--                                                        <span> {{ date('d.m.Y', strtotime($item->created_at)) }}</span>--}}
{{--                                                    </div>--}}
{{--                                                </li>--}}
{{--                                                <!--Todo Item End-->--}}
{{--                                            @endforeach--}}
{{--                                    @endif--}}
{{--                                </ul>--}}
{{--                                <!--Todo List End-->--}}
{{--                                <div class="col-12 mt-20 mb-20 mal">--}}

{{--                                    <a href="{{ url('/tickets') }}">--}}
{{--                                        <input type="submit" class="button button-primary button-outline std" value="Все обрашение">--}}
{{--                                    </a>--}}
{{--                                        <button class="button button-outline std ml-30 appeal-btn " data-toggle="modal" data-target="#exampleModal5"--}}
{{--                                            data-whatever="">--}}
{{--                                        Создать обращение</button>--}}
{{--                                    <!-- Modal -->--}}
{{--                                    <div class="modal fade" id="exampleModal5">--}}
{{--                                        <div class="modal-dialog modal-dialog-centered">--}}
{{--                                            <div class="modal-content">--}}
{{--                                                <div class="modal-header brbn">--}}
{{--                                                    <h5 class="modal-title">Открыть обращение</h5>--}}
{{--                                                    <button type="button" class="close p-0" data-dismiss="modal" style="margin-left: 40%;">--}}
{{--                                                        <span aria-hidden="true">&times;</span>--}}
{{--                                                    </button>--}}
{{--                                                </div>--}}
{{--                                                <div class="modal-body pt-0">--}}
{{--                                                    <form>--}}
{{--                                                        <div class="form-group">--}}
{{--                                                            <input id="new_ticket_title" type="text" class="form-control mb-10 " id="recipient-name" placeholder="Тема">--}}
{{--                                                        </div>--}}
{{--                                                        <div class="form-group">--}}
{{--                                                            <textarea id="new_ticket_content" class="form-control h-200" id="message-text" placeholder="Обращения"></textarea>--}}
{{--                                                        </div>--}}
{{--                                                    </form>--}}
{{--                                                </div>--}}
{{--                                                <div class="modal-footer brtn">--}}
{{--                                                    <button data-dismiss="modal"  id="add_new_ticket" class="button button-outline std appeal-btn">Открыть</button>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div><!-- To Do List End -->--}}
                </div>
            </div>
            <!--Right Sidebar End-->
        </div>
    </div>
    <!-- Content Body -->
    @include('inc.footer')
@endsection

@section('scripts')
    {{--    crop--}}
    <script>
        $(document).ready(function(){

            $image_crop = $('#image-preview').croppie({
                enableExif:true,
                viewport:{
                    width:200,
                    height:200,
                    type:'square'
                },
                boundary:{
                    width:300,
                    height:300
                }
            });

            $('#upload_image').change(function(){
                var reader = new FileReader();

                reader.onload = function(event){
                    $image_crop.croppie('bind', {
                        url:event.target.result
                    }).then(function(){
                        $('#crop_save_ava').removeClass('d-none');
                    });
                }
                reader.readAsDataURL(this.files[0]);
            });

            $('.crop_image').click(function(event){
                $image_crop.croppie('result', {
                    type:'canvas',
                    size:'viewport'
                }).then(function(response){
                    var _token = $('input[name=_token]').val();
                    $.ajax({
                        url:'/image_crop/upload',
                        type:'post',
                        data:{"image":response, _token:_token},
                        dataType:"json",
                        success:function(data)
                        {
                            //console.log(data);
                            var crop_image = '<img src="'+data.path+'" />';
                            $('#user_avatar').html(crop_image);
                            $('#user_avatar_h').html(crop_image);
                            $('#crop_save_ava').addClass('d-none');
                        },
                        error: function( data ) {
                            console.log(data);
                        }
                    });
                });
            });

        });
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="/public/web_assets/js/croppie.js"></script>
    <script src="/public/web_assets/js/exif.js"></script>

@endsection

