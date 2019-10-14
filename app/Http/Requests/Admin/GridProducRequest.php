<?php

namespace AVDPainel\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use AVDPainel\Interfaces\Admin\ProductInterface as InterProduct;
use AVDPainel\Interfaces\Admin\ConfigProductInterface as ConfigProduct;

class GridProducRequest extends FormRequest
{
    public function __construct(
        InterProduct $interProduct,
        ConfigProduct $configProduct)
    {

        $this->interProduct  = $interProduct;
        $this->configProduct = $configProduct;
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
        $configProduct = $this->configProduct->setId(1);

        $product = $this->interProduct->setId($this->request->get('product_id'));

        if ($configProduct->grids == 1) {

            $rules['grids.grid'] = 'required';

            if ($product->stock == 1) {
                if ($this->method() == 'POST') {
                    $rules['grids.input'] = 'required';
                }
                if ($product->qty_min == 1) {
                    $rules['grids.qty_min'] = 'required';
                }
                if ($product->qty_max == 1) {
                    $rules['grids.qty_max'] = 'required';
                }
            }
        }


        return $rules;
    }


    public function messages()
    {
        $messages = [
            'grids.grid.required'    => constLang('validation.grids.grid'),
            'grids.input.required'   => constLang('validation.grids.input'),
            'grids.qty_min.required' => constLang('validation.grids.qty_min'),
            'grids.qty_max.required' => constLang('validation.grids.qty_max')
        ];


        return $messages;
    }


}
