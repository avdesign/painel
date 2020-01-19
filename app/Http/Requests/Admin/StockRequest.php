<?php

namespace AVDPainel\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use AVDPainel\Interfaces\Admin\ConfigProductInterface as ConfigProduct;

class StockRequest extends FormRequest
{
    /**
     * @var ConfigProduct
     */
    private $configProduct;

    public function __construct(ConfigProduct $configProduct)
    {
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
        $config = $this->configProduct->setId(1);

        $rules['ac'] = "required";
        $rules['qty'] = "required|numeric|min:1";


        if ($config->qty_min == 1) {
            $rules['qty_min'] = "required|numeric|min:1";
        }

        if ($config->qty_max == 1) {
            $rules['qty_max'] = "required|numeric|min:1";
        }

        $rules['note'] = "required|min:5";


        return $rules;

    }

    public function messages()
    {
        $messages = [
            'ac.required'       => constLang('messages.stock.action_null'),
            'qty.required'      => 'A quantidade é obrigatória',
            'qty.numeric'       => 'A quantidade deve ser um número inteiro',
            'qty.min'           => 'A quantidade deve ser no minímo 1',
            'qty_min.required'  => 'A quantidade miníma é obrigatória',
            'qty_min.numeric'   => 'A quantidade miníma deve ser um número inteiro',
            'qty_min.min'       => 'A quantidade miníma deve ser no minímo 1',
            'qty_max.required'  => 'A quantidade maxima é obrigatória',
            'qty_max.numeric'   => 'A quantidade maxima deve ser um número inteiro',
            'qty_max.min'       => 'A quantidade maxima deve ser no minímo 1',
            'note.required'     => 'A observação é obrigatória',
            'note.min'          => 'A observação deve ter no minímo 5 caracteries',

        ];


        return $messages;
    }
}
