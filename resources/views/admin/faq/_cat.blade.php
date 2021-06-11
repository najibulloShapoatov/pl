<td>{{date_format($faqCat->updated_at, 'Y.m.d  H:i')}}</td>
<td id="title_{{ $faqCat->id }}">{{ mb_substr($faqCat->title, 0,  200) }}</td>
<td class="text-center adm-table-notification" width="170">
    <span data-id="{{ $faqCat->id }}" id="edit_cat_faq" class=" edit-item ti-pencil mr-10 "></span>
    <span data-id="{{ $faqCat->id }}" id="delete_item_faqCat" class=" remove-item  ti-trash"></span>
</td>
