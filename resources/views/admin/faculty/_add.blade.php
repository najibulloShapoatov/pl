<tr id="adm_table_item_{{ $data->id }}">

    <td>{{date_format($data->updated_at, 'Y.m.d  H:i')}}</td>
    <td>{!!  mb_substr($data->title, 0,  200) !!}</td>
    <td class="text-center adm-table-notification" width="170">
        <input type="hidden" id="title-fac-{{ $data->id }}" value="{!! $data->title !!}">
        <span  data-id="{{ $data->id }}" id="edit_item_fac" class=" edit-item ti-pencil mr-10"></span>
        <a href="{{ url('/faculty/' . $data->id) }}" class="editableIcons mr-10" title="">
            <span class="ti-menu"></span>
        </a>
        <span data-id="{{ $data->id }}" id="delete_item_fac" class=" remove-item ti-trash"></span>
    </td>
</tr>
