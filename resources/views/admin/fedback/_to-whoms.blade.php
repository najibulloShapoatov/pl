@if(count($data)>0)
    @foreach($data as $f)
        <option value="{{ $f->id }}">{!! $f->place . ': ' . $f->name !!}</option >
    @endforeach
@endif



