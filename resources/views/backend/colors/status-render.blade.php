@php
    ($image->active == constLang('active_true') ? $col = 'green' : $col = 'red');
    ($image->cover == 1 ? $title = constLang('cover') : $title = '');
    ($image->cover == 1 ? $option = '{"classes":["red-gradient"],"position":"top"}' : $option = '');
@endphp
<span id="btns-{{$image->id}}" class="button-group compact children-tooltip" data-tooltip-options='{{$option}}'>
    <button onclick="statusColor('{{$image->id}}','{{route('status-color', ['idpro' => $image->product_id,'id' => $image->id])}}','{{$image->active}}','{{$image->capa}}','{{csrf_token()}}');" class="button icon-tick {{$col}}-gradient" title="Alterar status {{$title}}"></button>
    <button onclick="abreModal('Editar: Cor {{$image->color}}', '{{route('colors-product.edit', ['idpro' => $image->product_id,'id' => $image->id])}}', 'form-colors', 2, 'true',800,780);" class="button" title="Editar imagem {{$title}}">Editar</button>
    <button onclick="deleteColor('{{$image->id}}', '{{route('colors-product.destroy', ['idpro' => $image->product_id, 'id' => $image->id])}}');" class="button icon-trash red-gradient" title="Excluir imagem {{$title}}"></button>
</span>
