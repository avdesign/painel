<p class="block-label button-height">
    <label for="grid_colors" class="label">Grades<span class="red"> *</span></label>
    <select id="opc-grids" name="grid" class="grid_colors select">
        <option value="">Selecione Uma</option>
        <option value="brand">Fabricante</option>
        <option value="section">Seção</option>
        <option value="category">Categoria</option>
    </select>
    <!-- Exige quando for adicionar uma cor ou posição -->
    @isset($product)
        <input id="bra_id" type="hidden" value="{{$product->brand_id}}">
        <input id="sec_id" type="hidden" value="{{$product->section_id}}">
        <input id="cat_id" type="hidden" value="{{$product->category_id}}">
        <input id="sto_id" name="prod[stock]" type="hidden" value="{{$product->stock}}">
        <input id="kit_id" name="prod[kit]" type="hidden" value="{{$product->kit}}">
    @endisset
</p>

<div align="center">
    <span id="loader-grids" class="loader working" style="display:none;"></span>
</div>  
<div id="box-grids-colors"></div>
@include('backend.colors-grids.load-script')