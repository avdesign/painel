<div class="block large-margin-bottom">
    <div class="block-title">
        <h3><span class="icon file-reg"></span><strong class="blue"> Calcular Cubagem </strong></h3>
    </div>
    <div class="with-padding silver-gradient">
        <div class="columns">
            <div class="new-row twelve-columns twelve-columns-tablet">
                <p class="message">
                    <a href="#" title="Fechar" class="close">✕</a>
                    Cubagem é a relação entre o peso e o volume da carga a ser transportada. Para calcular a cubagem, é utilizada a fórmula: altura x largura x profundidade x fator de cubagem. No caso do transporte rodoviário, veja o <b>"FATOR"</b> de cubagem padrão da transportadora.<br>
                    * Geralmente no caso de o Peso Cubado ser maior que o Peso Real, considera o Peso Cubado.
                </p>

                <form id="form-cubage" method="POST" action="http://painel.test/config/color/system" onsubmit="return false">
                    <fieldset>
                        <legend class="legend">Calcular Cubagem</legend>
                        <p>* As medidas devem ser fornecidas em Metros. <span style="color: red">Ex: 50 centímetros: 0.50 metros</span></p>
                        <p class="button-height">
                            <span class="input">
                                <label for="pseudo-input-2" class="button blue-gradient">
                                    <span class="small-margin-right">FATOR</span>
                                </label>
                                <input type="text" name="fotor" id="fator" class="input-unstyled input-sep" value="300" style="width: 60px;">
                            </span>
                        </p>

                        <p>*
                            <small class="tag red-bg">Qtd</small> Volumes
                            <small class="tag red-bg">C</small> Comprimento
                            <small class="tag red-bg">L</small> Largura
                            <small class="tag red-bg">A</small> Altura
                        </p>
                        <div id="form">
                            <p class="button-height">
                                <span class="input">
                                    <label for="cm_1" class="button blue-gradient">
                                        <span class="small-margin-right">CM</span>
                                    </label>
                                    <input type="text" name="qtd_1" id="qtd_1" class="input-unstyled input-sep" placeholder="Qtd" value="" onkeyup="calcularCubagem();" onKeyDown="javascript: return maskValor(this,event,4);" maxlength="4" tabindex="1" style="width: 30px;">
                                    <input type="text" name="p_1" id="p_1" class="input-unstyled input-sep" placeholder="C ou P" value="" onkeyup="calcularCubagem();" onKeyDown="javascript: return maskValor(this,event,4,2);" maxlength="4" tabindex="2" style="width: 45px;">
                                    <input type="text" name="l_1" id="l_1" class="input-unstyled input-sep" placeholder="L" value="" onkeyup="calcularCubagem();" onKeyDown="javascript: return maskValor(this,event,4,2);" maxlength="4" tabindex="3" style="width: 45px;">
                                    <input type="text" name="a_1" id="a_1" class="input-unstyled" placeholder="A" value="" onkeyup="calcularCubagem();" onKeyDown="javascript: return maskValor(this,event,4,2);" maxlength="4" tabindex="4" style="width: 45px;">
                                </span>

                                <span class="input">
                                    <label for="cubagem_1" class="button blue-gradient">
                                        <span class="small-margin-right">M³</span>
                                    </label>
                                    <input type="text" name="cubagem_1" id="cubagem_1" class="input-unstyled" readonly="readonly" placeholder="Cubagem(m³)" value="" style="width: 90px;">
                                    <label for="peso_1" class="button blue-gradient">
                                        <span class="small-margin-right">Kg</span>
                                    </label>
                                    <input type="text" name="peso_1" id="peso_1" class="input-unstyled" readonly="readonly" placeholder="Peso(kg)" value="" style="width: 85px;">
                                </span>
                                <button onclick="criarCubagem();" class="button icon-plus blue-bg"></button>
                                <input type="hidden" id="numero_calculos" name="numero_calculos" value="1">
                            </p>
                        </div>

                        <div class="large-margin-top float-left">
                            <p class="button-height">
                            <span class="input">
                                <label for="cubagem_1" class="button blue-gradient">
                                    <span class="small-margin-right">Total (m³)</span>
                                </label>
                                <input type="text" name="total_c" id="total_c" class="input-unstyled" readonly="readonly" placeholder="Cubagem(m³)" value="" style="width: 90px;">
                                <label for="peso_1" class="button blue-gradient">
                                    <span class="small-margin-right">Total (kg)</span>
                                </label>
                                <input type="text" name="total_p" id="total_p" class="input-unstyled" readonly="readonly" placeholder="Peso(kg)" value="" style="width: 85px;">
                            </span>
                            </p>
                        </div>
                    </fieldset>
                </form>
            </div>

            <div class="six-columns twelve-columns-tablet align-center">
                <img width="318px" src="{{asset('backend/img/default/box-cubage.jpg')}}" />
            </div>
            <div class="six-columns twelve-columns-tablet align-center">
                <img width="300px" src="{{asset('backend/img/default/box-cubage.png')}}" />
            </div>

        </div>
    </div>
