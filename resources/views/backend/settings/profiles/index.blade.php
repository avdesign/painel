<div class="block-title silver-gradient">
    <h3>
        <span class="icon-users">
        <strong> {{$title}} </strong>
        </span>
    </h3>
    @can('config-profile-create')
        <span class="button-group absolute-right with-tooltip">
    		<button 
    			onclick="abreModal('{{$title_create}}', '{{route('profiles.create')}}', 'name', 2, true, 400, 220)"
    			class="button icon-plus-round with-tooltip blue-gradient" 
    			title="{{$title_create}}">Adicionar
    		</button>
    	</span>
    @endcan
</div>

<!-- DataTables -->
<link rel="stylesheet" href="{{ mix('backend/css/tables/'.$confUser->table_color.'.css')}}">

<table class="table responsive-table" id="profiles">
	<thead>
		<tr>
			<th scope="col" width="25%" class="align-center">Perfil</th>
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
<script src="{{mix('backend/scripts/settings/profiles.min.js')}}"></script>
<script>
    var avdTable = {!! json_encode([
        "id" => 'profiles',
        "url" => route('profile.data'),
        "txtConfirm" => "Você confirma a exclusão",
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


<script id="profiles-template" type="text/x-handlebars-template">
    <div id="profiles-@{{{id}}}"></div>
</script>

<script>
$.fn.loadTableProfile();    
</script>
