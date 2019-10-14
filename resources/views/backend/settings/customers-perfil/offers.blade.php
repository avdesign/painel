@if($configProduct->config_prices == 1)
    @foreach($profiles as $offer)
        @if ($offer->id != 1)
            <p class="button-height">
                <span class="input">
                    <label for="profile-{{$offer->id}}" class="button green-gradient">{{$offer->name}}</label>
                    <span class="number input margin-right">
                        <button type="button" class="button number-down">-</button>
                        <input type="text" name="price[{{$offer->id}}][offer_percent]"  value="{{$offer->percent_cash}}" size="4" class="input-unstyled" data-number-options='{"min":1,"max":50,"increment":0.5,"shiftIncrement":5,"precision":0.25}'>
                        <button type="button" class="button number-up">+</button>
                    </span>
                    <input type="text" name="price[{{$offer->id}}][offer_card]" id="offer_card_{{$offer->id}}" class="input-unstyled input-sep" placeholder="À Prazo" value="" onKeyDown="javascript: return maskValor(this,event,8,2);" maxlength="8" style="width: 50px;">
                    <input type="text" name="price[{{$offer->id}}][offer_cash]" id="offer_cash_{{$offer->id}}" class="input-unstyled" placeholder="À Vista" value="" onKeyDown="javascript: return maskValor(this,event,8,2);" style="width: 80px;">
                    <a href="javascript:calculateCash('{{$offer->id}}', 'offer')" class="button compact">Calcular</a>
                </span>
            </p>
        @endif
    @endforeach
@endif