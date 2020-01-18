<!-- Form: Product Create -->
<form id="form-products" method="post" action="{{route('catalog.store', $category->id)}}" onsubmit="return false">
    <input id="category_id" name="prod[category_id]" type="hidden" value="{{$category->id}}">
    <input id="section_id" name="prod[section_id]" type="hidden" value="{{$category->section_id}}">
    <input name="prod[category]" type="hidden" value="{{$category->name}}">
    <input name="prod[section]" type="hidden" value="{{$category->section}}">
    @csrf
    <div class="columns">
        <div class="twelve-columns">
            <fieldset class="fieldset">
                <legend class="legend">Informações do produto</legend>
                <p class="button-height inline-label">
                    <label for="name" class="label">Nome<span class="red">*</span></label>
                    <input type="text" name="prod[name]" id="name" value="" autocomplete="off" class="input full-width">
                </p>
                <p class="button-height inline-label">
                    <label for="tags" class="label">Tags</label>
                    <input type="text" name="prod[tags]" id="tags" value="" autocomplete="off" class="input full-width">
                </p>
                <p class="button-height inline-label">
                    <label for="description" class="label">Descrição</label>
                    <textarea name="prod[description]" id="description" autocomplete="off" class="input full-width" cols="10" rows="2"></textarea>
                </p>
                @if($configProduct->video == 1)
                    <p class="button-height inline-label">
                        <label for="video" class="label">Video(link)</label>
                        <input type="text" name="prod[video]" id="video" value="" autocomplete="off" class="input full-width">
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
                            <input type="radio" name="prod[active]" id="active_1" value="1"  checked>
                            Ativo
                        </label>
                        <label for="active_0" class="button red-active" >
                            <input type="radio" name="prod[active]" id="active_0" value="0">
                            Inativo
                        </label>
                    </span>
                </p>
                <p class="button-height inline-label">
                    <label for="new" class="label">Novo</label>
                    <span class="button-group">
                        <label for="new_1" class="button green-active">
                            <input type="radio" name="prod[new]" id="new_1" value="1"  checked>
                            Ativo
                        </label>
                                <label for="new_0" class="button red-active" >
                            <input type="radio" name="prod[new]" id="new_0" value="0" >
                            Inativo
                        </label>
                    </span>
                </p>
                <p class="button-height inline-label">
                    <label for="featured" class="label">Destaque</label>
                    <span class="button-group">
                        <label for="featured_1" class="button green-active">
                            <input type="radio" name="prod[featured]" id="featured_1" value="1">
                            Ativo
                        </label>
                                <label for="featured_0" class="button red-active" >
                            <input type="radio" name="prod[featured]" id="featured_0" value="0" checked>
                            Inativo
                        </label>
                    </span>
                </p>
                <p class="button-height inline-label">
                    <label for="trend" class="label">Tendência</label>
                    <span class="button-group">
                        <label for="trend_1" class="button green-active">
                            <input type="radio" name="prod[trend]" id="trend_1" value="1">
                            Ativo
                        </label>
                        <label for="trend_0" class="button red-active" >
                            <input type="radio" name="prod[trend]" id="trend_0" value="0" checked>
                            Inativo
                        </label>
                    </span>
                </p>
                <p class="button-height inline-label">
                    <label for="black_friday" class="label">Black Friday</label>
                    <span class="button-group">
                        <label for="black_friday_1" class="button green-active">
                            <input type="radio" name="prod[black_friday]" id="black_friday_1" value="1">
                            Ativo
                        </label>
                        <label for="black_friday_0" class="button red-active" >
                            <input type="radio" name="prod[black_friday]" id="black_friday_0" value="0" checked>
                            Inativo
                        </label>
                    </span>
                </p>



                @if($configProduct->stock == 1)
                    <p class="button-height inline-label">
                        <label for="stock" class="label">Estoque</label>
                        <span class="button-group">
                            <label for="stock_1" class="button green-active">
                                <input type="radio" name="prod[stock]"  id="stock_1" onclick="setStock('create','1','{{route('change-grids')}}')" value="1" checked >
                                Ativo
                            </label>
                            <label for="stock_0" class="button red-active">
                                <input type="radio" name="prod[stock]" id="stock_0" onclick="setStock('create','0','{{route('change-grids')}}')" value="0" >
                                Inativo
                            </label>
                        </span>
                    </p>
                @endif
                @if($configProduct->qty_min == 1)
                    <p class="button-height inline-label">
                        <label for="qty_min" class="label">Estoque Mínimo</label>
                        <span class="button-group">
                            <label for="qty_min_1" class="button green-active">
                                <input type="radio" name="prod[qty_min]"  id="qty_min_1" value="1" checked >
                                Ativo
                            </label>
                            <label for="qty_min_0" class="button red-active">
                                <input type="radio" name="prod[qty_min]" id="qty_min_0" value="0" >
                                Inativo
                            </label>
                        </span>
                    </p>
                @endif
                @if($configProduct->qty_max == 1)
                    <p class="button-height inline-label">
                        <label for="qty_max" class="label">Estoque Máximo</label>
                        <span class="button-group">
                            <label for="qty_max_1" class="button green-active">
                                <input type="radio" name="prod[qty_max]"  id="qty_max_1" value="1" checked >
                                Ativo
                            </label>
                            <label for="qty_max_0" class="button red-active">
                                <input type="radio" name="prod[qty_max]" id="qty_max_0" value="0" >
                                Inativo
                            </label>
                        </span>
                    </p>
                @endif
            </fieldset>

            @if($configProduct->freight == 1)
                @include('backend.freights.form-create')
            @endif

        </div>

        <div class="seven-columns twelve-columns-tablet">
            <fieldset class="fieldset">
                <legend class="legend">Valores do produto</legend>

                @if($configProduct->kit == 1)
                    <p class="button-height">
                        <span class="button-group">
                            <label for="kit_1" class="button green-active">
                                <input type="radio" name="prod[kit]"  id="kit_1" onclick="setKit('create','1','{{route('change-grids')}}')" value="1" checked >
                                Caixa
                            </label>
                            <label for="kit_0" class="button red-active">
                                <input type="radio" name="prod[kit]" id="kit_0" onclick="setKit('create','0','{{route('change-grids')}}')" value="0" >
                                Unidade
                            </label>
                        </span>
                    </p>
                @endif

                @if($configProduct->cost == 1)
                    <p class="button-height">
                        <span class="input">
                            <label for="cost" class="button blue-gradient">Custo</label>
                            <input type="text" name="cost[value]" id="cost" value="" class="input-unstyled" autocomplete="off" onKeyDown="javascript: return maskValor(this,event,8,2);" maxlength="8" style="width: 80px;">
                        </span>
                    </p>
                @endif

                <p class="button-height">
                    <span class="input">
                        <label for="unit_measure" class="button blue-gradient">Und</label>
                        <select id="unit_measure" name="prod[unit_measure]" class="select compact expandable-list" style="width:100px">
                            @foreach($unit_measure as $key => $val)
                               <option value="{{$key}}|{{$val}}">{{$key}} {{$val}}</option>
                            @endforeach
                        </select>
                    </span>
                    @if($configProduct->kit == 1)
                    <span id="kits">
                        <select name="prod[kit_name]" class="select">
                           @foreach($kits as $key => $val)
                               <option value="{{$val}}">{{$val}}</option>
                           @endforeach
                        </select>
                    </span>
                    @endif
                </p>
                <p class="button-height block-label">
                    <label for="info-calculate" class="label"><small>À Vista (clique em calcular)</small></label>
                </p>

                <p class="button-height">
                    <span class="input">
                        <label for="price_card_percent_1" class="button blue-gradient">{{$configProduct->price_default}} %</label>
                        <select id="price_card_percent_1" name="price[1][price_cash_percent]" class="select compact" style="width:50px">
                            @foreach($percentage as $key => $val)
                               <option value="{{$val}}">{{$val}}</option>
                            @endforeach
                        </select>
                        <input type="text" name="price[1][price_card]" autocomplete="off"   class="input-unstyled input-sep" placeholder="Cartão" value="" onKeyDown="javascript: return maskValor(this,event,8,2);" maxlength="8" style="width: 60px;">
                        <input type="text" name="price[1][price_cash]" autocomplete="off" onKeyDown="javascript: return maskValor(this,event,8,2);" class="input-unstyled" placeholder="À Vista" value="" style="width: 80px;">
                        <a id="get_prices" href="javascript:get_prices('{{route('profile.client.get.prices')}}', '{{$configProduct->price_profile}}')" class="button compact">Calcular</a>
                    </span>
                    <input type="hidden" name="price[1][profile]" value="{{$configProduct->price_default}}">
                    <input type="hidden" name="price[1][price_card_percent]" value="0">
                    <input type="hidden" name="price[1][config_profile_client_id]" value="1">
                </p>

                <div id="load_prices" class="button-height"></div><br>

                <p class="button-height">
                    <span class="input">
                        <label for="label-offer" class="button blue-gradient">Oferta / Dias</label>
                        <label for="offer_1" class="button green-active compact">
                            <input type="radio" onclick="get_offers('{{route('profile.client.get.offers')}}', '1', '{{$configProduct->price_profile}}')" name="prod[offer]" id="offer_1" value="1">
                            Sim
                        </label>
                        <label for="offer_0" class="button red-active compact" >
                            <input type="radio" onclick="get_offers('{{route('profile.client.get.offers')}}', '0', '{{$configProduct->price_profile}}')" name="prod[offer]" id="offer_0" value="0" checked>
                            Não
                        </label>
                        <input type="number" name="prod[offer_days]" class="input-unstyled" value="30" style="width: 50px;" maxlength="2">
                    </span>
                </p>

                <span id="normal_offer" class="display-none">
                    <p class="button-height">
                        <span class="input">
                            <label for="profile-1" class="button green-gradient">{{$configProduct->price_default}}</label>
                            <span class="number input margin-right">
                                <button type="button" class="button number-down">-</button>
                                <input type="text" id="offer_percent_1" name="price[1][offer_percent]"  value="" size="4" class="input-unstyled" data-number-options='{"min":1,"max":50,"increment":0.5,"shiftIncrement":5,"precision":0.25}'>
                                <button type="button" class="button number-up">+</button>
                            </span>
                            <input type="text" name="price[1][offer_card]" id="offer_card_1" class="input-unstyled input-sep" placeholder="Cartão" value="" onKeyDown="javascript: return maskValor(this,event,8,2);" maxlength="8" style="width: 50px;">
                            <input type="text" name="price[1][offer_cash]" id="offer_cash_1" class="input-unstyled" placeholder="À Vista" value="" onKeyDown="javascript: return maskValor(this,event,8,2);" style="width: 80px;">
                            <a href="javascript:calculateCash('1', 'offer')" class="button compact">Calcular</a>
                        </span>
                    </p>
                    <p></p>
                </span>

                <div id="get_offers" ></div>

            </fieldset>

            <fieldset class="fieldset">
                <p class="button-height inline-label">
                    <label for="brand" class="label">Fabricante<span class="red">*</span></label>
                    <select id="brand_id" name="prod[brand_id]" class="select  blue-gradient glossy">
                        <option value="">Selecione um</option>
                        @foreach($brands as $key => $val)
                            <option value="{{$key}}">{{$val}}</option>
                        @endforeach
                    </select>
                </p>
            </fieldset>
            <div class="align-right">
                <button id="submit-product" type="button" class="button glossy" onclick="formProduct('products','create')">
                    Proximo
                    <span  id="btn-product" class="button-icon right-side"><span class="icon-forward"></span></span>
                </button>
            </div>
        </div>
    </div>
</form>