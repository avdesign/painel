<div class="block-title silver-gradient">
    <h3>
        <span class="icon-tag">
        <strong> {{$title}} </strong>
        </span>
    </h3>
    @can('config-unit-measure-create')
        <span class="button-group absolute-right with-tooltip">
            <button 
                onclick="abreModal('{{$title_create}}', '{{route('units-measures.create')}}', 'unit-measures', 2, true, 400, 220)"
                class="button icon-plus-round with-tooltip anthracite-gradient" 
                title="{{$title_create}}">Adicionar
            </button>
        </span>
    @endcan
</div>

<!-- DataTables -->
<link rel="stylesheet" href="{{ mix('backend/css/tables/'.$confUser->table_color.'.css')}}">

<table class="table responsive-table" id="unit-measures">
	<thead>
		<tr>
            <th scope="col" width="10%" class="align-center">Ordem</th>
			<th scope="col" width="10%" class="align-center">Unidade</th>
            <th scope="col" class="align-center">Nome</th>
            <th scope="col" width="10%" class="align-center">Status</th>
			<th scope="col" width="20%" class="align-center">Ações</th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<td colspan="5"></td>
		</tr>
	</tfoot>
</table>
<script src="{{mix('backend/scripts/settings/unit-measures.min.js')}}"></script>
<script>
    var avdTable = {!! json_encode([
        "id" => 'unit-measures',
        "url" => route('units-measures.data'),
        "txtConfirm" => "Você confirma a exclusão",
        "txtCancel" => "A Exclusão foi Cancelada!",
        "txtError" => "Houve um erro no servidor!",
        "txtLoader" => "Aguarde",
        "txtSave" => "Salvar",
        "txtUpdate" => "Alterar",
        "token" => csrf_token(),
        "color" => $confUser->table_color,
        "limit" => $confUser->table_limit,
        "tableStyled" => false
    ]) !!};
</script>

<script>
$.fn.loadTableUnitMeasure();    
</script>
