<select id="edit_moderator_community" class="form-control bSelect" data-live-search="true">
@if(count($usrs) > 0)
    @foreach($usrs as $u)
        <option {{ ($u->id == $com_user)? 'selected': '' }} value="{{ $u->id }}">{!! $u->name !!}</option>
    @endforeach
@endif
</select>
<script src="/public/web_assets/js/plugins/bootstrap-select/bootstrap-select.min.js"></script>
<script src="/public/web_assets/js/plugins/bootstrap-select/bootstrapSelect.active.js"></script>
