<form id="form-grids" method="post" action="{{route('grid-color.store')}}" return false>
    <input type="hidden" name="product_id" value="{{$product->id}}">
    <input type="hidden" name="grids[image_color_id]" value="{{$image->id}}">
    @csrf
    @if($product->stock == 1)
        <p class="button-height">
            <span class="input">
                <label for="grid" class="button blue-gradient">
                    {{constLang('stock')}}
                </label>
                <input type="text" name="grids[grid]" class="input-unstyled input-sep" placeholder="{{constLang('grid')}}" value="" maxlength="6" autocomplete="off" style="width: 80px;">
            </span>
        </p>
        <p class="button-height">
            <span class="input">
                <label for="input" class="button blue-gradient">
                    {{constLang('entry')}}
                </label>
                <input type="text" name="grids[input]" class="input-unstyled" placeholder="{{constLang('qty')}}" value="" maxlength="4" autocomplete="off" onKeyDown="javascript: return maskValor(this,event,4);" style="width: 80px;">
            </span>
        </p>
        @if($product->qty_min == 1)
            <p class="button-height">
                <span class="input">
                    <label for="min" class="button blue-gradient">
                        {{constLang('stock')}} {{constLang('min')}}
                    </label>
                    <input type="text" name="grids[qty_min]" class="input-unstyled" value="{{$configProduct->qty_min_unit}}" maxlength="4" autocomplete="off" onKeyDown="javascript: return maskValor(this,event,4);" style="width: 80px;">
                </span>
            </p>
        @endif
        @if($product->qty_max == 1)
            <p class="button-height">
                <span class="input">
                    <label for="max" class="button blue-gradient">
                        {{constLang('stock')}} {{constLang('max')}}
                    </label>
                    <input type="text" name="grids[qty_max]" class="input-unstyled input-sep" value="{{$configProduct->qty_max_unit}}" maxlength="4" autocomplete="off" onKeyDown="javascript: return maskValor(this,event,4);" style="width: 80px;">
                </span>
            </p>
        @endif

    @else
        <p class="button-height">
            <span class="input">
                    <label for="grid" class="button blue-gradient">
                        {{constLang('grid')}}
                    </label>
                <input type="text" name="grids[grid]" class="input-unstyled input-sep" placeholder="{{constLang('grid')}}" value="" maxlength="6" autocomplete="off" style="width: 80px;">
            </span>
        </p>
    @endif
    <p class="button-height align-center">
        <span class="button-group">
            <a href="javascript:void(0);" onclick="fechaModal()" class="button"> Cancelar </a>
            @can('product-update')
                <a href="javascript:void(0);" id="btn-modal" onclick="formGridProduct('grids', 'create', '{{constLang('loader')}}', '{{constLang('save')}}')" class="button icon-redo blue-gradient"> {{constLang('save')}} </a>
            @endcan
        </span>
    </p>
</form>