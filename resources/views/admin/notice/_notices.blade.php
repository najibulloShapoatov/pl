@foreach($data as $item)
    <tr id="adm_table_item_{{ $item->id }}">
        <td>{{date_format($item->created_at, 'Y.m.d  H:i')}}</td>
        <td>{!!  mb_substr($item->title, 0,  200) !!}</td>
        <td class="text-center">{{ ($item->who_can_see == 0)? 'Все': $item->role['role'] }}</td>
        <td class="text-center adm-table-notification" width="170">
            <span data-id="{{ $item->id }}" id="view_notice" class=" edit-item ti-eye mr-15"></span>
            <span data-id="{{ $item->id }}" id="edit_notice" class=" edit-item ti-pencil mr-15"></span>
            <span data-id="{{ $item->id }}" id="delete_notice" class=" remove-item ti-trash"></span>
        </td>
    </tr>
@endforeach
