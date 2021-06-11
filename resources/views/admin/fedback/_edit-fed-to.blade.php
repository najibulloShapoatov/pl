<div class="form-group">
    <div class="col-12 mb-10 pl-0 pr-0">
        <div class="row mbn-15">
            <div class="col-12 mb-15">
                <div class="mb-10">
                    <strong >@lang('lang.facult')</strong>
                </div>
                <select id="faculty-fed-to-edit" class="form-control form-control-sm">
                    @if(count($fac) > 0)
                        @foreach($fac as $f)
                            <option {{ ($data->facult_id == $f->id)? 'selected':'' }} value="{{ $f->id }}">{!! $f->title !!}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="col-12 mb-15">
                <div class="mb-10">
                    <strong>@lang('lang.position')</strong>
                </div>
                <input autocomplete="off" id="place-fed-to-edit" type="text" class="form-control form-control-sm" placeholder="" value="{!! $data->place !!}">
            </div>
            <div class="col-12 mb-15">
                <div class="mb-10">
                    <strong>@lang('lang.fio')</strong>
                </div>
                <input autocomplete="off" id="name-fed-to-edit" type="text" class="form-control form-control-sm" placeholder="" value="{!! $data->name !!}">
            </div>
            <div class="col-12 mb-15">
                <div class="mb-10">
                    <strong>@lang('lang.email')</strong>
                </div>
                <input autocomplete="off" id="email-fed-to-edit" type="text" class="form-control form-control-sm" placeholder="" value="{!! $data->email !!}">
            </div>



        </div>
    </div>
</div>
<div class="form-group d-flex justify-content-between">
    <button data-id="{{ $data->id }}" id="edit-fed-to-btn" class="button button-primary std mt-20 mb-20 fz-15 fw-500 pl-25 pr-25 pt-5 pb-5">
        @lang('lang.save')
    </button>

</div>
