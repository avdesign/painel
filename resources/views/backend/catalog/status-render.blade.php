<p id="status-{{$image->id}}">
    @if($image->active == constLang('active_true'))
        <button type="button" onclick="statusCatalog('{{$image->id}}', '{{route('status.catalog', $image->id)}}', '{{constLang('active_false')}}', '{{csrf_token()}}')" class="button compact icon-tick green-gradient">{{constLang('active_true')}}</button>
    @else
        <button type="button" onclick="statusCatalog('{{$image->id}}', '{{route('status.catalog', $image->id)}}', '{{constLang('active_true')}}', '{{csrf_token()}}')" class="button compact grey-gradien">{{constLang('active_false')}}</button>
    @endif
</p>
