<?php

namespace AVDPainel\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $user = $this->get('user');
        $rules['user.profile_id'] = "required";


        ( $this->method() == 'POST' ? $id = '' : $id = $user['id'] );

        foreach ($user as $key => $value) {
            if ($key == 'profile_id' && $value == 1) {
                $rules['user.document1']  = "required|cpf|formato_cpf|unique:users,document1,{$id},id";
            }

            if ($key == 'profile_id' && $value == 2) {
                $rules['user.document1']  = "required|cpf|formato_cpf|unique:users,document1,{$id},id";
            }

            if ($key == 'profile_id' && $value == 3) {
                $rules['user.document1']  = "required|cnpj|formato_cnpj|unique:users,document1,{$id},id";
            }
        }

        $rules['user.first_name']  = "required";
        $rules['user.last_name']   = "required";
        $rules['user.document2']   = "required";
        $rules['user.email']       = "required|email|unique:users,email,{$id},id";
        $rules['user.date']        = "required";
        $rules['user.cell']        = "required";

        if ($this->method() == 'PUT') {
            if (isset($user['reset_password'])) {
                $password                  = "required|";
                $password_min              = "min:6|";
                $password_string           = "string|";
                $password_confirmed        = "confirmed";
                $rules['user.password']    = $password.$password_string.$password_min.$password_confirmed;
            }
        }


        if ($this->method() == 'POST') {

            $password                  = "required|";
            $password_min              = "min:6|";
            $password_string           = "string|";
            $password_confirmed        = "confirmed";
            $rules['user.password']    = $password.$password_string.$password_min.$password_confirmed;

            $address                   = $this->get('address');
            $rules['address.zip_code'] = "required";
            $rules['address.state']    = "required";
            $rules['address.address']  = "required";
            $rules['address.number']   = "required";
            $rules['address.district'] = "required";
            $rules['address.city']     = "required";
        }


        return $rules;
    }


    public function messages()
    {
        $user = $this->get('user');

        foreach ($user as $key => $value) {
            if ($key == 'profile_id' && $value == 1) {
                $document1 = 'CPF';
                $document_1 = strtolower($document1);
                $document2 = 'A RG é obrigatório.';
                $first_name = 'A Nome é obrigatório.';
                $last_name = 'A Sobre Nome é obrigatório';
            }

            if ($key == 'profile_id' && $value == 2) {
                $document1 = 'CPF';
                $document_1 = strtolower($document1);
                $document2 = 'A RG é obrigatório.';
                $first_name = 'A Nome é obrigatório.';
                $last_name = 'A Sobre Nome é obrigatório';
            }

            if ($key == 'profile_id' && $value == 3) {
                $document1 = 'CNPJ';
                $document_1 = strtolower($document1);
                $document2 = 'A Inscrição é obrigatória';
                $first_name = 'A Razão Social é obrigatória.';
                $last_name = 'A Inscrição Estadual é obrigatória.';
            }
        }

        $messages = [
            'user.profile_id.required'            => 'O Perfil é Obrigatório',
            'user.first_name.required'            => $first_name,
            'user.last_name.required'             => $last_name,
            'user.document1.required'             => "O {$document1} é obrigatório.",
            'user.document1.'.$document_1         => "Este {$document1} não é um número válido, ",
            'user.document1.unique'               => "Já existe um cadastro com este {$document1}.",
            'user.document1.formato_'.$document_1 => "O {$document1} não possui um formato válido.",
            'user.document2.required'             => $document2,
            'user.email.required'                 => "O Email é obrigatório.",
            'user.email.email'                    => "Digite um email valído.",
            'user.email.unique'                   => "Já existe um cadastro com este email.",
            'user.date.required'                  => "A data de nascimento é obrigatória",
            'user.date.min'                       => "A data de nascimento não é valida",
            'user.date.max'                       => "A data de nascimento não é valida",
            'user.cell.required'                  => "O Celular é obrigatório.",
            'user.cell.celular_com_ddd'           => "Digite o A data de nascimento é obrigatóriacelular neste formato (99)99999-9999",
            'user.phone.telefone_com_ddd'         => "Digite o telefone neste formato (99)9999-9999",
            'address.zip_code.required'           => 'O CEP é obrigatório.',
            'address.state.required'              => 'O Estado é obrigatório.',
            'address.address.required'            => 'O Endereço é obrigatório.',
            'address.number.required'             => 'O Número é obrigatório.',
            'address.district.required'           => 'O Bairro é obrigatório.',
            'address.city.required'               => 'A Cidade é obrigatória.',
            'user.password.required'              => "A Senha é obrigatória.",
            'user.password.min'                   => "A Senha deverá conter no mínimo 6 caracteres.",
            'user.password_confirmation'          => "A Confirmação da senha é obrigatória.",
            'user.password.confirmed'             => "A Confirmação da senha não coincide.",
        ];


        return $messages;
    }

}
