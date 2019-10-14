<?php

namespace AVDPainel\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use AVDPainel\Interfaces\Admin\ConfigProductInterface as ConfigProduct;
use AVDPainel\Interfaces\Admin\ConfigFreightInterface as ConfigFreight;

class ProductRequest extends FormRequest
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ConfigProduct $configProduct, ConfigFreight $configFreight)
    {
        $this->configProduct  = $configProduct;
        $this->configFreight  = $configFreight;
    }
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $configFreight = $this->configFreight->setId(1);
        $configProduct = $this->configProduct->setId(1);        
        $inputProduct  = $this->request->get('prod');
        $price_default = $configProduct->price_default;
        $inputPrice    = $this->request->get('price');
        $inputCost     = $this->request->get('cost');
        $offer         = $inputProduct['offer'];
        $id            = $this->request->get('id');


        foreach($inputProduct as $key => $val) {

            if ($key == 'brand_id') {
               $rules['prod.brand_id'] = 'required|min:1';
            }
            if ($key == 'section_id') {
               $rules['prod.section_id'] = 'required';
            }
            if ($key == 'category_id') {
               $rules['prod.category_id'] = 'required';
            }
            if($key == 'name'){
               $rules['prod.name'] = "required|unique:products,name,{$id},id";
            }


            if ($offer == 1) {
                if ($key == 'offer_days') {
                    $rules['prod.offer_days'] = 'required';
                }
            }

        }

        foreach ($inputPrice as $key => $value) {
            foreach ($value as $k => $v) {

                $profile = $value['profile'];

                if ($profile != $price_default) {
                    if ($k == 'config_price_id' && $v < 1) {
                        $rules['price.'.$profile.'.config_price_id'] = 'required';
                    }
                    if ($k == 'price_card_percent' && $v == '') {
                        $rules['price.'.$profile.'.price_card_percent'] = 'required';
                    }
                    if($k == 'price_card' && $v == '' || $v == '0.00'){
                        $rules['price.'.$profile.'.price_card'] = 'required';
                    }
                    if($k == 'price_cash' && $v == '' || $v == '0.00'){
                        $rules['price.'.$profile.'.price_cash'] = 'required';
                    }
                    if ($k == 'price_cash_percent' && $v == '') {
                        $rules['price.'.$profile.'.price_cash_percent'] = 'required';
                    }

                    if ($offer == 1) {

                        if ($k == 'offer_percent' && $v < 1) {
                            $rules['price.'.$profile.'.offer_percent'] = 'required';
                        }
                        if ($k == 'offer_cash' && $v == '' || $v == '0.00') {
                            $rules['price.'.$profile.'.offer_cash'] = 'required';
                        }
                        if ($k == 'offer_card' && $v == '' || $v == '0.00') {
                            $rules['price.'.$profile.'.offer_card'] = 'required';
                        }
                    }

                } else {

                    $price_card         = $value['price_card'];
                    $price_cash         = $value['price_cash'];
                    $price_cash_percent = $value['price_cash_percent'];


                    if ($price_cash_percent < 1) {
                        $rules['price.'.$profile.'.price_cash_percent'] = 'required';
                    }
                    if($price_card == '' || $price_card == '0.00'){
                        $rules['price.'.$profile.'.price_card'] = 'required';
                    }
                    if($price_cash == '' || $price_cash == '0.00'){
                        $rules['price.'.$profile.'.price_cash'] = 'required';
                    }
                    if ($offer == 1) {

                        $offer_card    = $value['offer_card'];
                        $offer_cash    = $value['offer_cash'];
                        $offer_percent = $value['offer_percent'];

                        if ($offer_percent < 1) {
                            $rules['price.'.$profile.'.offer_percent'] = 'required';
                        }
                        if ($offer_card == '' || $offer_card == '0.00') {
                            $rules['price.'.$profile.'.offer_card'] = 'required';
                        }
                        if ($offer_cash == '' || $offer_cash == '0.00') {
                            $rules['price.'.$profile.'.offer_cash'] = 'required';
                        }
                    }

                }
            }
        }

        // Se habilitar o preço de custo
        if ($configProduct->cost == 1) {
            if ($inputCost['value'] == '' || $inputProduct['value'] = '0.00') {
                $rules['cost.value'] = 'required';
            }
        }

        // Se cobrar frete validar os campos
        if (isset($inputProduct['freight'])) {
            if ($inputProduct['freight'] == 1) {
                if ($configFreight->weight == 1) {
                    $rules['prod.weight'] = 'required|numeric|between:0,99.999';
                }
                if ($configFreight->width == 1) {
                    $rules['prod.width'] = 'required|max:3';
                }
                if ($configFreight->height == 1) {
                    $rules['prod.height'] = 'required|max:3';
                }
                if ($configFreight->length == 1) {
                    $rules['prod.length'] = 'required|max:3';
                }                 
            }
        }

        //dd($rules);

        return $rules;
     
    }


    public function messages()
    {
        $msg = '';
        $messages = [];
        $inputProduct = $this->request->get('prod');
        $inputPrice   = $this->request->get('price');
        $inputCost    = $this->request->get('cost');

        foreach ($inputCost as $key => $value) {
            if($key == 'value'){
                $messages['cost.value.required'] = "O valor do custo é obrigatório.";
            }

        }



        foreach($inputProduct as $key => $val){

            if ($key == 'brand_id') {
                $msg = "O fabricante é obrigatório.";
            }
            if ($key == 'section_id') {
                $msg = "A seção é obrigatória.";
            }
            if ($key == 'category_id') {
                $msg = "A categoria é obrigatória.";
            }
            if($key == 'name'){
                $msg = "O nome do produto é obrigatório.";
            }
            if($key == 'weight'){
               $msg = "O peso é obrigatório.";
            }
            if($key == 'width'){
               $msg = "A largura é obrigatória.";
            }
            if($key == 'height'){
               $msg = "A altura é obrigatória.";
            }
            if($key == 'length'){
               $msg = "O comprimento é obrigatório.";
            }

            if($key == 'offer_days'){
                $msg = "A número de dias da oferta é obrigatório.";
            }

            $messages['prod.'.$key.'.required'] = $msg;

        }

        $messages['prod.name.unique'] = 'O nome do produto já se encontra utilizado.';


        foreach ($inputPrice as $key => $value) {
            foreach ($value as $k => $v) {

                $profile = $value['profile'];                

                if ($k == 'price_card_percent') {
                    $messages['price.'.$profile.'.price_card_percent.required'] = "A porcentagem {$profile} parcelado é obrigatória.";
                }
                if($k == 'price_card'){
                    $messages['price.'.$profile.'.price_card.required'] = "Valor {$profile} parcelado é obrigatório.";
                }
                if ($k == 'price_cash_percent') {
                    $messages['price.'.$profile.'.price_cash_percent.required'] = "A porcentagem {$profile} à vísta é obrigatória.";
                }
                if($k == 'price_cash'){
                    $messages['price.'.$profile.'.price_cash.required'] = "Valor {$profile} á vista é obrigatório.";
                }

                if ($k == 'offer_percent') {
                    $messages['price.'.$profile.'.offer_percent.required'] = "A porcentagem {$profile} do valor da oferta é obrigatório.";
                }                
                if($k == 'offer_card'){
                    $messages['price.'.$profile.'.offer_card.required'] = "Valor {$profile} em oferta à prazo é obrigatório.";
                }
                if($k == 'offer_cash'){
                    $messages['price.'.$profile.'.offer_cash.required'] = "Valor {$profile} em oferta à vista é obrigatório.";
                }
            }
        }



        return $messages;
    }   
}
