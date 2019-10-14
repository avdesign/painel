<?php

namespace AVDPainel\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MyProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return $this->user()->can('model-admins-profile');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id    = $this->user()->id;
        $reset = $this->get('reset-password');
        if (isset($reset)) {
            $confirmed = 'required|same:password';
            $password  = 'required|min:6|max:10';
        } else {
            $confirmed = '';
            $password  = ''; 
        }      


        return [
            'name' => 'required',
            'email' => "required|email|unique:admins,email,{$id},id",
            'login' => "required|min:3|max:10|unique:admins,login,{$id},id",
            'phone' => 'required',
            'password' => $password,
            'password_confirmation' => $confirmed
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
            'password_confirmation.same' => 'A confirmação da senha não coincide.'
        ];
    }
}
