<form id="form-colors" method="post" action="{{route('colors-product.store', $idpro)}}" enctype="multipart/form-data">
    @csrf
    @if($configProduct->stock == 1)
        <!-- Altera o value ao clicar no btn stock -->
        @if(isset($product))
            <input type="hidden" id="grid_stock" name="stock" value="{{$product->stock}}">
        @else
            <input type="hidden" id="grid_stock" name="stock" value="1">
        @endif
    @else
        <input type="hidden" id="grid_stock" name="stock" value="0">
    @endif

    @if($configProduct->kit == 1)
        <!-- Altera o value ao clicar no btn kit -->
        @if(isset($product))
            <input type="hidden" id="grid_kit" name="kit" value="{{$product->kit}}">
        @else
            <input type="hidden" id="grid_kit" name="kit" value="1">
        @endif
    @else
        <input type="hidden" id="grid_kit" name="kit" value="0">
    @endif

    <span id="insert_product"><!-- inserir input hidden produto_id com jquery  --></span>

    @if(isset($product))
        <!--inserir uma ac adicionar com o campo  product_id -->
        <input type="hidden" name="img[ac]" value="add">
        <input type="hidden" name="img[product_id]" value="{{$product->id}}">
        <input type="hidden" name="img[brand]" value="{{$product->brand}}">
        <input type="hidden" name="img[category]" value="{{$product->section}}">
        <input type="hidden" name="img[section]" value="{{$product->category}}">
        <input type="hidden" name="img[product_name]" value="{{$product->name}}">
    @else
        <input type="hidden" name="img[ac]" value="create">
    @endif
    <!-- Modules: hexa -->
    <div class="columns">
        <!-- form -->
        <div class="four-columns twelve-columns-tablet">
            <!-- Form: colors -->
            @include('backend.colors.form_hexa')


            <!-- Modulo: grids -->
            @if($configProduct->grids == 1)
                @include('backend.colors-grids.layout-create')
            @endif

        </div>
        <!-- canvas -->
        <div class="six-columns eight-columns-tablet">
            <h4 class="green underline">Tamanho {{$pixel->width}}x{{$pixel->height}} pixels</h4>
            <div class="wrapped margin-bottom">
                <p class="button-height">
                    <input type="file" name="file" id="uploadCanvas" value="" class="file" onmouseover="createCanvas(350,350)" onchange="loadCanvasFile()" />
                    <img id="slika" style="display:none" src="">
                    <canvas onmouseover="createCanvas(350,350)" id="myCanvas" width="350" height="350" style="margin-top:10px;">
                        O seu navegador não suporta a etiqueta HTML5 para canvas.
                    </canvas>
                </p>
            </div>

            <div id="submit-colors" align="center">
                <button id="btn-colors" type="submit" class="button glossy">
                    Salvar
                    <span  class="button-icon right-side"><span class="icon-forward"></span></span>
                </button>
            </div>

        </div>
        <!-- miniaturas -->
        <div class="two-columns two-columns-tablet">
            <h4 class="green underline">Miniatura</h4>
            <div class="wrapped margin-bottom">
                <div align="center">
                    <a href="javascript:createCanvas(350,350)" class="button icon-camera">Cortar</a>
                </div>
                <div  align="center">
                    <canvas  id="pixCanvas" width="100%" height="100%" style="margin-top:10px; z-index:0;">
                        O seu navegador não suporta a etiqueta HTML5 para canvas.
                    </canvas>
                </div>
                <div class="button-height" align="center">
                    <input type="text" name="img[html]" id="pixcolor" value="" class="input" maxlength="7" style="width:82px">
                    <p id="barvadiv" style="margin-top:2px;width:100px;height:100px"></p>
                </div>

                @if($configProduct->group_colors == 1)                    
                    @include('backend.colors-groups.group_hexa')
                @endif

            </div>
        </div>
    </div>
</form>
<script src="{{mix('backend/js/avd.hexa.min.js')}}"></script>
<script>createCanvas(350,350);</script>