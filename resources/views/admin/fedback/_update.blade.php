
<td>{{date_format($data->created_at, 'Y.m.d  H:i')}}</td>
<td>{!!  mb_substr($data->facultet->title, 0, 60) !!}</td>
<td>{!!  $data->place !!}</td>
<td>{!!  mb_substr($data->name, 0,  200) !!}</td>
<td><a href="mailto:{{ $data->email }}">{{ $data->email }}</a></td>
<td class="text-center adm-table-notification" width="170">
    {{--<a href="{{ url('/news-manage/edit/' . $item->id) }}" class="editableIcons mr-10" title="Редактировать">
        <span class="ti-pencil"></span>
    </a>--}}
    <span  data-id="{{ $data->id }}" id="edit_item_fed_to" class=" edit-item ti-pencil mr-20"></span>
    <span data-id="{{ $data->id }}" id="delete_item_fed_to" class=" remove-item ti-trash"></span>
</td>
