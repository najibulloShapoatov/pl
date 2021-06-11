<td>{{date_format($data->updated_at, 'Y.m.d  H:i')}}</td>
<td id="title_{{ $data->id }}">{!!   mb_substr($data->title, 0,  200) !!}</td>
<td class="text-center adm-table-notification" width="170">
    <span data-id="{{ $data->id }}" id="edit_cat_elon" class=" edit-item ti-pencil mr-10 "></span>
    <span data-id="{{ $data->id }}" id="delete_item_elonCat" class=" remove-item  ti-trash"></span>
</td>
