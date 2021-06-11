<td>{{date_format($data->updated_at, 'Y.m.d  H:i')}}</td>
<td id="title_{{ $data->id }}">{{ mb_substr($data->title, 0,  200) }}</td>
<td>
    <label  data-id="{{ $data->id }}" id="change_bookC_active" class="adomx-switch">
        <input  id="sts_{{ $data->id }}" type="checkbox" {{ ($data->is_active == 1)? 'checked' : ""}}>
        <i class="lever"></i>

        <span id="sts_text_{{ $data->id }}" class="text">{{ ($data->is_active == 1)? __('lang.yes') : __('lang.no')}}</span>
    </label>
</td>
<td class="text-center adm-table-notification" width="170">
    @if($data->parent_id == 0)
        <a href="{{ url('/manage-book/category/' . $data->id) }}"> <span class=" edit-item ti-menu mr-10 "></span></a>
    @endif
        <span data-id="{{ $data->id }}" id="edit_cat_bCat" class=" edit-item ti-pencil mr-10 "></span>
    <span data-id="{{ $data->id }}" id="delete_item_bCat" class=" remove-item  ti-trash"></span>
</td>
