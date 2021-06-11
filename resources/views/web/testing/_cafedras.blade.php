<select id="cafedra_id" class="form-control form-control-sm nice-select  sel">
<option value="">@lang('lang.select_a_cafedra')</option>
@if(count($data)>0)
    @foreach($data as $item)
        <option  value="{{ $item->id }}" >{!!   $item->title !!}</option>
    @endforeach
@endif
</select>
<script src="/public/web_assets/js/plugins/nice-select/jquery.nice-select.min.js"></script>
<script src="/public/web_assets/js/plugins/nice-select/niceSelect.active.js"></script>
