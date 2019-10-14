<div class="block-title silver-gradient">
    <h3>
        <span class="icon-users">
        <strong> {{$title}} </strong>
        </span>
    </h3>
    @can('config-profile-client-ceate')
        <span class="button-group absolute-right with-tooltip">
            <button 
                onclick="abreModal('{{$title_create}}', '{{route('customers-perfil.create')}}', 'prices', 2, true, 380, 300)"
                class="button icon-plus-round with-tooltip anthracite-gradient" 
                title="{{$title_create}}">Adicionar
            </button>
        </span>
    @endcan
</div>

<!-- DataTables -->
<link rel="stylesheet" href="{{ mix('backend/css/tables/'.$confUser->table_color.'.css')}}">

<table class="table responsive-table" id="profile-clients">
	<thead>
		<tr>
            <th scope="col" width="10%" class="align-center">Ordem</th>
            <th scope="col" width="20%" class="align-center">Perfil</th>
			<th scope="col" width="10%" class="align-center">% Parcelado</th>
            <th scope="col" width="10%" class="align-center">% À Vísta</th>
            <th scope="col" width="10%" class="align-center">Para</th>
            <th scope="col" class="align-center">Status</th>
			<th scope="col" width="30%" class="align-center">Ações</th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<td colspan="7"></td>
		</tr>
	</tfoot>
</table>
<script src="{{mix('backend/scripts/settings/customers-perfil.min.js')}}"></script>
<script>
    var avdTable = {!! json_encode([
        "id" => 'profile-clients',
        "url" => route('customers-perfil.data'),
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
$.fn.loadTableProfileClients();    
</script>
