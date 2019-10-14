<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ConfigColorGroup as Model;
use AVDPainel\Interfaces\Admin\ConfigColorGroupInterface;

use Illuminate\Foundation\Validation\ValidatesRequests;

class ConfigColorGroupRepository implements ConfigColorGroupInterface
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

    /**
     * Init Model
     *
     * @return array
     */
    public function getAll()
    {
        $data  = $this->model->get();
        return $data;    
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return array
     */
    public function setId($id)
    {
        return $this->model->find($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array $input
     * @return boolean true or false
     */
    public function create($input)
    {
        // if < 10 add 0 in front
        $count = strlen($input['order']);
        if ($count == 1) {
            $input['order'] = '0'.$input['order'];
        }

        $data = $this->model->create($input);
        if ($data) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Adicionou uma cor no grupo, Nome:'.$data->name.
                ', Código:'.$data->code.
                ', Ordem:'.$data->order.
                ', Status:'.$data->active)
            );

            return $data;
        }

        return false;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  array $input
     * @return boolean true or false
     */
    public function update($input, $id)
    {
        // if < 10 add 0 in front
        $count = strlen($input['order']);
        if ($count == 1) {
            $input['order'] = '0'.$input['order'];
        }

        $data    = $this->model->find($id);
        $name    = $data->name;
        $code    = $data->code;
        $order   = $data->order;
        $status  = $data->active;
        $description = $data->description;

        $update = $data->update($input);
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Alterou a cor no grupo, Nome'.$name.
                ', Código:'.$code.
                ', Status:'.$status.
                ', Ordem:'.$order.
                ' para Nome:'.$data->name.
                ', Código:'.$data->code.
                ', Status:'.$data->active.
                ', Ordem:'.$data->order)
            );

            return $data;
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return boolean true or false
     */
    public function delete($id)
    {
        $data   = $this->model->find($id);
        $delete = $data->delete();
        if ($delete) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Excluiu a cor do grupo:  Nome:'.$data->name.
                ', Código:'.$data->code.
                ', Status:'.$data->active.
                ', Ordem:'.$data->order)
            );
            return true;
        }

        return false;
    }

}