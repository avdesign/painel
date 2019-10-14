<div class="block-title silver-gradient">
    <h3>
        <span class="icon-users">
        <strong> {{$title}} </strong>
        </span>
    </h3>
    @can('config-module-create')
        <span class="button-group absolute-right with-tooltip">
            <button 
                onclick="abreModal('{{$title_create}}', '{{route('modules.create')}}', 'name', 2, true, 400, 220)"
                class="button icon-plus-round with-tooltip anthracite-gradient" 
                title="{{$title_create}}">Adicionar
            </button>
        </span>
    @endcan
</div>

<!-- DataTables -->
<link rel="stylesheet" href="{{ mix('backend/css/tables/'.$confUser->table_color.'.css')}}">

<table class="table responsive-table" id="modules">
	<thead>
		<tr>
			<th scope="col" width="25%" class="align-center">Modulo</th>
            <th scope="col" width="5%" class="align-center">Tipo</th>
            <th scope="col" width="5%" class="align-center">Ordem</th>
			<th scope="col" class="align-center hide-on-mobile-portrait">Descrição</th>
			<th scope="col" width="20%" class="align-center">Ações</th>
            <th scope="col" class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" aria-label="" style="width: 12px;"></th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<td colspan="6"></td>
		</tr>
	</tfoot>
</table>

<script src="{{mix('backend/scripts/settings/modules.min.js')}}?{{time()}}"></script>
<script>
    var avdTable = {!! json_encode([
        "id" => 'modules',
        "url" => route('module.data'),
        "txtConfirm" => "Você confirma a exclusão",
        "txtCancel" => "A Exclusão foi Cancelada!",
        "txtError" => "Houve um erro no servidor!",
        "txtLoader" => "Aguarde",
        "txtSave" => "Salvar",
        "txtUpdate" => "Alterar",
        "token" => csrf_token(),
        "color" => $confUser->table_color,
        "colorSel" => $confUser->table_color_sel." glossy",
        "openDetails" => $confUser->table_open_details,
        "limit" => $confUser->table_limit,
        "tableStyled" => false
    ]) !!};
</script>

<script id="modules-template" type="text/x-handlebars-template">
    <div id="modules-@{{{id}}}"></div>
</script>

<script>
$.fn.loadTableProfile();    
</script>
