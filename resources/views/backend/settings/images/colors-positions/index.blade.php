<div class="block-title silver-gradient">
    <h3>
        <span class="icon-camera">
        <strong> {{$title}} </strong>
        </span>
    </h3>
    @can('config-keyword-ceate')
        <span class="button-group absolute-right with-tooltip">
            <button 
                onclick="abreModal('{{$title_create}}', '{{route('colors-positions.create')}}', 'config-images', 2, true, 400, 250)"
                class="button icon-plus-round with-tooltip anthracite-gradient" 
                title="{{$title_create}}">Adicionar
            </button>
        </span>
    @endcan
</div>

<!-- DataTables -->
<link rel="stylesheet" href="{{ mix('backend/css/tables/'.$confUser->table_color.'.css')}}">

<table class="table responsive-table" id="config-images">
    <thead>
        <tr>
            <th scope="col" width="5%" class="align-center hide-on-mobile">Tipo</th>
            <th scope="col" width="5%" class="align-center hide-on-mobile">Largura</th>
            <th scope="col" width="5%" class="align-center hide-on-mobile-portrait">Altura</th>
            <th scope="col" width="5%" class="align-center hide-on-mobile-portrait">Padrão</th>
            <th scope="col">Pasta</th>
            <th scope="col" width="15%" class="align-center">Açoes</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="6"></td>
        </tr>
    </tfoot>
</table>

<script src="{{mix('backend/scripts/settings/colors-positions.min.js')}}"></script>
<script>
    var avdTable = {!! json_encode([
        "id" => 'config-images',
        "url" => route('config.colors-positions.data'),
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
$.fn.loadTableConfigImagesProducts();    
</script>
