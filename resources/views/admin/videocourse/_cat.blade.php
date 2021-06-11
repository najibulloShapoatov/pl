<td>{{date_format($cat->updated_at, 'Y.m.d  H:i')}}</td>
<td id="title_{{ $cat->id }}">{{ mb_substr($cat->title, 0,  100) }}</td>
<td class="text-center adm-table-notification" width="170">
    <span data-id="{{ $cat->id }}" id="edit_cat_course" class=" edit-item ti-pencil mr-10 "></span>
    <span data-id="{{ $cat->id }}" id="delete_item_course" class=" remove-item  ti-trash"></span>
</td>
