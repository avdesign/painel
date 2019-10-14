<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ConfigSystem as Model;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface;


class ConfigSystemRepository implements ConfigSystemInterface
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


    public function get()
    {
        $user = auth()->user()->id;
        $data = $this->model->where('admin_id', $user)->first();
        return $data;
    }


    public function create($input)
    {
        $data = $this->model->create($input);
        if ($data) {
            return true;
        } 

        return false;
    }


    public function update($input)
    {
        $data  = $this->get();
        $update = $data->update($input);
        if ($update) {

            $config = array(
                'table_color' => $data->table_color,
                'table_color_sel' => $data->table_color_sel, 
                'table_limit' => $data->table_limit, 
                'table_open_details' => $data->table_open_details 
            );
            $out = array(
                "configUser" => $config
            );

            generateAccessesTxt(
                date('H:i:s ').
                ' '.constLang('updated').
                ' '.constLang('tables_preference')
            );

            $success = true;
            $message = constLang('update_true');

        } else {
            $success = false;
            $message = constLang('update_false');
        }

        $out = array(
            "success" => $success,
            "message" => $message
        );

        return $out;
    }


}