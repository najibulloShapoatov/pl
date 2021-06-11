@foreach($data['tickets'] as $item)
    <!--Todo Item Start-->
    <li class="d-flex justify-content-between align-items-center">
        <div class="appeal-content d-flex">
            @if($item->status == 0)
                <div class="appeal-status green  mr-15"></div>
            @elseif($item->status == 1)
                <div class="appeal-status red mr-15"></div>
            @else
                <div class="appeal-status grey mr-15"></div>
            @endif
            <a href="{{url('/tickets/' . $item->id) }}">
                {{ $item->title }}
            </a>
        </div>
        <div class="appeal-time">
            <span> {{ date('d.m.Y', strtotime($item->created_at)) }}</span>
        </div>
    </li>
    <!--Todo Item End-->
@endforeach

