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
        <!-- ---------------------------------------------------------------------------------------------- -->
        <!-- Page Headings Start -->
        <div class="row ">

            <!-- Page Heading Start -->
            <div class="col-12 col-lg-12 mb-20">
                <div class="emat-item sb-item ">
                    <div class="sb-cover col-md-4  col-xs-7">
                        <!--Preloaded File Start-->
                        <div class="image_book mb-20">
                            <input id="new_book_image" class="dropify-my" type="file"
                                   data-default-file="{{ ($book->image)?'/public/uploads/books/' . $book->id . '/' . $book->image : '' }}"
                                   data-allowed-file-extensions="jpeg jpg png"
                                   data-max-file-size="3M"
                            style="width: 100%">
                        </div>
                        <!--Preloaded File End-->


                        <div class="col-12 pl-0 pr-0 mt-30 mb-15">
                            <div class="book-checkbox-radio-group ">
                                <input type="hidden" id="new_book_lic" name="" value="{{ $book->book_license_id }}">
                                @php($k=0)
                                @if(count($lics) > 0)
                                    @foreach($lics as $item)
                                        @if($k==0)<div class="col-sm-6">@endif
                                            <label class="book-radio d-flex">
                                                <input {{ ($item->id == $book->book_license_id)? 'checked': '' }} data-id="{{ $item->id }}" class="book-lics" type="radio" name="adomxRadio">
{{--                                                <input data-id="{{ $item->id }}" class="book-lics" type="radio" name="adomxRadio">--}}
                                                <i class="icon"></i>
                                                <div class="licen-img">
                                                    <img src="/public/uploads/books/licenses/{{ $item->id . '/' . $item->image }}" alt="">
                                                </div>
                                                <span span class="ml-10"  data-tippy-animatefill="false" data-tippy-theme="dark"
                                                      data-tippy-animation="perspective" data-tippy-content="{{ $item->descr }}" data-tippy-arrow="true">?</span>
                                            </label>
                                            @php($k+=1)
                                            @if($k==3)</div>
                                        @php($k=0)
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
{{--
                        <div class="col-12 pl-0 pr-0 mt-30 mb-15">
                            <div class="book-checkbox-radio-group col-sm-12">
                                <div class="col-sm-6 pl-0">
                                    <input type="hidden" id="new_book_lic" name="" value="{{ $book->book_license_id }}">

                                    @if(count($lics) > 0)
                                        @foreach($lics as $item)
                                            <label class="book-radio d-flex">
                                                <input {{ ($item->id == $book->book_license_id)? 'checked': '' }} data-id="{{ $item->id }}" class="book-lics" type="radio" name="adomxRadio">
                                                <i class="icon"></i>
                                                <img src="/public/uploads/books/licenses/{{ $item->id . '/' . $item->image }}" alt="">
                                                <span span class="ml-10"  data-tippy-animatefill="false" data-tippy-theme="dark"
                                                      data-tippy-animation="perspective" data-tippy-content="{{ $item->descr }}" data-tippy-arrow="true">?</span>
                                            </label>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="col-sm-6 rl-0">
                                   --}}{{-- <label class="book-radio d-flex">
                                        <input type="radio" name="adomxRadio">
                                        <i class="icon"></i>
                                        <img src="/public/web_assets/images/license.png" alt="">

                                        <span span class="ml-10"  data-tippy-animatefill="false" data-tippy-theme="dark"
                                              data-tippy-animation="perspective" data-tippy-content="Perspective" data-tippy-arrow="true">?</span>
                                    </label>
                                    <label class="book-radio  d-flex">
                                        <input type="radio" name="adomxRadio">
                                        <i class="icon"></i>
                                        <img src="/public/web_assets/images/license.png" alt="">
                                        <span class="ml-10" data-tippy-animatefill="false" data-tippy-theme="dark"
                                              data-tippy-animation="perspective" data-tippy-content="Perspective" data-tippy-arrow="true">?</span>
                                    </label>
                                    <label class="book-radio  d-flex">
                                        <input type="radio" name="adomxRadio">
                                        <i class="icon"></i>
                                        <img src="/public/web_assets/images/license.png" alt="">
                                        <span class="ml-10" data-tippy-animatefill="false" data-tippy-theme="dark"
                                              data-tippy-animation="perspective" data-tippy-content="Perspective" data-tippy-arrow="true">?</span>
                                    </label>--}}{{--
                                </div>

                            </div>
                        </div>

                        --}}


                    </div>
                    <div class="content col-xs-7">
                        <div class="row mbn-15">

                            <div class="col-10 mb-15">
                                <input id="new_book_title" type="text" class="form-control form-control-sm" placeholder="@lang('lang.name')" value="{!! $book->title !!}">
                            </div>
                            <div class="col-10 mb-15">
                                <select id="new_book_authors" class="form-control form-control-sm select2" multiple>
                                    @if(count($authors) > 0)
                                        @foreach($authors as $item)
                                            @php($t=0)
                                            @if(count($B_authors))
                                                @foreach($B_authors as $author)
                                                   @if($author->author_id == $item->id)
                                                        <option selected value="{{ $item->id }}">{{ $item->name }}</option>
                                                       @php($t=1)
                                                    @endif
                                                @endforeach
                                                @if($t==0)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @else
                                                    @php($t=0)
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-10 mb-15">
                                <select id="new_book_lang" class="form-control form-control-sm">
                                    <option value="">@lang('lang.select_a_lang')</option>
                                    @if(count($langs) > 0)
                                        @foreach($langs as $item)
                                            <option {{ ($book->book_lang_id == $item->id)? 'selected': '' }}  value="{{ $item->id }}">{{ $item->title }}</option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                            <div class="col-10 mb-15">
                                <input id="new_book_year" type="text" class="form-control form-control-sm" placeholder="@lang('lang.year_publish')" value="{!! $book->publish_year !!}">
                            </div>
                            <div class="col-10 mb-15">
                                <input id="new_book_publish" type="text" class="form-control form-control-sm" placeholder="@lang('lang.publish_house')" value="{!! $book->publishing_house !!}">
                            </div>
                            <div class="col-10 mb-15">
                                <select id="new_book_cat" class="form-control form-control-sm">
                                    <option value="">@lang('lang.select_a_category')</option>
                                    @if(count($cats) > 0)
                                        @foreach($cats as $item)
                                            <option {{ ($catID == $item->id)? 'selected': '' }} value="{{ $item->id }}">{{ $item->title }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-10 mb-15">
                                <select id="new_book_section" class="form-control form-control-sm">
                                    <option>@lang('lang.select_a_section')</option>
                                @if(count($sections) > 0)
                                        @foreach($sections as $item)
                                            <option {{ ($book->book_category_id == $item->id)? 'selected': '' }} value="{{ $item->id }}">{{ $item->title }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-10 mb-15">
                                <input id="new_book_pages" type="text" class="form-control form-control-sm" placeholder="@lang('lang.enter.pages')" value="{!! $book->pages !!}">
                            </div>
                            <div class="col-10 mb-15">
                                <select id="new_book_type" class="form-control form-control-sm">
                                    <option value="">@lang('lang.select_a_genre')</option>
                                    @if(count($genres) > 0)
                                        @foreach($genres as $item)
                                            <option {{ ($book->book_type_id == $item->id)? 'selected': '' }} value="{{ $item->id }}">{{ $item->title }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-10 mb-15">
                                <input id="new_book_isbn" type="text" class="form-control form-control-sm" placeholder="@lang('lang.enter_isbn')" value="{!! $book->isbn !!}">
                            </div>
                            <!-- <div class="col-10 mb-15">
                                <select class="form-control form-control-sm">
                                    <option>Select Small</option>
                                    <option>One</option>
                                    <option>Two</option>
                                    <option>Three</option>
                                </select>
                            </div> -->
                            <div class="col-10 mb-15">
                                <textarea id="new_book_descr" class="form-control form-control-sm" placeholder="@lang('lang.description')">{!! $book->description !!}</textarea>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-12 pl-0 pr-0 ">

                    <div class="col-12 pl-0 pr-0 d-flex">
                        <div class="col-4 pl-0">
                            <div  class="add-question-item mb-15">
                                <div class="row mbn-15">
                                    <h5>@lang('lang.add_pdf_file')</h5>
                                    <div  class=" col-12 pl-0 pr-0">
                                        <div id="pdf_files">
                                            @if(count($files) > 0)
                                                @foreach($files as $item)
                                                    @if($item->file_type == 1)
                                                        <form id="pdf_file_{{$item->id}}"  class="book-file d-flex align-items-center" action="" enctype="multipart/form-data">
                                                            <span style="width: 100%;">{{ $item->file_name }}</span>
                                                            <button  data-id="{{$item->id}}" id="delete_pdf_file"   class="button button-box off button-youtube">
                                                                <i class="zmdi zmdi-close zmdi-hc-fw"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endforeach
                                            @endif
                                        <form id="pdf_file_form_1"  class="book-file d-flex align-items-center" action="" enctype="multipart/form-data">
                                            <input
                                                width="100%"
                                                id="input_pdf_file_1"
                                                class="pdf-file"
                                                type="file"
                                                data-max-file-size="512M"/>
                                            <button data-id="1" id="upload_pdf_file" class="button button-box button-google-drive">
                                                <i class="zmdi zmdi-cloud-upload done   zmdi-hc-fw"></i>
                                            </button>
                                        </form>
                                        </div>
                                        <button data-id="1" id="add_pole_pdf_file" class="button mt-10 std button-primary button-outline fl-right"> @lang('lang.add_more')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 pl-0">
                            <div  class="add-question-item mb-15">
                                <div class="row mbn-15">
                                    <h5>@lang('lang.add_epub_file')</h5>
                                    <div  class=" col-12 pl-0 pr-0">
                                        <div id="epub_files">
                                            @if(count($files) > 0)
                                                @foreach($files as $item)
                                                    @if($item->file_type == 2)
                                                        <form id="epub_file_{{$item->id}}"  class="book-file d-flex align-items-center" action="" enctype="multipart/form-data">
                                                            <span style="width: 100%;">{{ $item->file_name }}</span>
                                                            <button  data-id="{{$item->id}}" id="delete_epub_file"   class="button button-box off button-youtube">
                                                               <i class="zmdi zmdi-close zmdi-hc-fw"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endforeach
                                            @endif
                                            <form id="epub_file_form_1"  class="book-file d-flex align-items-center" action="" enctype="multipart/form-data">
                                                <input
                                                    width="100%"
                                                    id="input_epub_file_1"
                                                    class="pdf-file"
                                                    type="file"
                                                    data-max-file-size="512M"/>
                                                <button data-id="1" id="upload_epub_file" class="button button-box button-google-drive">
                                                    <i class="zmdi zmdi-cloud-upload done   zmdi-hc-fw"></i>
                                                </button>

                                            </form>
                                        </div>
                                        <button data-id="1" id="add_pole_epub_file" class="button mt-10 std button-primary button-outline fl-right"> @lang('lang.add_more')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 pl-0">
                            <div  class="add-question-item mb-15">
                                <div class="row mbn-15">
                                    <h5>@lang('lang.add_fb2_file')</h5>
                                    <div  class=" col-12 pl-0 pr-0">
                                        <div id="fb2_files">
                                            @if(count($files) > 0)
                                                @foreach($files as $item)
                                                    @if($item->file_type == 3)
                                                        <form id="fb2_file_{{$item->id}}"  class="book-file d-flex align-items-center" action="" enctype="multipart/form-data">
                                                            <span style="width: 100%;">{{ $item->file_name }}</span>
                                                            <button  data-id="{{$item->id}}" id="delete_fb2_file"   class="button button-box off button-youtube">
                                                                <i class="zmdi zmdi-close zmdi-hc-fw"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endforeach
                                            @endif
                                            <form id="fb2_file_form_1"  class="book-file d-flex align-items-center" action="" enctype="multipart/form-data">
                                                <input
                                                    width="100%"
                                                    id="input_fb2_file_1"
                                                    class="pdf-file"
                                                    type="file"
                                                    data-max-file-size="512M"/>
                                                <button data-id="1" id="upload_fb2_file" class="button button-box button-google-drive">
                                                    <i class="zmdi zmdi-cloud-upload done   zmdi-hc-fw"></i>
                                                </button>

                                            </form>
                                        </div>
                                        <button data-id="1" id="add_pole_fb2_file" class="button mt-10 std button-primary button-outline fl-right">@lang('lang.add_morer')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 pl-0 pr-0 d-flex">
                        <div class="col-4 pl-0">
                            <div  class="add-question-item mb-15">
                                <div class="row mbn-15">
                                    <h5>@lang('lang.add_word_file')</h5>
                                    <div  class=" col-12 pl-0 pr-0">
                                        <div id="word_files">
                                            @if(count($files) > 0)
                                                @foreach($files as $item)
                                                    @if($item->file_type == 4)
                                                        <form id="word_file_{{$item->id}}"  class="book-file d-flex align-items-center" action="" enctype="multipart/form-data">
                                                            <span style="width: 100%;">{{ $item->file_name }}</span>
                                                            <button  data-id="{{$item->id}}" id="delete_word_file"   class="button button-box off button-youtube">
                                                                <i class="zmdi zmdi-close zmdi-hc-fw"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endforeach
                                            @endif
                                            <form id="word_file_form_1"  class="book-file d-flex align-items-center" action="" enctype="multipart/form-data">
                                                <input
                                                    width="100%"
                                                    id="input_word_file_1"
                                                    class="pdf-file"
                                                    type="file"
                                                    data-max-file-size="512M"/>
                                                <button data-id="1" id="upload_word_file" class="button button-box button-google-drive">
                                                    <i class="zmdi zmdi-cloud-upload done   zmdi-hc-fw"></i>
                                                </button>

                                            </form>
                                        </div>
                                        <button data-id="1" id="add_pole_word_file" class="button mt-10 std button-primary button-outline fl-right"> @lang('lang.add_more')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 pl-0">
                            <div  class="add-question-item mb-15">
                                <div class="row mbn-15">
                                    <h5>@lang('lang.add_zip_file')</h5>
                                    <div  class=" col-12 pl-0 pr-0">
                                        <div id="zip_files">
                                            @if(count($files) > 0)
                                                @foreach($files as $item)
                                                    @if($item->file_type == 5)
                                                        <form id="zip_file_{{$item->id}}"  class="book-file d-flex align-items-center" action="" enctype="multipart/form-data">
                                                            <span style="width: 100%;">{{ $item->file_name }}</span>
                                                            <button  data-id="{{$item->id}}" id="delete_zip_file"    class="button button-box off button-youtube">
                                                                <i class="zmdi zmdi-close zmdi-hc-fw"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endforeach
                                            @endif
                                            <form id="zip_file_form_1"  class="book-file d-flex align-items-center" action="" enctype="multipart/form-data">
                                                <input
                                                    width="100%"
                                                    id="input_zip_file_1"
                                                    class="pdf-file"
                                                    type="file"
                                                    data-max-file-size="512M"/>
                                                <button data-id="1" id="upload_zip_file" class="button button-box button-google-drive">
                                                    <i class="zmdi zmdi-cloud-upload done   zmdi-hc-fw"></i>
                                                </button>

                                            </form>
                                        </div>
                                        <button data-id="1" id="add_pole_zip_file" class="button mt-10 std button-primary button-outline fl-right"> @lang('lang.add_more')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 pl-0">
                            <div  class="add-question-item mb-15">
                                <div class="row mbn-15">
                                    <h5>@lang('lang.add_audio_file')</h5>
                                    <div  class=" col-12 pl-0 pr-0">
                                        <div id="audio_files">
                                            @if(count($files) > 0)
                                                @foreach($files as $item)
                                                    @if($item->file_type == 6)
                                                        <form id="audio_file_{{$item->id}}"  class="book-file d-flex align-items-center" action="" enctype="multipart/form-data">
                                                            <span style="width: 100%;">{{ $item->file_name }}</span>
                                                            <button data-id="{{$item->id}}" id="delete_audio_file"  class="button button-box off button-youtube">
                                                                <i class="zmdi zmdi-close zmdi-hc-fw"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endforeach
                                            @endif
                                            <form id="audio_file_form_1"  class="book-file d-flex align-items-center" action="" enctype="multipart/form-data">
                                                <input
                                                    width="100%"
                                                    id="input_audio_file_1"
                                                    class="pdf-file"
                                                    type="file"
                                                    data-max-file-size="512M"/>
                                                <button data-id="1" id="upload_audio_file" class="button button-box button-google-drive">
                                                    <i class="zmdi zmdi-cloud-upload done   zmdi-hc-fw"></i>
                                                </button>

                                            </form>
                                        </div>
                                        <button data-id="1" id="add_pole_audio_file" class="button mt-10 std button-primary button-outline fl-right"> @lang('lang.add_more')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="col-10 mb-15 mt-30 d-flex">
                    <div class="col-6 d-flex justify-content-center">
                        <div>
                            <span data-id="{{ $book->id }}" id="delete_book" style="width: 100%" class="mt-25 pt-5 delete-community">@lang('lang.delete_book')</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <button data-id="{{ $book->id }}" id="edit_new_book" style="width: 100%" class="button button-success s-btn">@lang('lang.save')</button>
                    </div>
                </div>
            </div><!-- Page Heading End -->




        </div><!-- Page Headings End -->

        <!-- ######################################################################## -->






    </div><!-- Content Body End -->
    @include('inc.footer')
@endsection


@section('scripts')

    <!-- OWl Carousel -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js'></script>

    <!-- Plugins & Activation JS For Only This Page -->

    <script src="/public/web_assets/js/plugins/dropify/dropify.min.js"></script>
    <script src="/public/web_assets/js/plugins/dropify/dropify.active.js"></script>
    <script src="/public/web_assets/js/customize_dropify.js"></script>

    <script src="/public/web_assets/js/vendor/bootstrap.min.js"></script>
    <script src="/public/web_assets/js/plugins/tippy4.min.js.js"></script>
    <script src="/public/web_assets/js/plugins/raty/jquery.raty.js"></script>
    <script src="/public/web_assets/js/plugins/raty/raty.active.js"></script>

    <script src="/public/web_assets/js/plugins/select2/select2.full.min.js"></script>
    <script src="/public/web_assets/js/plugins/select2/select2.active.js"></script>

@endsection
