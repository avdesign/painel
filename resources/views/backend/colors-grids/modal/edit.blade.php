<form id="form-grids" method="post" action="{{route('grid-color.update', $data->id)}}" return false>
    <input type="hidden" name="product_id" value="{{$data->product->id}}">
    <input type="hidden" name="grids[image_color_id]" value="{{$data->id}}">
    @method("PUT")
    @csrf
    @if($product->stock == 1)
        <p class="button-height">
            <span class="input">
                <label for="grid-{{$data->id}}" class="button blue-gradient">
                    {{constLang('stock')}}:{{$data->stock}}
                </label>
                <input type="text" name="grids[grid]" class="input-unstyled input-sep" placeholder="{{constLang('grid')}}" value="{{$data->grid}}" maxlength="6" autocomplete="off" style="width: 80px;">
            </span>
        </p>
        <p class="button-height">
            <span class="input">
                <label for="input-{{$data->id}}" class="button blue-gradient">
                    {{constLang('entry')}}
                </label>
                <input type="text" name="grids[input]" class="input-unstyled" placeholder="{{constLang('qty')}}" value="" maxlength="4" autocomplete="off" onKeyDown="javascript: return maskValor(this,event,4);" style="width: 80px;">
            </span>
        </p>
        @if($product->qty_min == 1)
            <p class="button-height">
                <span class="input">
                    <label for="min-{{$data->id}}" class="button blue-gradient">
                        {{constLang('stock')}} {{constLang('min')}}
                    </label>
                    <input type="text" name="grids[qty_min]" class="input-unstyled" value="{{$data->qty_min}}" maxlength="4" autocomplete="off" onKeyDown="javascript: return maskValor(this,event,4);" style="width: 80px;">
                </span>
            </p>
        @endif
        @if($product->qty_max == 1)
            <p class="button-height">
                <span class="input">
                    <label for="max-{{$data->id}}" class="button blue-gradient">
                        {{constLang('stock')}} {{constLang('max')}}
                    </label>
                    <input type="text" name="grids[qty_max]" class="input-unstyled input-sep" value="{{$data->qty_max}}" maxlength="4" autocomplete="off" onKeyDown="javascript: return maskValor(this,event,4);" style="width: 80px;">
                </span>
            </p>
        @endif

    @else
        <p class="button-height">
            <span class="input">
                    <label for="grid-{{$data->id}}" class="button blue-gradient">
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
                <a href="javascript:void(0);" id="btn-modal" onclick="formGridProduct('grids', 'update', '{{constLang('loader')}}', '{{constLang('update')}}')" class="button icon-redo blue-gradient"> {{constLang('update')}} </a>
            @endcan
        </span>
    </p>
</form>