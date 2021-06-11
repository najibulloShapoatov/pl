
@if(count($test) <= 0)
    <strong>@lang('lang.not_found')</strong>
@endif
@if(count($test)>0)

    <thead>
    <tr>
        <th width="15%">@lang('lang.facult')</th>
        <th width="15%">@lang('lang.subject')</th>
        <th>@lang('lang.lang')</th>
        <th>@lang('lang.teacher')</th>
        <th class="text-center">@lang('lang.file')</th>
        <th>@lang('lang.check_you')</th>
    </tr>
    </thead>
    <tbody id="tests_body">
    @foreach($test as $item)
        <tr>
            <td>{{ mb_substr($item->faculty->title, 0, 30 )}}</td>
            <td>{{mb_substr($item->subject, 0, 30) }}</td>
            <td>{{ $item->lang }}</td>
            <td>{{ mb_substr($item->user->name, 0, 25 )}}</td>
            <td >
                @if($item->file)
                    <a href="{{ url('/public/uploads/tests/'. $item->id .'/' . $item->file) }}" target="_blank" download="{{ $item->subject . substr ($item->file, -5)}}" class="download-test text-center ">
                        <i class="zmdi zmdi-format-valign-bottom zmdi-hc-fw"></i>
                    </a>
                @endif
            </td>
            <td class="d-flex align-items-center text-center">
                @if($item->has_example == 1)
                    <a href="{{ url('/test/' . $item->id) }}">@lang('lang.test_tit')</a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
@endif

