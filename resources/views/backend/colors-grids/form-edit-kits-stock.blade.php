<div id="grids-{{$data->id}}">
    @php
        $sum_output   = 0;
        $sum_input = 0;
        $sum_stock = 0;
    @endphp
    @foreach($grids as $val)
        @php
            $idkit  = $val->id;
            $total  = $val->stock;
            $keys[] = explode(",", $val->grid);
            $sum_input += $val->input;
            $sum_output   += $val->output;
        @endphp
    @endforeach
    @foreach($keys as $values)
        @foreach($values as $key => $grid)
            @php
                $exp = explode("/", $grid);
                $qty = $exp[0];
                $grd = $exp[1];
            @endphp
            <button for="grid-{{$key}}" class="button blue-gradient margin-bottom">{{$grid}}</button>
        @endforeach
    @endforeach
    @php
        foreach ($grids as $grid) {
            $sum_stock = $grid->stock;
            $qty_min   = $grid->qty_min;
            $qty_max   = $grid->qty_max;
        }
    @endphp
</div>

<input type="hidden" name="grids[id]" value="{{$idkit}}">

<p class="button-height block-label margin-top">
    <label for="input" class="label">Entrada no estoque</label>
    <span class="input">
        <label for="pseudo-input-2" class="button blue-gradient">
            <span class="small-margin-right">Entrada</span>
        </label>
        <input type="text" name="grids[input]" id="input-{{$data->id}}" class="input-unstyled" placeholder="Qtd" value="" autocomplete="off"  maxlength="4" onKeyDown="javascript: return maskValor(this,event,4);" style="width: 50px;">
        <label for="pseudo-input-2" class="button blue-gradient">
            <span class="small-margin-right">{{$sum_stock}}</span>
        </label>
    </span>
</p>

@if($product->qty_min == 1 || $product->qty_max == 1)
    <p class="button-height block-label">
        <label for="input" class="label">Estoque mínimo / máximo</label>
        <span class="input">
            <label for="qty_stock" class="button blue-gradient">Estoque</label>
            @if($product->qty_min == 1)
                <input type="text" name="grids[qty_min]" value="{{$qty_min}}" placeholder="Mínimo" class="input-unstyled input-sep" autocomplete="off" maxlength="4" onKeyDown="javascript: return maskValor(this,event,4);" style="width: 50px;">
            @endif
            @if($product->qty_max == 1)
                <input type="text" name="grids[qty_max]"  value="{{$qty_max}}" placeholder="Máximo" class="input-unstyled" autocomplete="off" maxlength="4" onKeyDown="javascript: return maskValor(this,event,4);" style="width: 50px;">
            @endif
        </span>
    </p>
@endif





