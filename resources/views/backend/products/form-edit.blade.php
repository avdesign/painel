<!-- Form: Product Edit -->
<form id="form-products" method="post" action="{{route('catalog.update', ['cat' => $data->category_id,'id' => $data->id])}}" onsubmit="return false">
    <input name="id" type="hidden" value="{{$data->id}}">
    <input name="prod[brand]" type="hidden" value="{{$data->brand}}">
    <input name="prod[section]" type="hidden" value="{{$data->section}}">
    <input name="prod[category]" type="hidden" value="{{$data->category}}">
    @method("PUT")
    @csrf

    <div align="center">
        <select id="select-brands" name="prod[brand_id]" class="select blue-gradient glossy">
            @foreach($brands as $keybra => $valbra)
                <option value="{{$keybra}}"
                        @if(isset($data) && $data->brand_id == $keybra) selected @endif> {{$valbra}} </option>
            @endforeach
        </select>
        <select id="select-sections" name="prod[section_id]" onchange="comboCategories(this.value);" class="select red-gradient">
            @foreach($sections as $keysec => $valsec)
                <option value="{{$keysec}}"
                        @if(isset($data) && $data->section_id == $keysec) selected @endif> {{$valsec}} </option>
            @endforeach
        </select>
        <span class="loader" id="load-select" style="display:none"></span>
        <span id="combo-categories">
            <select id="select-categories" name="prod[category_id]" class="select anthracite-gradient">
                @foreach($categories as $valcat)
                    <option value="{{$valcat->id}}"
                            @if(isset($data) && $data->category_id == $valcat->id) selected @endif> {{$valcat->name}} </option>
                @endforeach
            </select>
        </span>
    </div>

    <div class="columns">
        <div class="twelve-columns">
            <fieldset class="fieldset">
                <legend class="legend">Informações do produto</legend>
                <p class="button-height inline-label">
                    <label for="name" class="label">Nome<span class="red">*</span></label>
                    <input type="text" name="prod[name]" id="name" value="{{$data->name}}" autocomplete="off" class="input full-width">
                </p>
                <p class="button-height inline-label">
                    <label for="tags" class="label">Tags</label>
                    <input type="text" name="prod[tags]" id="tags" value="{{$data->tags}}" autocomplete="off" class="input full-width">
                </p>
                <p class="button-height inline-label">
                    <label for="description" class="label">Descrição</label>
                    <textarea name="prod[description]" id="description" class="input full-width" cols="10" rows="2">{{$data->description}}</textarea>
                </p>
                @if($configProduct->video == 1)
                    <p class="button-height inline-label">
                        <label for="video" class="label">Video(link)</label>
                        <input type="text" name="prod[video]" id="video" value="{{$data->video}}" autocomplete="off" class="input full-width">
                    </p>
                @endif
            </fieldset>
        </div>
        <div class="new-row five-columns twelve-columns-tablet">
            <fieldset class="fieldset">

                <legend class="legend">Status do produto</legend>
                <p class="button-height inline-label">
                    <label for="active" class="label">Status</label>
                    <span class="button-group">
                        <label for="active_1" class="button green-active">
                            <input type="radio" name="prod[active]" id="active_1" value="1" @if($data->active == 1) checked @endif>
                            Ativo
                        </label>
                        <label for="active_2" class="button red-active" >
                            <input type="radio" name="prod[active]" id="active_2" value="0" @if($data->active == 0) checked @endif>
                            Inativo
                        </label>
                    </span>
                </p>
                <p class="button-height inline-label">
                    <label for="new" class="label">Novo</label>
                    <span class="button-group">
                        <label for="new_1" class="button green-active">
                            <input type="radio" name="prod[new]" id="new_1" value="1" @if($data->new == 1) checked @endif>
                            Ativo
                        </label>
                        <label for="new_2" class="button red-active" >
                            <input type="radio" name="prod[new]" id="new_2" value="0" @if($data->new == 0) checked @endif>
                            Inativo
                        </label>
                    </span>
                </p>
                <p class="button-height inline-label">
                    <label for="featured" class="label">Destaque</label>
                    <span class="button-group">
                        <label for="featured_1" class="button green-active">
                            <input type="radio" name="prod[featured]" id="featured_1" value="1" @if($data->featured == 1) checked @endif>
                            Ativo
                        </label>
                        <label for="featured_2" class="button red-active" >
                            <input type="radio" name="prod[featured]" id="featured_2" value="0" @if($data->featured == 0) checked @endif>
                            Inativo
                        </label>
                    </span>
                </p>
                <p class="button-height inline-label">
                    <label for="trend" class="label">Tendência</label>
                    <span class="button-group">
                        <label for="trend_1" class="button green-active">
                            <input type="radio" name="prod[trend]" id="trend_1" value="1" @if($data->trend == 1) checked @endif>
                            Ativo
                        </label>
                        <label for="trend_2" class="button red-active" >
                            <input type="radio" name="prod[trend]" id="trend_2" value="0" @if($data->trend == 0) checked @endif>
                            Inativo
                        </label>
                    </span>
                </p>
                <p class="button-height inline-label">
                    <label for="black_friday" class="label">Black Friday</label>
                    <span class="button-group">
                        <label for="black_friday_1" class="button green-active">
                            <input type="radio" name="prod[black_friday]" id="black_friday_1" value="1" @if($data->black_friday == 1) checked @endif>
                            Ativo
                        </label>
                        <label for="black_friday_2" class="button red-active" >
                            <input type="radio" name="prod[black_friday]" id="black_friday_2" value="0" @if($data->black_friday == 0) checked @endif>
                            Inativo
                        </label>
                    </span>
                </p>

                @if($configProduct->freight == 1)
                    @include('backend.freights.form-edit')
                @endif

            </fieldset>
        </div>
        <div class="seven-columns twelve-columns-tablet">
            <fieldset class="fieldset">
                <legend class="legend">Valores do produto</legend>

                @if($configProduct->cost == 1)
                    <p class="button-height">
                        <span class="input">
                            <label for="pseudo-input-2" class="button blue-gradient">Custo</label>
                            <input type="text" name="cost[value]" id="cost" value="{{$cost->value}}" class="input-unstyled" autocomplete="off" onKeyDown="javascript: return maskValor(this,event,8,2);" maxlength="8" style="width: 80px;">
                        </span>
                    </p>
                @endif

                <p class="button-height">
                    <span class="input">
                        <label for="unit_measure" class="button blue-gradient">Und</label>
                        <select id="unit_measure" name="prod[unit_measure]" class="select compact expandable-list" style="width:100px">
                            @foreach($unit_measure as $key => $val)
                                <option value="{{$key}}|{{$val}}" @if($data->unit == $key) selected @endif>{{$key}} {{$val}}</option>
                            @endforeach
                        </select>
                    </span>
                    @if($configProduct->kit == 1 && $data->kit == 1)
                        <span id="kits">
                            <select name="prod[kit_name]" class="select">
                                @foreach($kits as $key => $val)
                                    <option value="{{$val}}"@if($data->kit_name == $val) selected @endif>{{$val}}</option>
                                @endforeach
                            </select>
                        </span>
                    @endif
                </p>

                <p class="button-height block-label">
                    <label for="info-calculate" class="label"><small>À Vista (clique em calcular)</small></label>
                </p>

                @foreach($prices as $price)
                    @if($price->profile == $configProduct->price_default)
                        @php
                            $ids = [];
                        @endphp
                        <p class="button-height">
                            <span class="input">
                                <label for="profile-{{$price->id}}" class="button blue-gradient">{{$price->profile}}</label>
                                <span class="number input margin-right">
                                    <button type="button" class="button number-down">-</button>
                                    <input type="text" id="price_card_percent_{{$price->id}}" name="price[{{$price->id}}][price_cash_percent]"  value="{{round($price->price_cash_percent, 2)}}" size="4" class="input-unstyled" data-number-options='{"min":1,"max":50,"increment":0.5,"shiftIncrement":5,"precision":0.25}'>
                                    <button type="button" class="button number-up">+</button>
                                </span>

                                <input type="text" name="price[{{$price->id}}][price_card]" id="price_card_{{$price->id}}" class="input-unstyled input-sep" placeholder="À Prazo" value="{{$price->price_card}}" onKeyDown="javascript: return maskValor(this,event,8,2);" maxlength="8" style="width: 50px;">
                                <input type="text" name="price[{{$price->id}}][price_cash]" id="price_cash_{{$price->id}}" class="input-unstyled" placeholder="À Vista" value="{{$price->price_cash}}" onKeyDown="javascript: return maskValor(this,event,8,2);" style="width: 80px;">
                                <a href="javascript:calculateCash('{{$price->id}}', 'price')" class="button compact">Calcular</a>
                            </span>
                            <input type="hidden" name="price[{{$price->id}}][price_card_percent]" value="0">
                            <input type="hidden" name="price[{{$price->id}}][profile]" value="{{$price->profile}}">
                            <input type="hidden" name="price[{{$price->id}}][product_id]" value="{{$data->id}}">
                            <input type="hidden" name="price[{{$price->id}}][id]" value="{{$price->id}}">
                            <input type="hidden" name="price[{{$price->id}}][config_profile_client_id]" value="{{$price->config_profile_client_id}}">
                        </p>
                    @else
                        @php
                            $ids[] = $price->id;
                        @endphp
                        <p class="button-height">
                        <span class="input">
                            <label for="profile-{{$price->id}}" class="button blue-gradient">{{$price->profile}}</label>
                            <span class="number input margin-right">
                                <button type="button" class="button number-down">-</button>
                                <input type="text" name="price[{{$price->id}}][price_card_percent]"  value="{{$price->sum_card}}{{round($price->price_card_percent, 2)}}" size="4" class="input-unstyled" data-number-options='{"min":-100,"max":100,"increment":0.5,"shiftIncrement":5,"precision":0.25}'>
                                <button type="button" class="button number-up">+</button>
                            </span>
                            <input type="text" name="price[{{$price->id}}][price_card]" id="price_card_{{$price->id}}" class="input-unstyled input-sep" placeholder="À Prazo" value="{{$price->price_card}}" onKeyDown="javascript: return maskValor(this,event,8,2);" maxlength="8" style="width: 60px;">
                            <span class="number input margin-right">
                                <button type="button" class="button number-down">-</button>
                                <input type="text" name="price[{{$price->id}}][price_cash_percent]"  value="{{$price->sum_cash}}{{round($price->price_cash_percent, 2)}}" size="4" class="input-unstyled" data-number-options='{"min":-100,"max":100,"increment":0.5,"shiftIncrement":5,"precision":0.25}'>
                                <button type="button" class="button number-up">+</button>
                            </span>
                            <input type="text" name="price[{{$price->id}}][price_cash]" id="price_cash_{{$price->id}}" class="input-unstyled" placeholder="À Vista" value="{{$price->price_cash}}" onKeyDown="javascript: return maskValor(this,event,8,2);" style="width: 60px;">
                        </span>
                            <input type="hidden" name="price[{{$price->id}}][id]" value="{{$price->id}}">
                            <input type="hidden" name="price[{{$price->id}}][product_id]" value="{{$data->id}}">
                            <input type="hidden" name="price[{{$price->id}}][profile]" value="{{$price->profile}}">
                            <input type="hidden" name="price[{{$price->id}}][config_profile_client_id]" value="{{$price->config_profile_client_id}}">
                        </p>
                    @endif
                @endforeach
                <input type="hidden" id="ids_prices" value="{{implode(",", $ids)}}">

                <p class="button-height">
                    <span class="input">
                        <label for="label-offer" class="button blue-gradient">Oferta / Dias</label>
                        <label for="offer_1" class="button green-active compact">
                            <input type="radio" onclick="setOffer(1)" name="prod[offer]" id="offer_1" value="1" @if($data->offer == 1) checked @endif>
                            Sim
                        </label>
                        <label for="offer_2" class="button red-active  compact" >
                            <input type="radio" onclick="setOffer(0)" name="prod[offer]" id="offer_2" value="0" @if($data->offer == 0) checked @endif>
                            Não
                        </label>
                        <input type="number" name="prod[offer_days]" class="input-unstyled" value="{{$offer_days}}" style="width: 50px;" maxlength="2">
                    </span>
                </p>

                <div id="values_offers" style="display:@if($data->offer == 1 ) block @else none @endif">
                    @foreach($prices as $offer)
                        <p class="button-height">
                            <span class="input">
                                <label for="profile-{{$offer->id}}" class="button green-gradient">{{$offer->profile}}</label>
                                <span class="number input margin-right">
                                    <button type="button" class="button number-down">-</button>
                                    <input type="text" name="price[{{$offer->id}}][offer_percent]"  value="{{$offer->offer_percent}}" size="4" class="input-unstyled" data-number-options='{"min":1,"max":50,"increment":0.5,"shiftIncrement":5,"precision":0.25}'>
                                    <button type="button" class="button number-up">+</button>
                                </span>
                                <input type="text" name="price[{{$offer->id}}][offer_card]" id="offer_card_{{$offer->id}}" class="input-unstyled input-sep" placeholder="À Prazo" value="{{$offer->offer_card}}" onKeyDown="javascript: return maskValor(this,event,8,2);" maxlength="8" style="width: 50px;">
                                <input type="text" name="price[{{$offer->id}}][offer_cash]" id="offer_cash_{{$offer->id}}" class="input-unstyled" placeholder="À Vista" value="{{$offer->offer_cash}}" style="width: 80px;">
                                <a href="javascript:calculateCash('{{$offer->id}}', 'offer')" class="button compact">Calcular</a>
                            </span>
                        </p>
                    @endforeach
                </div>
            </fieldset>
            <div align="center">
                <button id="submit-produto" type="submit" class="button glossy" onclick="formProduct('products','update')">
                    Alterar
                    <span  id="btn-produto" class="button-icon right-side"><span class="icon-forward"></span></span>
                </button>
            </div>
        </div>
    </div>

</form>
<script>
    /**
     * Post categorias relacionada a seção e preenche o select
     * @param val
     */
    function comboCategories(val)
    {
        $("#load-select").show();
        $("#combo-categories").hide();
        $.ajax({
            type: 'post',
            url: '{{route('change.product')}}',
            data: {
                get_option:val,
                _token: '{{csrf_token()}}'
            },
            success: function (response) {
                $("#load-select").hide();
                $("#combo-categories").show();
                $("#combo-categories").html(response);
            }
        });
    }
</script>