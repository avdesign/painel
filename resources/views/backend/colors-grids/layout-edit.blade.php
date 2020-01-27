<fieldset class="fieldset">
    <!-- Legends of input informations -->
    @if($stock == 1)
        @if($kit == 1)
            <legend class="legend">Quantidade | Grade</legend>
        @else
            <legend class="legend">Grade | Estoque | Min/Max</legend>
        @endif
    @else
        @if($kit == 1)
            <legend class="legend">Quantidade | Grade</legend>
        @else
            <legend class="legend">Grades  </legend>

        @endif
        <div class="align-right compact">
            <a href="javascript:createGrid('{{$data->id}}','{{$stock}}','{{$kit}}');" class="button icon-plus blue-gradient" title="Adicionar"></a>
        </div>
    @endif
    <div id="update-grids">
        @if($kit == 1)
            @if($stock == 1)
                @include('backend.colors-grids.form-edit-kits-stock')
            @else
                @include('backend.colors-grids.form-edit-kits')
            @endif
        @else
            @include('backend.colors-grids.form-edit-units')
        @endif
    </div>
</fieldset>

<div align="center">
    <span id="loader-grids" class="loader working" style="display:none;"></span>
</div>  
<div id="box-grids-colors"></div>

@include('backend.colors-grids.load-script')