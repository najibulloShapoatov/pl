

@if(count($data) > 0)
@foreach($data as $item)
    @if($item->is_active == 1)
        <div class="f-s-item mt-30 pb-20 mr-30">
            <a href="{{ url('/forum/' . $item->id ) }}">
            <h4 class="title ">
                {{ mb_substr($item->title, 0, 100) }}
           </h4>
            </a>
           <p>
               {{ mb_substr($item->text,0 ,250) }}
           </p>
       </div>
    @endif
@endforeach
@else
<p class="mt-30 text-center" style="font-size: 20px;"> @lang('lang.po_zaprosu') <span style="color: #ffa938">{{ $search }}</span> @lang('lang.not_found')</p>
@endif

