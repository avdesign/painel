@if ($image->active == constLang('active_true'))
    <p id="status-{{$val->image_color_id}}">
        <button type="button" id="status-{{$val->image_color_id}}" onclick="statusCatalog('{{$val->image_color_id}}', '{{route('status.catalog', $val->image_color_id)}}', '{{constLang('active_false')}}', '{{csrf_token()}}')" class="button compact icon-tick green-gradient">{{constLang('active_true')}}</button>
    </p>
@else
    <p id="status-{{$val->image_color_id}}">
        <button type="button" id="status-{{$val->image_color_id}}" onclick="statusCatalog('{{$val->image_color_id}}', '{{route('status.catalog', $val->image_color_id)}}', '{{constLang('active_true')}}', '{{csrf_token()}}')" class="button compact icon-tick grey-gradient">{{constLang('active_false')}}</button>
    </p>
@endif
@can('stock-exit')
    <p><button type="button" onclick="abreModal('Saida: {{$val->product->name}}', '{{route('stock.exit', $val->id)}}','form-stock', 2, 'true',420,480);" class="button compact icon-gear blue-gradient">{{constLang('exit')}}</button></p>
@endcan