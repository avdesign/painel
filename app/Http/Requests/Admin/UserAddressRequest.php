<?php

namespace AVDPainel\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserAddressRequest extends FormRequest
{
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
        $address = $this->get('address');

        $rules['address.delivery'] = "required";
        $rules['address.zip_code'] = "required";
        $rules['address.state']    = "required";
        $rules['address.address']  = "required";
        $rules['address.number']   = "required";
        $rules['address.district'] = "required";
        $rules['address.city']     = "required";

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'address.delivery.required'           => 'É Endereço de Entrega? (Sim ou Não).',
            'address.zip_code.required'           => 'O CEP é obrigatório.',
            'address.state.required'              => 'O Estado é obrigatório.',
            'address.address.required'            => 'O Endereço é obrigatório.',
            'address.number.required'             => 'O Número é obrigatório.',
            'address.district.required'           => 'O Bairro é obrigatório.',
            'address.city.required'               => 'A Cidade é obrigatória.',
        ];


        return $messages;
    }
}
