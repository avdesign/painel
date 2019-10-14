<form id="form-colors" method="post" action="{{route('colors-product.update', ['idpro' => $data->product_id, 'id' => $data->id])}}" enctype="multipart/form-data">
    <input type="hidden" name="img[ac]" value="update" checked>
    <input type="hidden" name="img[kit]" value="{{$kit}}" checked>
    <input type="hidden" name="img[product_id]" value="{{$data->product_id}}">
    @method("PUT")
    @csrf
    <!-- Modules: hexa -->
    <div class="columns">
        <!-- form -->
        <div class="four-columns twelve-columns-tablet">
            <!-- Form: colors -->
            @include('backend.colors.form_hexa-edit')
            <!-- Modulo: grids -->
            @if($configProduct->grids === 1)
                @include('backend.colors-grids.layout-edit')
            @endif

        </div>
        <!-- canvas -->
        <div class="six-columns eight-columns-tablet">
            <h4 class="green underline">Tamanho {{$pixel->width}}x{{$pixel->height}} pixels</h4>
            <div class="wrapped margin-bottom">
                <p class="button-height">
                    <input type="file" name="file" id="uploadCanvas" value="" class="file" onmouseover="createCanvas(350,350)" onchange="loadCanvasFile()" />
                    <img id="slika" style="display:none" src="{{url($path.$data->image)}}">
                    <canvas onmouseover="createCanvas(350,350)" id="myCanvas" width="350" height="350" style="margin-top:10px;">
                        O seu navegador não suporta a etiqueta HTML5 para canvas.
                    </canvas>
                </p>
            </div>

            <div id="submit-colors" align="center">
                <button id="btn-colors" type="submit" class="button glossy">
                    Atualizar
                    <span  class="button-icon right-side"><span class="icon-redo"></span></span>
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
                    <input type="text" name="img[html]" id="pixcolor" value="{{$data->html}}" class="input" maxlength="7" style="width:82px">
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