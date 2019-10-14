<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ConfigShipping as Model;
use AVDPainel\Interfaces\Admin\ConfigShippingInterface;

use Illuminate\Foundation\Validation\ValidatesRequests;



class ConfigShippingRepository implements ConfigShippingInterface
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
     * Init Model
     *
     * @return array
     */
    public function getAll()
    {
        return $this->model->orderBy('order')->get();
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
     * @param $name
     * @param $id
     * @return mixed
     */
    public function pluck($name, $id)
    {
        return $this->model->pluck($name,$id);
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
                ' Adicionou o método de envio: '.$data->name.
                ', Descrição:'.$data->description.
                ', Ordem:'.$data->order.
                ', Status: '.$data->active)
            );

            return $data;
        }

        return false;
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

        $data        = $this->model->find($id);
        $name        = $data->name;
        $order       = $data->order;
        $status      = $data->active;
        $description = $data->description;

        $update = $data->update($input);
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Alterou o método de envio: '.$name.
                ', Descrição:'.$description.
                ', Ordem:'.$order.
                ', Status:'.$status.
                ' para método:'.$data->name.
                ', Descrição:'.$data->description.
                ', Ordem:'.$data->order.
                ', Status:'.$data->active)
            );

            return true;
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
                ' Excluiu o método de envio: '.$data->name.
                ', Descrição: '.$data->description.
                ', Ordem:'.$data->order.
                ', Status: '.$data->active)
            );
            return true;
        }

        return false;
    }

}