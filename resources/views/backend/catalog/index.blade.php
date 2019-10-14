<div class="block-title">
    <h3><span class="icon-read"> </span><strong> {{constLang('messages.catalog.title')}}</strong></h3>
</div>

<!-- DataTables -->
<link rel="stylesheet" href="{{ mix('backend/css/tables/'.$confUser->table_color.'.css') }}">

<table class="table responsive-table" id="catalog_colors">
    <thead>
    <tr>
        <th scope="col" width="7%" class="align-center">Foto</th>
        <th scope="col" width="10%" class="align-center">Código</th>
        <th scope="col" width="10%" class="align-center">Cor</th>
        <th scope="col" width="10%" class="align-center">Categoria</th>
        <th scope="col" width="10%" class="align-center">Seção</th>
        <th scope="col" width="10%" class="align-center">Marca</th>
        <th scope="col" width="5%" class="align-center">Visitas</th>
        <th scope="col" width="10%" class="align-center">Status</th>
        <th scope="col" width="15%" class="align-center">Ações</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="9"></td>
    </tr>
    </tfoot>
</table>

<script src="{{ mix('backend/scripts/products/catalog.min.js') }}"></script>
<script src="{{ mix('backend/scripts/products/grids.min.js') }}"></script>
<script src="{{ mix('backend/js/libs/formData/jquery.form.min.js') }}"></script>

<script>
    var tableCatalog = {!! json_encode([
        "id" => 'catalog_colors',
        "url" => route('catalog.data'),
        "txtConfirm" => "Você confirma a exclusão do produto ",
        "txtCancel" => "A Exclusão foi Cancelada!",
        "txtError" => "Houve um erro no servidor!",
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

<script>
    $.fn.loadTableCatalog();
</script>

