<option>@lang('lang.select_a_section')</option>
@if(count($data) > 0)
@foreach($data as $item)
        <option value="{{ $item->id }}">{{ $item->title }}</option>
    @endforeach
@endif
