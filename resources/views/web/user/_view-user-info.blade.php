<div class="col-12 d-flex">
    <div class="col-3 ">
        <div class="user-info-image">
            @if($data->image)
                <img src="{{ '/public/uploads/users/' .  str_replace('@tspu.tj', '', $data->email)  . '/avatar/' . $data->image }}"  alt="">
            @else
                <img src="/public/uploads/users/default-avatar.png" alt="">
            @endif
        </div>
    </div>
    <div class="col-8 pt-15">
        <div class="col-12 pl-0">
            <strong>{!!  $data->name !!}</strong>
        </div>
        <div class="col-12 pl-0 mt-5">
            <span>{{ $data->role->role }}</span>
        </div>

        <div class="inform mt-20">
            @if($data->role_id == 3)
                @foreach($props as $p)
                    @if($p->prop_key == 'Faculty_TJ')
                        <div class="d-flex mb-10">
                            <strong class="mr-10">@lang('lang.facult'):</strong>
                            <span>{!!  $p->prop_value !!}</span>
                        </div>
                        @continue
                    @endif
                    @if($p->prop_key == 'Specialty_TJ')
                        <div class="d-flex mb-10">
                            <strong class="mr-10">@lang('lang.speciality'):</strong>
                            <span>{!!  $p->prop_value !!}</span>
                        </div>
                        @continue
                    @endif
                    @if($p->prop_key == 'Course')
                        <div class="d-flex mb-10">
                            <strong class="mr-10">@lang('lang.course'):</strong>
                            <span>{!!  $p->prop_value !!}</span>
                        </div>
                    @endif
                @endforeach

            @elseif($data->role_id == 2)
                <div class="d-flex mb-10">
                    <strong class="mr-10">@lang('lang.facult'):</strong>
                    <span>Name of Faculty</span>
                </div>
                <div class="d-flex mb-10">
                    <strong class="mr-10">@lang('lang.cafedra'):</strong>
                    <span>Name of CAfedra</span>
                </div>

            @endif
        </div>
    </div>
</div>
