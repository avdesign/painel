<div class="columns">

    <div class="four-columns twelve-columns-mobile">
        <img src="{{$image}}">

        <ul class="blocks-list fixed-size-100 ">
            @if($data->image->cover == 1)
                <li>{{constLang('image')}} {{constLang('cover')}}</li>
            @endif
        </ul>
    </div>

    <div class="eight-columns twelve-columns-mobile">
        <p class="underline"><strong>{{$product->kit_name}} {{$product->unit}} {{$product->measure}}</strong></p>
        <p class="underline">Grade: <strong>{{$data->grid}}</strong></p>
        <p class="underline">Entrada: <strong>{{$data->input}}</strong></p>
        <p class="underline">Saida: <strong>{{$data->output}}</strong></p>
        <p class="underline">Total: <strong>{{$data->stock}}</strong></p>
    </div>

    <div class="new-row twelve-columns twelve-columns-mobile">
        <form id="form-stock-{{$data->id}}" action="{{route('stock.update', $data->id)}}" onsubmit="return false">
            @method('PUT')
            @csrf()
            <p class="button-height">
                <span class="input">
                    <label for="qty-min-max" class="button blue-gradient">
                        <span class="small-margin-right">Quantidade de Saida</span>
                    </label>
                    <input type="number" name="qty" class="input-unstyled input-sep" placeholder="Qtd" value="" style="width: 40px;">
                </span>
            </p>
            @if($configProduct->qty_min == 1 || $configProduct->qty_max == 1)
                <p class="button-height">
                    <span class="input">
                        <label for="qty-min-max" class="button blue-gradient">
                            <span class="small-margin-right">Estoque: Min / Max</span>
                        </label>
                        @if($configProduct->qty_min == 1)
                            <input type="number" name="qty_min" class="input-unstyled input-sep" placeholder="Min" value="{{$data->qty_min}}" style="width: 40px;">
                        @endif
                        @if($configProduct->qty_max == 1)
                            <input type="number" name="qty_max" class="input-unstyled" placeholder="Max" value="{{$data->qty_max}}" style="width: 40px;">
                        @endif
                    </span>
                </p>
            @endif
            <p class="button-height">
                <span class="button-group">
                    <label for="qty-min-max" class="button blue-gradient">
                        <span class="small-margin-right">{{constLang('messages.inventory.motive.label')}}</span>
                    </label>
                    <label for="motive-1" class="button green-active">
                        <input type="radio" name="motive" id="motive-1" value="1" checked>
                        {{constLang('messages.inventory.motive.1')}}
                    </label>
                    <label for="motive-2" class="button green-active">
                        <input type="radio" name="motive" id="motive-2" value="2">
                        {{constLang('messages.inventory.motive.2')}}
                    </label>
                    <label for="motive-3" class="button green-active">
                        <input type="radio" name="motive" id="motive-3" value="3">
                        {{constLang('messages.inventory.motive.3')}}
                    </label>
                </span>
            </p>
            <p class="button-height block-label">
                <label for="input" class="label">
                    <small>Descreva o motivo</small>
                    Observação
                </label>
                <textarea name="note" rows="3" class="input full-width"></textarea>
            </p>
            <p class="button-height align-center">
                <span class="button-group">
                    <button onclick="fechaModal()" class="button"> Cancelar </button>
                        <button id="btn-modal" onclick="formStock('exit', '{{$data->id}}')" class="button blue-gradient">
                        <span class="icon-outbox"></span> Alterar
                    </button>
                </span>
            </p>
            <input type="hidden" name="ac" value="exit">
        </form>
    </div>
</div>
