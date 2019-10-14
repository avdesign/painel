<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\UserAddress as Model;
use AVDPainel\Interfaces\Admin\UserAddressInterface;


class UserAddressRepository implements UserAddressInterface
{

    public $model;

    /**
     * Create construct.
     *
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function setId($id)
    {
        return $this->model->find($id);
    }

    /**
     * Create
     *
     * @param  array $input
     * @return mixed
     */
    public function create($input)
    {
        $address = $this->model->where('user_id', $input['user_id'])->get();
        $count = count($address);
        if ($count >= 2) {
            return 2;
        }
        if ($input['delivery'] == 1) {
            foreach ($address as $value) {
                $update = [
                    'delivery' => 0
                ];
                $data   = $this->model->find($value->id);
                $update = $data->update($update);
            }

        }
        $data = $this->model->create($input);
        if ($data) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(' Adicionou um endereço para o cliente:'.$data->user_id.
                    ', Endereço:'.$data->address.
                    ', Número:'.$data->number.
                    ', Complemento:'.$data->complement.
                    ', Bairro:'.$data->district.
                    ', Cidade:'.$data->city.
                    ', Estado:'.$data->state.
                    ', CEP:'.$data->zip_code)
            );

            return 1;
        }
        return false;
    }

    /**
     * @param $input
     * @param $id
     * @return mixed
     */
    public function update($input, $id)
    {
        $data    = $this->model->find($id);


        $address    = $data->address;
        $number     = $data->number;
        $complement = $data->complement;
        $district   = $data->district;
        $city       = $data->city;
        $state      = $data->state;
        $zip_code   = $data->zip_code;

        $update = $data->update($input);
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(' Alterou o endereço do cliente:'.$data->user_id.
                ', Endereço:'.$address.
                ', Número:'.$number.
                ', Complemento:'.$complement.
                ', Bairro:'.$district.
                ', Cidade:'.$city.
                ', Estado:'.$state.
                ', CEP:'.$zip_code.
                ', Para Endereço:'.$data->address.
                ', Número:'.$data->number.
                ', Complemento:'.$data->complement.
                ', Bairro:'.$data->district.
                ', Cidade:'.$data->city.
                ', Estado:'.$data->state.
                ', CEP:'.$data->zip_code)
            );

            return true;
        }
        return false;
    }


}