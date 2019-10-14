<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ConfigSite as Model;
use AVDPainel\Interfaces\Admin\ConfigSiteInterface;



class ConfigSiteRepository implements ConfigSiteInterface
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

            generateAccessesTxt(date('H:i:s').utf8_decode(
                ' Alterou a configuração do Site:'));
            return true;
        }

        return false;

    }

}