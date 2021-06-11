@if(count($pool->answers) > 0)
    @foreach($pool->answers as $answer)
        <span class="pool-res-text">{{ $answer->title }}</span>
        <div class="progress">
            @php
                $n=0;
                if($p_res > 0){$n = (count($answer->poolres)/$p_res)*100;}
            @endphp
            <div class="progress-bar" role="progressbar" style="width: {{ ($n < 13)? 13.5 : number_format($n, 2, '.', ' ') }}%" aria-valuenow="{{ number_format($n, 1, '.', ' ') }}"
                 aria-valuemin="0" aria-valuemax="100">{{ number_format($n, 1, '.', ' ') }}%</div>
        </div>
    @endforeach
@endif
