@if($configProduct->config_prices == 1)
    @foreach($profiles as $price)
        @php
            $percent_card = $price->sum.$price->percent_card;
            $total_card   = $price_card * (1+($percent_card/100));

            $percent_cash = $price->sum.$price->percent_cash;
            $total_cash   = $price_card * (1+($percent_cash/100));
        @endphp
        @if ($price->id != 1)
            <p class="button-height">
                <span class="input">
                    <label for="profile-{{$price->id}}" class="button blue-gradient">{{$price->name}}</label>

                    <label for="label-card-{{$price->id}}" class="button green-gradient">{{$percent_card}}%</label>

                    <input type="text" name="price[{{$price->id}}][price_card]" id="price_card_{{$price->id}}" class="input-unstyled input-sep" placeholder="Parcelado" value="{{number_format($total_card, 2, '.', '')}}" onKeyDown="javascript: return maskValor(this,event,8,2);" maxlength="8" style="width: 50px;">

                    <label for="label-cash-{{$price->id}}" class="button green-gradient">{{$percent_cash}}%</label>

                    <input type="text" name="price[{{$price->id}}][price_cash]" id="price_card_{{$price->id}}" class="input-unstyled input-sep" placeholder="À Vísta" value="{{number_format($total_cash, 2, '.', '')}}" onKeyDown="javascript: return maskValor(this,event,8,2);" maxlength="8" style="width: 50px;">

                </span>
                <input type="hidden" name="price[{{$price->id}}][price_card_percent]"  value="{{$percent_card}}">
                <input type="hidden" name="price[{{$price->id}}][price_cash_percent]"  value="{{$percent_cash}}">
                <input type="hidden" name="price[{{$price->id}}][profile]" value="{{$price->name}}">
                <input type="hidden" name="price[{{$price->id}}][config_profile_client_id]" value="{{$price->id}}">
            </p>
        @endif
    @endforeach
@endif