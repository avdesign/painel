@foreach ($grids as $value)
    @php
        if($product->stock == 1){

            $text_entry = constLang('stock').':';
            $text_qty = constLang('qty');
            ($product->qty_min == 1 ? $text_min = '/'.constLang('min') : $text_min = '');
            ($product->qty_max == 1 ? $text_max = '/'.constLang('max') : $text_max = '');
        }
    @endphp
    <h4 class="green underline">
       {{$text_entry}}{{$text_qty}}{{$text_min}}{{$text_max}}
    </h4>
    <p class="margin-bottom">
        <span class="button-group">
            <a class="button compact"> {{$value->name}}</a>
            <a href="javascript:plusUndProd('{{$product->stock}}', '{{$product->qty_min}}', '{{$product->qty_max}}');" class="button compact" title="{{constLang('add')}}">
                {{constLang('add')}} {{constLang('grid')}}
                <span class="button-icon  blue-gradient right-side"><span class="icon-plus"></span></span>
            </a>
        </span>
    </p>
    <div class="margin-bottom" id="puls_grid"></div>
    <div class="columns">
        @php
            $label = explode(",", $value->label);
        @endphp
        @foreach ($label as $str)
            @php  $val = str_replace('/', '_', trim($str)); @endphp
            <p class="minus_grid button-height">
                @if($stock == 1)
                    <span class="input">
                        <label for="size-{{$val}}" class="button blue-gradient">{{$str}}</label>
                        <input type="hidden" id="grid-{{$val}}" name="grids[grid][]" class="input-unstyled" placeholder="{{constLang('grid')}}" value="{{$val}}" autocomplete="off" style="width: 60px;">
                        <input type="text" id="input-{{$val}}" name="grids[input][]" class="input-unstyled" placeholder="{{strtolower($text_qty)}}" value="" autocomplete="off" style="width: 30px;">
                    </span>
                    <span class="input">
                        @if($product->qty_min == 1)
                            <input type="text" id="qty_min-{{$val}}" name="grids[qty_min][]" placeholder="min" class="input-unstyled input-sep"  value="{{$configProduct->qty_min_unit}}" autocomplete="off" onKeyDown="javascript: return maskValor(this,event,4);" style="width: 30px;">
                        @endif
                        @if($product->qty_max == 1)
                            <input type="text" id="qty_max-{{$val}}" name="grids[qty_max][]" placeholder="max" class="input-unstyled"  value="{{$configProduct->qty_max_unit}}" autocomplete="off" onKeyDown="javascript: return maskValor(this,event,4);" style="width: 30px;">
                        @endif
                    </span>
                @else
                    <label for="size-{{$val}}" class="button blue-gradient">{{$str}}</label>
                    <input type="hidden" id="grid-{{$val}}" name="grids[grid]" class="input-unstyled" placeholder="{{constLang('grid')}}" value="" autocomplete="off" onKeyDown="javascript: return maskValor(this,event,4);" style="width: 30px;">
                @endif
                <a href="javascript:void(0);" onclick="removeGridProd(this,'.minus_grid');" class="remove compact button red-gradient icon-minus" title="{{constLang('deleted')}}"></a>
            </p>
        @endforeach
    </div>
@endforeach

<script>

    /**
     * add grid unit
     */
    function plusUndProd(stock, qty_min, qty_max) {
        var stock_qty,stock_qty_min,stock_qty_max,inputs,btn_minus,onclick="removeGridProd(this,'.minus_grid');";
        if (stock == 1) {
            var stock_qty = '<input type="text" name="grids[input][]" class="input-unstyled input-sep" placeholder="{{strtolower($text_qty)}}" value="" autocomplete="off" style="width: 30px;">';
            if (qty_min == 1) {
                stock_qty_min = '<input type="text" name="grids[qty_min][]" placeholder="min" class="input-unstyled input-sep" value="{{$configProduct->qty_min_unit}}" autocomplete="off" style="width: 30px;">';
            }
            if (qty_max == 1) {
                stock_qty_max = '<input type="text" name="grids[qty_max][]" placeholder="max" class="input-unstyled" value="{{$configProduct->qty_max_unit}}" autocomplete="off" style="width: 30px;">';
            }
            inputs = '&nbsp<span class="input">' + stock_qty_min + stock_qty_max + '</span>';
            btn_minus = '&nbsp<a href="javascript:void(0);" onclick="'+onclick+'" class="remove button compact red-gradient icon-minus" title="{{constLang('remove')}}"></a>';
        }
        $("#puls_grid").append('<p class="minus_grid button-height"><span class="input">'+
            '<input type="text" name="grids[grid][]" class="input-unstyled input-sep" placeholder="{{constLang('grid')}}" value="" autocomplete="off" style="width: 50px;">'+
            stock_qty + '</span>'+ inputs + btn_minus+'</p>');
    }
    /**
     * Remover input Unit
     */
    function removeGridProd(_this, id) {
        $(_this).parents(id).remove();
    }
</script>