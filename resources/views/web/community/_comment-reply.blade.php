<li>
    <div class="chat">
        <div class="head mb-0">
            <h6 class="mb-0">{{ $data->user->name }}</h6>
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
                <p>{!! $data->text !!}</p>
            </div>
        </div>

    </div>
</li>
