<div class="block-title silver-gradient">
    <h3>
        <span class="icon-lock">
        <strong> {{$title}} </strong>
        </span>
    </h3>
    @can('config-permission-create')
        <span class="button-group absolute-right with-tooltip">
    		<button 
    			onclick="abreModal('{{$title_create}}', '{{route('permissions.create')}}', 'name', 2, true, 400, 220)"
    			class="button icon-plus-round with-tooltip blue-gradient" 
    			title="{{$title_create}}">Adicionar
    		</button>
    	</span>
    @endcan
</div>

<!-- DataTables -->
<link rel="stylesheet" href="{{ mix('backend/css/tables/'.$confUser->table_color.'.css')}}">

<table class="table responsive-table" id="permissions">
	<thead>
		<tr>
			<th scope="col" width="25%" class="align-center">Permissão</th>
			<th scope="col" class="align-center hide-on-mobile-portrait">Descrição</th>
			<th scope="col" width="15%" class="align-center">Ações</th>
            <th scope="col" class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" aria-label="" style="width: 12px;"></th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<td colspan="4"></td>
		</tr>
	</tfoot>
</table>

<script src="{{mix('backend/scripts/settings/permissions.min.js')}}"></script>
<script>
    var avdTable = {!! json_encode([
        "id" => 'permissions',
        "url" => route('permission.data'),
        "limit" => 10,
        "txtConfirm" => "Você confirma a exclusão de",
        "txtCancel" => "A Exclusão foi Cancelada!",
        "txtError" => "Houve um erro no servidor!",
        "txtSave" => "Salvar",
        "txtUpdate" => "Alterar",
        "txtLoader" => "Aguarde",
        "token" => csrf_token(),
        "color" => $confUser->table_color,
        "colorSel" => $confUser->table_color_sel." glossy",
        "openDetails" => $confUser->table_open_details,
        "limit" => $confUser->table_limit,
        "tableStyled" => false
    ]) !!};
</script>

<script id="permissions-template" type="text/x-handlebars-template">
    <div id="permissions-@{{{id}}}"></div>
</script>

<script>
$.fn.loadTableProfile();    
</script>
