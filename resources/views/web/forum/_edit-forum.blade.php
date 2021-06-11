


<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header  brbn">
            <h5 class="modal-title">@lang('lang.edit')</h5>
            <button id="close_videocourse_player" type="button" class="close  p-0 m-btn-close " data-dismiss="modal" >
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
        <div class="modal-body comm-form add-forum pt-0">
            <form>
                <div class="form-group">
                    <input id="edit_forum_title" type="text" class="form-control mb-10 "
                            placeholder="@lang('lang.topic')" value="{!! $data->title !!} ">
                </div>
                <div class="form-group">
                    <select id="edit_forum_category" class="form-control mb-10">
                        <option>@lang('lang.select_a_category')</option>
                        @if($f_category)
                            @foreach($f_category as $item)
                                @if($data->category_id == $item->id)
                                <option selected value="{{ $item->id }}">{{ $item->title }}</option>
                                @else
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endif
                            @endforeach
                        @endif

                    </select>
                </div>
                <div class="form-group">
                    <textarea id="edit_forum_descr" class="form-control h-200" id="message-text" placeholder="@lang('lang.description')">{!! $data->text !!}</textarea>
                </div>
                <button data-id="{{ $data->id }}" data-dismiss="modal"  id="save_edited_modal"
                        class="button button-success std mt-20 mb-20 fz-16 pl-25 pr-25 pt-5 pb-5 float-sm-right">
                    @lang('lang.save')
                </button>
                <span data-id="{{ $data->id }}" id="remove_forum" class="mt-30 pt-5 delete-community mr-25 fl-right">@lang('lang.delete_topic')</span>


            </form>
        </div>
    </div>
</div>
