<div class="block-title silver-gradient">
	<h3><span class="icon icon-credit-card" title="icon-tick"> </span> <strong> {{$title}} </strong></h3>
	<div class="button-group absolute-right compact">
		@can('config-form-payment-delete')
			<button id="btn-excluded" onclick="formPaymentsExcluded('{{route('forms-payments.excluded')}}')" class="button icon-trash margin-left red-gradient glossy ">Excluidos</button>
		@endcan
		@can('config-form-payment-create')
		    <button 
    			onclick="abreModal('{{$title_create}}', '{{route('forms-payments.create')}}', 'name', 2, true, 400, 250)"
    			class="button icon-plus-round with-tooltip blue-gradient" 
    			title="{{$title_create}}">Adicionar
    		</button>
		@endcan
	</div>	
</div>

<div id="load-payments-excluded"></div>
<div class="silver-gradient">
	<div id="payments" class="with-padding">
		<dl class="accordion same-height">
			@foreach($data as $value)
				<dt id="payment-{{$value->id}}"><strong>{{$value->order}}</strong> - {{$value->label}}
					<div class="button-group absolute-right compact margin">
						<a href="javascript:deleteFormPayments('payment-{{$value->id}}', '{{route('forms-payments.destroy', $value->id)}}', '{{csrf_token()}}')" class="button icon-trash with-tooltip confirm red-gradient" title="Excluir"></a>
						<button onclick="abreModal('{{$title_edit}}', '{{route('forms-payments.edit', $value->id)}}', 'payments', 2, true, 400, 250)" class="button icon-pencil">Editar</button>

					</div>	
				</dt>
				<dd>
					<div class="with-padding">						
						<strong>{!! nl2br($value->description) !!}</strong>
					</div>
				</dd>
			@endforeach
		</dl>
	</div>
</div>
<script src="{{mix('backend/scripts/settings/forms-payments.min.js')}}"></script>
<script>
    var tableFormPayments = {!! json_encode([
        "txtConfirm" => "Você confirma a exclusão",
        "txtCancel" => "A Exclusão foi Cancelada!",
        "txtError" => "Houve um erro no servidor!",
        "txtLoader" => "Aguarde",
        "txtSave" => "Salvar",
        "txtUpdate" => "Alterar",
        "txtExcluded" => "Excluidos",
        "token" => csrf_token()
    ]) !!};
</script>