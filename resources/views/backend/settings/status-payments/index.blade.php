<div class="block-title silver-gradient">
	<h3><span class="icon icon-tick green" title="icon-tick"> </span> <strong> {{$title}} </strong></h3>
	<div class="button-group absolute-right compact">
		@can('config-status-payments-delete')
			<button id="btn-excluded" onclick="statusPaymentsExcluded('{{route('status.payments.excluded')}}')" class="button icon-trash margin-left red-gradient glossy ">Excluidos</button>
		@endcan
		@can('config-status-payments-create')
		    <button 
    			onclick="abreModal('{{$title_create}}', '{{route('status-payments.create')}}', 'name', 2, true, 400, 350)"
    			class="button icon-plus-round with-tooltip blue-gradient" 
    			title="{{$title_create}}">Adicionar
    		</button>
		@endcan
	</div>	
</div>

<div id="load-status-excluded"></div>
<div class="silver-gradient">
	<div id="status-payments" class="with-padding">
		<dl class="accordion same-height">
			@foreach($data as $value)
				<dt id="status-payments-{{$value->id}}"><strong>{{$value->order}}</strong> - {{$value->label}}
					<div class="button-group absolute-right compact margin">
						<a href="javascript:deleteStatusPayments('status-payments-{{$value->id}}', '{{route('status-payments.destroy', $value->id)}}', '{{csrf_token()}}')" class="button icon-trash with-tooltip confirm red-gradient" title="Excluir"></a>
						<button onclick="abreModal('{{$title_edit}}', '{{route('status-payments.edit', $value->id)}}', 'status-payments', 2, true, 400, 350)" class="button icon-pencil">Editar</button>

					</div>	
				</dt>
				<dd>
					<div class="with-padding">						
						<strong>Descrição: </strong>{{$value->description}}
					</div>
				</dd>
			@endforeach
		</dl>
	</div>
</div>
<script src="{{mix('backend/scripts/settings/status-payments.min.js')}}"></script>
<script>
    var tableStatusPayments = {!! json_encode([
        "id" => 'status-payments',
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