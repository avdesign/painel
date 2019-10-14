<dl class="accordion same-height">
	@foreach($data as $value)
		<dt id="payment-{{$value->id}}"><strong>{{$value->order}}</strong> - {{$value->label}}
			<div class="button-group absolute-right compact margin">
				<a href="javascript:deleteFormPayments('payment-{{$value->id}}', '{{route('forms-payments.destroy', $value->id)}}', '{{csrf_token()}}')" class="button icon-trash with-tooltip confirm red-gradient" title="Excluir"></a>
				<button onclick="abreModal('Editar {{$value->label}}', '{{route('forms-payments.edit', $value->id)}}', 'status-orders', 2, true, 400, 250)" class="button icon-pencil">Editar</button>
			</div>
		</dt>
		<dd>
			<div class="with-padding">
				<strong>{!! nl2br($value->description) !!}</strong>
			</div>
		</dd>
	@endforeach
</dl>

