@php
    ($image->active == constLang('active_true') ? $col = 'green' : $col = 'red');
@endphp
@if($action == 'add')
	<li id="img-positions-{{$image->id}}">
@endif
@if($action == 'add' || $action == 'update')
	<img src="{{url($path.$image->image)}}" class="framed">
	<div class="controls">
		<span id="btns-{{$image->id}}" class="button-group compact children-tooltip">
			<button id onclick="statusPosition('{{$image->id}}','{{route('status-position', $image->id)}}','{{$image->active}}','{{csrf_token()}}');" class="button icon-tick {{$col}}-gradient" title="Alterar status"></button>
			<button onclick="abreModal('Editar: Posição', '{{route('positions-product.edit', ['idimg' => $image->image_color_id,'id' => $image->id])}}', 'form-positions', 2, 'true',800,780);" class="button" title="Editar imagem">Editar</button>
			<button onclick="deletePosition('{{$image->id}}', '{{route('positions-product.destroy', ['idimg' => $image->image_color_id, 'id' => $image->id])}}');" class="button icon-trash red-gradient" title="Excluir imagem"></button>
		</span>
	</div>
@endif
@if($action == 'add')
 </li>
@endif
@if($action == 'status')
	<button id onclick="statusPosition('{{$image->id}}','{{route('status-position', $image->id)}}','{{$image->active}}','{{csrf_token()}}');" class="button icon-tick {{$col}}-gradient" title="Alterar status"></button>
	<button onclick="abreModal('Editar: Posição', '{{route('positions-product.edit', ['idimg' => $image->image_color_id,'id' => $image->id])}}', 'form-positions', 2, 'true',800,780);" class="button" title="Editar imagem">Editar</button>
	<button onclick="deletePosition('{{$image->id}}', '{{route('positions-product.destroy', ['idimg' => $image->image_color_id, 'id' => $image->id])}}');" class="button icon-trash red-gradient" title="Excluir imagem"></button>
@endif