<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ConfigManufacturer as Model;
use AVDPainel\Interfaces\Admin\ConfigManufacturerInterface;

use Illuminate\Foundation\Validation\ValidatesRequests;

class ConfigManufacturerRepository implements ConfigManufacturerInterface
{
    use ValidatesRequests;

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
     * ValidatesRequests
     *
     * @param  array $input
     * @param  array $messages
     * @return array
     */
    public function rules($input, $messages, $id='')
    {
        $this->validate($input, $this->model->rules($id), $messages);
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
                ' Alterou a configuração dos fabricantes para Informação:'
                .($data->info == 1 ? 'Ativo' : 'Inativo').
                ', Descrição:'.($data->description == 1 ? 'Ativo' : 'Inativo').
                ', Grades:'.($data->grids == 1 ? 'Ativo' : 'Inativo').
                ', Imagem Padrão:'.($data->img_default == 'B' ? 'Banner' : 'Inativo').
                ', Img Logo:'.($data->img_logo == 1 ? 'Ativo' : 'Inativo').
                ', Largura Logo:'.$data->width_logo.
                ', Altura Logo:'.$data->height_logo.
                ', Img Banner:'.($data->img_banner == 1 ? 'Ativo' : 'Inativo').
                ', Largura Banner:'.$data->width_banner.
                ', Altura Banner:'.$data->height_banner)
            );
            return true;
        }

        return false;

    }

}