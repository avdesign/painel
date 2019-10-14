

<div class="block-title silver-gradient">
    <h3>
        <span class="icon-tag">
        <strong> {{$title}} </strong>
        </span>
    </h3>
    @can('config-keyword-create')
        <span class="button-group absolute-right with-tooltip">
            <button 
                onclick="abreModal('{{$title_create}}', '{{route('keywords.create')}}', 'name', 2, true, 450, 450)" 
                class="button icon-plus-round with-tooltip anthracite-gradient" 
                title="{{$title_create}}">Adicionar
            </button>
        </span>
    @endcan
</div>

<!-- DataTables -->
<link rel="stylesheet" href="{{ mix('backend/css/tables/'.$confUser->table_color.'.css')}}">

<table class="table responsive-table" id="keywords">
	<thead>
		<tr>
			<th scope="col" width="25%" class="align-center">Titulo</th>
			<th scope="col" class="align-center hide-on-mobile-portrait">Descrição</th>
			<th scope="col" width="10%" class="align-center">Status</th>
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

<script src="{{mix('backend/scripts/settings/keywords.min.js')}}"></script>
<script>
    var avdTable = {!! json_encode([
        "id" => 'keywords',
        "url" => route('keywords.data'),
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

<script id="keywords-template" type="text/x-handlebars-template">
    <div id="keywords-@{{{id}}}">
		<p class="boxed left-border silver-gradient"><strong>Gêneros: </strong>@{{{genders}}}</p>
		<p class="boxed left-border silver-gradient"><strong>Categorias: </strong>@{{{categories}}}</p>
		<p class="boxed left-border silver-gradient"><strong>Tags: </strong>@{{{keywords}}}</p>
    </div>
</script>

<script>
$.fn.loadTableKeywords();    
</script>
