<div class="block-title">
    <h3><span class="icon-line-graph icon-size2"> </span><strong> {{constLang('messages.stock.title')}}</strong></h3>
</div>

<!-- DataTables -->
<link rel="stylesheet" href="{{ mix('backend/css/tables/'.$confUser->table_color.'.css') }}">

<table class="table responsive-table" id="stock-controll">
    <thead>
    <tr>
        <th scope="col" width="7%" class="align-center">Foto</th>
        <th scope="col" width="13%" class="align-center">Descrição</th>
        <th scope="col" width="19%" class="align-center">Referências</th>
        <th scope="col" width="19%" class="align-center">Grade</th>
        <th scope="col" width="15%" class="align-center">Estoque</th>
        <th scope="col" width="15%" class="align-center">Quantidade</th>
        <th scope="col" width="12%" class="align-center">Ações</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="6"></td>
    </tr>
    </tfoot>
</table>

<script src="{{ mix('backend/scripts/products/stock.min.js') }}"></script>
<script src="{{ mix('backend/js/libs/formData/jquery.form.min.js') }}"></script>

<script>
    var tableStock = {!! json_encode([
        "id" => 'stock-controll',
        "url" => route('stock.data'),
        "txtConfirm" => "Você confirma a alteração do estoque ",
        "txtCancel" => "A alteração foi Cancelada!",
        "txtError" => "Houve um erro no servidor!",
        "txtLoad" => "Aguarde...",
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
    $.fn.loadTableStock();
</script>

