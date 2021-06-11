<td>{{date_format($forumCat->updated_at, 'Y.m.d  H:i')}}</td>
<td id="title_{{ $forumCat->id }}">{!!   mb_substr($forumCat->title, 0,  200) !!}</td>
<td class="text-center adm-table-notification" width="170">
    <span data-id="{{ $forumCat->id }}" id="edit_cat_forum" class=" edit-item ti-pencil mr-10 "></span>
    <span data-id="{{ $forumCat->id }}" id="delete_item_forumCat" class=" remove-item  ti-trash"></span>
</td>