</div>





<script>


    ( function( $ ) {

        var num = 1;
        var tab = 4;

        /**
         * Calcular cubagem
         */
         calcularCubagem = function(){
            var fotor = $("#fator").val();

            $('.linha').keyup(function(){
                var val = $(this).val().replace(',','.');
                $(this).val(val);
            });

            $('.boolean_button').attr('disabled', 'disabled');
            erro = 0;
            var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;

            /*$(".linha").each(function(){
             if(!numberRegex.test($(this).val())) erro = 1;
             });*/
            $(".linha").each(function(){
                if($(this).val()==""){
                    erro = 1;
                }
            });

            if(erro==0){
                $('.boolean_button').removeAttr('disabled', 'disabled');
            }
            var total_c = 0;
            var total_p = 0;
            for(i=1;i<=num;i++){
                cub = $('#qtd_'+i).val() * $('#a_'+i).val() * $('#l_'+i).val() * $('#p_'+i).val();
                peso = cub * fotor;
                $("#cubagem_"+i).val(cub.toFixed(2));
                $("#peso_"+i).val(peso.toFixed(2));
                total_c = total_c + cub;
                total_p = total_p + peso;
            }
            $("#total_c").val(total_c.toFixed(2));
            $("#total_p").val(total_p.toFixed(2));
            $("#Carea").val(total_c.toFixed(2));
            $("#Cpeso").val(total_p.toFixed(2));

        }


        /**
         * Criar Form Cubagem
         */
        criarCubagem = function() {

            $('.boolean_button').attr('disabled', 'disabled');

            $(".linha").each(function() {
                $(this).attr("value", $(this).val());
            });

            num++;

            $("#numero_calculos").val(num);

            $("#form").append('<p class="button-height"> <span class="input"> <label for="cm_' + num + '" class="button blue-gradient"> <span class="small-margin-right">CM</span> </label> <input type="text" name="qtd_' + num + '" id="qtd_' + num + '" class="input-unstyled input-sep" placeholder="Qtd" value="" onkeyup="calcularCubagem();" onKeyDown="javascript: return maskValor(this,event,4);" maxlength="4" tabindex="' + (tab + 1) + '" style="width: 30px;"> <input type="text" name="p_' + num + '" id="p_' + num + '" class="input-unstyled input-sep" placeholder="C ou P" value="" onkeyup="calcularCubagem();" onKeyDown="javascript: return maskValor(this,event,4,2);" maxlength="4" tabindex="' + (tab + 2) + '" style="width: 45px;"> <input type="text" name="l_' + num + '" id="l_' + num + '" class="input-unstyled input-sep" placeholder="L" value="" onkeyup="calcularCubagem();" onKeyDown="javascript: return maskValor(this,event,4,2);" maxlength="4" tabindex="' + (tab + 3) + '" style="width: 45px;"> <input type="text" name="a_' + num + '" id="a_' + num + '" class="input-unstyled" placeholder="A" value="" onkeyup="calcularCubagem();" onKeyDown="javascript: return maskValor(this,event,4,2);" maxlength="4" tabindex="' + (tab + 4) + '" style="width: 45px;"> </span> <span class="input"> <label for="cubagem_' + num + '" class="button blue-gradient"> <span class="small-margin-right">M³</span> </label> <input type="text" name="cubagem_' + num + '" id="cubagem_' + num + '" class="input-unstyled" readonly="readonly" placeholder="Cubagem(m³)" value="" style="width: 90px;"> <label for="peso_' + num + '" class="button blue-gradient"> <span class="small-margin-right">Kg</span> </label> <input type="text" name="peso_' + num + '" id="peso_' + num + '" class="input-unstyled" readonly="readonly" placeholder="Peso(kg)" value="" style="width: 85px;"> </span></p>');

            tab = tab + 4;
            $("#qtd_" + num).focus();
        }



    } )( jQuery );
</script>
