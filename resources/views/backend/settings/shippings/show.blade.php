<dl class="accordion same-height">
	@foreach($methods as $method)
		<dt id="method-{{$method->id}}"><strong>{{$method->order}}</strong> - {{$method->name}}
			<div class="button-group absolute-right compact margin">
				<a href="javascript:deleteShipping('method-{{$method->id}}', '{{route('shippings.destroy', $method->id)}}', '{{csrf_token()}}')" class="button icon-trash with-tooltip confirm red-gradient" title="Excluir"></a>
				<button onclick="abreModal('Editar {{$method->name}}', '{{route('shippings.edit', $method->id)}}', 'shippings', 2, true, 400, 400)" class="button icon-pencil">Editar</button>

			</div>	
		</dt>
		<dd>
			<div class="with-padding">						
				<strong>Descrição: </strong>{{$method->description}}
			</div>
		</dd>
	@endforeach
</dl>

