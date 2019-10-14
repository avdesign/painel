<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ConfigFreight as Model;
use AVDPainel\Interfaces\Admin\ConfigFreightInterface;



class ConfigFreightRepository implements ConfigFreightInterface
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


    public function setId($id)
    {
        return $this->model->find($id);
    }


    public function update($input, $id)
    {
        $data = $this->model->find($id);

        $update = $data->update($input);
        if ($update) {

            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Alterou para Frete:'
                .($data->default == 1 ? 'Ativo' : 'Inativo').
                ', Peso:'.($data->weight == 1 ? 'Ativo' : 'Inativo').
                ', Largura:'.($data->width == 1 ? 'Ativo' : 'Inativo').
                ', Altura:'.($data->height == 1 ? 'Ativo' : 'Inativo').
                ', Comprimento:'.($data->length == 1 ? 'Ativo' : 'Inativo'))
            );
            return true;
        }

        return false;

    }

}