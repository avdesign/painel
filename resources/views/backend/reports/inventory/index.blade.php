<div class="block-title">
    <h3><span class="icon-read"> </span><strong> {{constLang('messages.catalog.title')}}</strong></h3>
</div>
<!-- DataTables -->
<link rel="stylesheet" href="{{ mix('backend/css/tables/'.$confUser->table_color.'.css') }}">
<table class="table responsive-table" id="inventory">
    <thead>
    <tr>
        <th scope="col" width="7%" class="align-center"></th>
        <th scope="col" width="23%">{{constLang('product')}}</th>
        <th scope="col" width="20%" class="align-center">{{constLang('attributes')}}</th>
        <th scope="col" width="20%" class="align-center">{{constLang('stock')}}</th>
        <th scope="col" width="20%" class="align-center">{{constLang('values')}}</th>
        <th scope="col" width="10%" class="align-center">{{constLang('date')}}</th>
        <th width="2%"></th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="7"></td>
    </tr>
    </tfoot>
</table>
<script src="{{ mix('backend/scripts/reports/inventory.min.js') }}"></script>
<script>
    var tableInventary = {!! json_encode([
        "id" => 'inventory',
        "url" => route('inventory.data'),
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
<script id="painel-inventory" type="text/x-handlebars-template">
    <div id="painel_@{{{id}}}" class="content-panel margin-bottom">
        <div class="panel-navigation silver-gradient">
            <div class="panel-control"></div>
            <div class="panel-load-target scrollable" style="height:490px">
                <div class="navigable">
                    <ul class="files-list mini open-on-panel-content">
                        @can('inventory-view')
                            <li>
                                <a href="inventory/@{{{id}}}/details" class="file-link">
                                    <span class="icon file-css"></span>
                                    {{constLang('messages.inventory.title_note')}}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel-content linen navigable">
            <div class="panel-load-target scrollable with-padding" style="height:450px">
                <div class="block">
                    <div class="with-padding"> @{{{details}}} </div>
                </div>
            </div>
        </div>
    </div>
</script>
<script>
    $.fn.loadTableInventory();
</script>