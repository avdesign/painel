<?php

namespace AVDPainel\Http\Requests\Admin;

use AVDPainel\Interfaces\Admin\ConfigProductInterface as ConfigProduct;
use AVDPainel\Interfaces\Admin\ConfigColorPositionInterface as ConfigImages;

use Illuminate\Foundation\Http\FormRequest;

class ProductPositionRequest extends FormRequest
{
    public function __construct(ConfigProduct $configProduct, ConfigImages $configImages)
    {
        $this->configImages  = $configImages;
        $this->configProduct = $configProduct;
        $this->size          = $this->configImages->setName('default', 'Z');
    }


    /**
     * Determinar se o usuário está autorizado a fazer o request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Obter as regras de validação que se aplicam ao request.
     *
     * @return array
     */
    public function rules()
    {
        $configProduct = $this->configProduct->setId(1); 

        /*
        Multiplo uplod
        foreach(range(0, $file) as $index) {
            $rules['file.' . $index] = 'image|mimes:jpeg,gif,png|dimensions:min_width='.$this->size->largura;
        }
        */

        if ($this->method() == 'PUT')
        {
            if (count($this->input('file')) == 0) {
                $rules['file'] = 'image|mimes:jpeg,gif,png|dimensions:min_width='.$this->size->img_width;
            }
        } else {
            $rules['pos.image_color_id'] = 'required';
            $rules['file'] = 'required|image|mimes:jpeg,gif,png|dimensions:min_width='.$this->size->img_width;
        }

        $rules['pos.order'] = 'required';
        $rules['pos.order'] = 'required|min:0';

        return $rules;
     
    }


    public function messages()
    {
        $msg = '';
        $messages = [];
        foreach($this->request->get('pos') as $key => $val){
            if($key == 'image_color_id'){
               $msg = "A imagem da cor correspondente não foi adicionada.";
            }
            if($key == 'code'){
               $msg = "O código é obrigatório.";
            }
            if($key == 'color'){
               $msg = "A cor é obrigatória.";
            }
            if($key == 'order'){
               $msg = "A ordem é obrigatória.";
            }
            $messages['pos.'.$key.'.required'] = $msg;
        }


        $messages['file.required'] = 'A imagem é obrigatória.';
        $messages['file.image'] = 'Este arquivo é inválido, ';
        $messages['file.mimes'] = 'deverá conter uma imagem do tipo:(jpg,png,gif)';
        $messages['file.dimensions'] = 'largura mínima: '.$this->size->width.' pixels)';

        return $messages;
    }   
}
