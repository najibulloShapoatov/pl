
<td>{{date_format($data->updated_at, 'Y.m.d  H:i')}}</td>
<td>{!!  mb_substr($data->title, 0,  200) !!}</td>
<td class="text-center adm-table-notification" width="170">
    <input type="hidden" id="title-caf-{{ $data->id }}" value="{!! $data->title !!}">
    <span  data-id="{{ $data->id }}" id="edit_item_caf" class=" edit-item ti-pencil mr-10"></span>
    <span data-id="{{ $data->id }}" id="delete_item_caf" class=" remove-item ti-trash"></span>
</td>

