@foreach ($grids as $value)
    <h4 class="green underline">{{$value->name}}</h4>
    <div class="columns">
        @php
            $label = explode(",", $value->label);
        @endphp
        <span>
            <input type="radio" id="opc-{{$value->id}}" name="opc[]" value="{{$value->label}}" class="tick checkbox mid-margin-left">
        </span>

        @foreach ($label as $val)
            <label class="button compact blue-gradient small-margin-top small-margin-left ">{{$val}}</label>
        @endforeach
        <span id="tick-{{$value->id}}" style="display:none">&nbsp;&nbsp;<span class="icon-size2 icon-tick icon-green"></span></span>
    </div>
@endforeach

<input type="hidden" id="grid" name="grids[grid]" value="">

@if($stock == 1)
    <p class="button-height block-label margin-top">
        <label for="input" class="label">Entrada no estoque</label>
        <span class="input">
            <label class="button blue-gradient">Entrada</label>
            <input type="text" name="grids[input]" class="input-unstyled" value="" placeholder="Qtd"  autocomplete="off" maxlength="4" onKeyDown="javascript: return maskValor(this,event,4);" style="width: 50px;">
        </span>
    </p>

    @if($product->qty_min == 1 || $product->qty_max == 1)
        <p class="button-height block-label">
            <label for="input" class="label">Estoque mínimo / máximo</label>
            <span class="input">
                <label for="qty_stock" class="button blue-gradient">Estoque</label>
                @if($product->qty_min == 1)
                    <input type="text" name="grids[qty_min]" value="{{$configProduct->qty_min_kit}}" placeholder="Mínimo" class="input-unstyled input-sep" autocomplete="off" maxlength="4" onKeyDown="javascript: return maskValor(this,event,4);" style="width: 50px;">
                @endif
                @if($product->qty_max == 1)
                    <input type="text" name="grids[qty_max]"  value="{{$configProduct->qty_max_kit}}" placeholder="Máximo" class="input-unstyled" autocomplete="off" maxlength="4" onKeyDown="javascript: return maskValor(this,event,4);" style="width: 50px;">
                @endif
            </span>
        </p>
    @endif

@endif

<script>
    $('.tick').on('change', function() {
        var str   = $(this).attr('id'),
            res   = str.split("-"),
            id    = res[1],
            opc   = $("#opc-"+id).val(),
            grid  = $('#grid').val(opc);
    });
</script>