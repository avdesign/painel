<?php

namespace AVDPainel\Http\Requests\Admin;

use AVDPainel\Interfaces\Admin\ConfigProductInterface as ConfigProduct;
use AVDPainel\Interfaces\Admin\ConfigColorPositionInterface as ConfigImages;
use AVDPainel\Interfaces\Admin\ProductInterface as InterProduct;

use Illuminate\Foundation\Http\FormRequest;

class ProductColorRequest extends FormRequest
{
    public function __construct(
        ConfigProduct $configProduct,
        ConfigImages $configImages,
        InterProduct $interProduct)

    {
        $this->interProduct  = $interProduct;
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

        $img           = $this->request->get('img');
        $product       = $this->interProduct->setId($img['product_id']);
        $configProduct = $this->configProduct->setId(1);
        /*
        Multiplo uplod
        foreach(range(0, $file) as $index) {
            $rules['file.' . $index] = 'image|mimes:jpeg,gif,png|dimensions:min_width='.$this->size->largura;
        }
        */


        /*************************  $img ******************************/
        $rules['img.code']       = 'required';
        $rules['img.color']      = 'required';
        $rules['img.order']      = 'required';
        $rules['img.order']      = 'required|min:0';
        $rules['img.product_id'] = 'required';

        if ($configProduct->mini_colors == 'hexa') {
            $rules['img.html'] = 'required';
        }


        /*************************  $groups ***************************/
        if ($configProduct->group_colors == 1) {
            if ( empty($this->request->get('groups')) ) {
                $rules['groups'] = 'required';
            }
        }

        /*************************  method POST ******************************/
        if ($this->method() == 'POST') {
            /************************* $file *****************************/
            $rules['file'] = 'required|image|mimes:jpeg,gif,png|dimensions:min_width=' . $this->size->img_width;

            /************************* $grids ****************************/
            $grids = $this->request->get('grids');
            if (empty($grids)) {
                $rules['grids'] = 'required';
            } else {

                if ($product->kit == 1) {
                    $rules['grids.grid'] = 'required';
                    if ($product->stock == 1) {
                        $rules['grids.input'] = 'required';
                        if ($product->qty_min == 1) {
                            $rules['grids.qty_min'] = 'required';
                        }
                        if ($product->qty_max == 1) {
                            $rules['grids.qty_max'] = 'required';
                        }
                    }

                } else {
                    foreach ($grids as $key => $values) {
                        foreach ($values as $index => $item) {
                            ($key == 'grid' && $item == null ? $rules['desc'] = 'required' : '');
                            if ($product->stock == 1) {
                                ($key == 'input' && $item == null ? $rules['input'] = 'required' : '');
                                if ($product->qty_min == 1) {
                                    ($key == 'qty_min' && $item == null ? $rules['qty_min'] = 'required' : '');
                                }
                                if ($product->qty_max == 1) {
                                    ($key == 'qty_max' && $item == null ? $rules['qty_max'] = 'required' : '');
                                }
                            }
                        }
                    }
                }
            }
        }

        /*************************  method PUT ******************************/
        if ($this->method() == 'PUT') {

            $file = $this->request->has('file');
            if ($file == 0) {
                $rules['file'] = 'image|mimes:jpeg,gif,png|dimensions:min_width='.$this->size->img_width;
            }
        }
       //dd($rules);
        return $rules;
    }


    public function messages()
    {
        $messages = [];
        /****************************  GRIDS *********************************/
        $messages['grids.required'] = constLang('validation.grids.grids');
        $messages['grids.grid.required'] = constLang('validation.grids.grids');
        $messages['grids.qty.required'] = constLang('validation.grids.qty');
        /*************************  method POST ******************************/
        if ($this->method() == 'POST') {

            $img     = $this->request->get('img');
            $product = $this->interProduct->setId($img['product_id']);

            if ( !empty($this->request->get('grids')) ) {
                $message_grid = constLang('validation.grids.grid');
                $message_input = constLang('validation.grids.input');
                $message_qty_min = constLang('validation.grids.qty_min');
                $message_qty_max = constLang('validation.grids.qty_max');

                if ($product->kit == 1) {
                    $messages['grids.input.required'] = $message_input;
                    $messages['grids.qty_min.required'] = $message_qty_min;
                    $messages['grids.qty_max.required'] = $message_qty_max;
                } else {
                    foreach ($this->request->get('grids') as $key => $values) {
                        foreach ($values as $index => $item) {
                            ($key == 'grid' && $item == null ? $messages['desc.required'] = $message_grid : '');
                            ($key == 'input' && $item == null ? $messages['input.required'] = $message_input : '');
                            ($key == 'qty_min' && $item == null ? $messages['qty_min.required'] = $message_qty_min : '');
                            ($key == 'qty_max' && $item == null ? $messages['qty_max.required'] = $message_qty_max : '');
                        }
                    }
                }

            }
        }

        $messages['img.product_id.required'] = 'Adicione um produto.';
        $messages['img.code.required'] = 'O código é obrigatório.';
        $messages['img.color.required'] = 'A cor é obrigatória.';
        $messages['img.order.required'] = 'A ordem é obrigatória.';
        $messages['img.html.required'] = 'Clique na imagem para criar a miniatura.';
        $messages['groups.required'] = 'Selecione no mínimo um grupo de cores.';
        $messages['file.required'] = 'A imagem é obrigatória.';
        $messages['file.image'] = 'Este arquivo é inválido, ';
        $messages['file.mimes'] = 'deverá conter uma imagem do tipo:(jpg,png,gif)';
        $messages['file.dimensions'] = 'largura mínima: '.$this->size->width.' pixels)';
        //dd($messages);
        return $messages;
    }   
}
