<h4 class="green underline">Atributos da Imagem</h4>
<div class="fieldset silver-bg">
    <p class="block-label button-height">
        <label for="code_img_{{$idpro}}" class="label">Código<span class="red">*</span></label>
        <input type="text" name="img[code]" id="code_img_{{$idpro}}" value="" autocomplete="off" class="input full-width">
    </p>
    <p class="block-label button-height">
        <label for="color_img_{{$idpro}}" class="label">Cor<span class="red">*</span></label>
        <input type="text" name="img[color]" id="color_img_{{$idpro}}" value="" autocomplete="off" class="input full-width">
    </p>
    <p class="block-label button-height">
        <label for="description_img_{{$idpro}}" class="label">Descrição</label>
        <textarea name="img[description]" id="description_img_{{$idpro}}"  class="input full-width description_img" cols="10" rows="2"></textarea>
    </p>
    <p class="button-height inline-small-label">
        <label for="active_img_{{$idpro}}" class="label">Status <span class="red">*</span></label>
        <span class="button-group">
            <label for="active_img_{{$idpro}}_1" class="button green-active">
                <input type="radio" name="img[active]" id="active_img_{{$idpro}}_1" value="{{constLang('active_true')}}" checked>
                {{constLang('active_true')}}
            </label>
            <label for="active_img_{{$idpro}}_2" class="button red-active" >
                <input type="radio" name="img[active]" id="active_img_{{$idpro}}_2" value="{{constLang('active_false')}}">
                {{constLang('active_false')}}
            </label>
        </span>
    </p>
    <p class="button-height inline-small-label">
        <label for="img_cover_{{$idpro}}" class="label">Capa <span class="red">*</span></label>
        <span class="button-group">
            <span id="load_cover_{{$idpro}}">
                <label for="img_cover_{{$idpro}}_1" class="button green-active">
                    <input type="radio" name="img[cover]" id="img_cover_{{$idpro}}_1" value="1" checked>
                    Sim
                </label>
                <label for="img_cover_{{$idpro}}_2" class="button red-active" >
                    <input type="radio" name="img[cover]" id="img_cover_{{$idpro}}_2" value="0">
                    Não
                </label>
            </span>
            <!-- Jquery: Alterar statis imagem cover para inativo -->
            <input id="cover_id" type="hidden" value="{{$idpro}}">
        </span>
    </p>
    <p class="button-height inline-small-label">
        <label for="order_img_{{$idpro}}" class="label">Ordem <span class="red">*</span></label>
        <span class="number input margin-right">
            <button type="button" class="button number-down">-</button>
            <input type="text" name="img[order]" value="2" size="2" class="input-unstyled order">
            <button type="button" class="button number-up">+</button>
        </span>
    </p>
</div>