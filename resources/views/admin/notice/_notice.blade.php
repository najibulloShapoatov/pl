<tr id="adm_table_item_{{ $data->id }}">

    <td>{{date_format($data->created_at, 'Y.m.d  H:i')}}</td>

    <td>{!!  mb_substr($data->title, 0,  200) !!}</td>

    <td class="text-center">{{ ($data->who_can_see == 0)? 'Все': $data->role['role'] }}</td>
    <td class="text-center adm-table-notification" width="170">
        <span data-id="{{ $data->id }}" id="view_notice" class=" edit-item ti-eye mr-15"></span>
        <span data-id="{{ $data->id }}" id="edit_notice" class=" edit-item ti-pencil mr-15"></span>
        <span data-id="{{ $data->id }}" id="delete_notice" class=" remove-item ti-trash"></span>
    </td>
</tr>
