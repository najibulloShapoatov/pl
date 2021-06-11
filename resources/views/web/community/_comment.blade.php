<li>
    <div class="chat">
        <div class="head">
            <h5>{{ $data->user->name }}</h5>
            {{-- <span>Yesterday 05.30 am</span>--}}
            {{-- <a href="#"><i class="zmdi zmdi-replay"></i></a>--}}
        </div>
        <div class="body">
            <div class="image">
                @if($data->user->image)
                    <img src="{{ '/public/uploads/users/' .  str_replace('@tspu.tj', '', $data->user->email)  . '/avatar/' . $data->user->image }}"  alt="">
                @else
                    <img src="/public/uploads/users/default-avatar.png"  alt="">
                @endif

            </div>
            <div class="content">
                <p>{!!   $data->text !!}</p>
                <div class="footer">
                    <span>{{ date_format($data->created_at, 'Y.m.d  H:i') }}</span>
                    <span data-id="{{ $data->id }}" id="reply_comment_form" class="reply-comment ml-10">
                        <strong>@lang('lang.reply')</strong>
                    </span>
                </div>

                <div class="replied col-12 pl-0 mt-15">
                    <div id="reply-comment-form-{{ $data->id }}" class="chat-submission reply hide">
                        <form  id="form-reply-{{ $data->id }}"  action="#">
                            <input id="comment-reply-{{ $data->id }}" type="text" placeholder="@lang('lang.write_something')">
                            <div class="buttons">
                                <button data-id="{{ $data->id }}" id="add-reply-comment" class="submit button button-box button-round button-primary mb-0"><i class="zmdi zmdi-mail-send"></i></button>
                            </div>
                        </form>
                    </div><!-- Chat End -->
                    <ul id="coment-replies-{{ $data->id }}" class="pl-0">
                    </ul>
                </div>
            </div>
        </div>

    </div>
</li>
