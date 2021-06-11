@foreach($data['news'] as $item)
<div class="new-item d-flex">
    <div class="cv col-md-4 col-sm-3 col-xs-2 col-lg-auto">
        @if($item->image)
            <img class="cove" src="/public/uploads/news/{{ $item->id }}/{{$item->image}}" alt="{{ $item->title }}">
        @else
            <img class="cove" src="/public/web_assets/images/news/Layer.png" alt="no-image">
        @endif
    </div>
    <div class="content col-md-7 col-xs-10 col-sm-8 col-lg-auto">
        <a href="{{ url('/news/' . $item->id) }}">
            <h5>{{ $item->title }}</h5></a>
        <div>
        <span class="pt-10 mb-10"><i class="ti-calendar"></i>
            &nbsp; {{ date('d.m.Y', strtotime($item->created_at)) }}
        </span>
        <span class="pl-40 pt-10 mb-10"><i class="ti-eye"></i>&nbsp;{{$item->viewed}}</span>
        </div>
        <p class= "pb-10 pt-10">
            {{ $item->annonce_text }}
        </p>
    </div>

</div>
@endforeach

