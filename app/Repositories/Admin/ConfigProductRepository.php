<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ConfigProduct as Model;
use AVDPainel\Interfaces\Admin\ConfigProductInterface;



class ConfigProductRepository implements ConfigProductInterface
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

    public function get($value, $id)
    {
        $data = $this->model->find($id);
        return $data->value;
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
                ' Alterou a configuração dos produtos para Visualizar Preço:'.
                ($data->view_prices == 1 ? 'Logado' : 'Liberado').
                ', Preço por Perfil:'.($data->price_profile == 1 ? 'Sim' : 'Não').
                ', Custo:'.($data->cost == 1 ? 'Ativo' : 'Inativo').
                ', Estoque:'.($data->stock == 1 ? 'Ativo' : 'Inativo').
                ', Grades:'.($data->grids == 1 ? 'Ativo' : 'Inativo').
                ', Frete:'.($data->freight == 1 ? 'Ativo' : 'Inativo').
                ', Kit:'.($data->kit == 1 ? 'Ativo' : 'Inativo').
                ', Estoque mínimo dos kits:'.$data->qty_min_kit.
                ', Estoque máximo dos kits:'.$data->qty_max_kit.
                ', Estoque mínimo das unidades:'.$data->qty_min_unit.
                ', Estoque máximo das unidade:'.$data->qty_max_unit.
                ', Grupo de cores:'.($data->group_colors == 1 ? 'Ativo' : 'Inativo').
                ', Posições:'.($data->positions == 1 ? 'Ativo' : 'Inativo').
                ', Video:'.($data->video == 1 ? 'Ativo' : 'Inativo').
                ', Miniaturas:'.$data->mini_colors)
            );
            return true;
        }

        return false;

    }

}