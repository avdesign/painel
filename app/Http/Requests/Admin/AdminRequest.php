<?php

namespace AVDPainel\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
        $id = numLetter($this->get('has'));

        if ($this->method() == 'PUT') {
            $confirmed = '';
            $password  = '';
            $login     = '';
        }
        else {

            $confirmed = 'required|same:password';
            $password  = 'required|min:6|max:10';
            $login     = "required|min:3|max:10|unique:admins,login,{$id},id";
        }

        return [
            'profile_id' => 'required',
            'name' => 'required',
            'email' => "required|email|unique:admins,email,{$id},id",
            'login' => $login,
            'phone' => 'required',
            'password' => $password,
            'password_confirmation' => $confirmed,
            'commission' => 'required',
            'percent' => 'required',
            'active' => 'required'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'profile_id.required'  => 'O perfil é obrigatório.',
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Digite um endereço de email válido.',
            'email.unique' => 'Este email já se encontra utilizado.',
            'login.required' => 'O login é obrigatório.',
            'login.unique' => 'Este login já se encontra utilizado.',
            'login.min' => 'O login deverá conter no mínimo 6 caracteres.',
            'login.max' => 'O login não deverá conter mais de 10 caracteres.',
            'phone.required' => 'O telefone é obrigatório.',
            'password.required' => 'A senha  é obrigatória.',
            'password.min' => 'A senha deverá conter no mínimo 6 caracteres.',
            'password.max' => 'A senha não deverá conter mais de 10 caracteres.',
            'password_confirmation.required' => 'A confirmação da senha é obrigatória.',
            'password_confirmation.same' => 'A confirmação da senha não coincide.',
            'commission.required'  => 'Comissionado: Sim ou Não?',
            'percent.required'  => 'A porcentagem é obrigatória.',
            'status.required'  => 'O status é obrigatório.'
        ];
    }
}
