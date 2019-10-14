<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\OrderShipping as Model;
use AVDPainel\Interfaces\Admin\OrderShippingInterface;

use Illuminate\Foundation\Validation\ValidatesRequests;

class OrderShippingRepository implements OrderShippingInterface
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
     * @param $input
     * @param $messages
     * @param string $id
     */
    public function rules($input, $messages, $id='')
    {
        $this->validate($input, $this->model->rules($id), $messages);
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
     * @param $input
     * @return bool
     */
    public function create($input)
    {
        $data = $this->model->create($input);
        if ($data) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                    ' Adicionou uma observação no pedido:'.$data->order_id.
                    ', Observação: '.$data->description)
            );

            return $data;
        }

        return false;

    }

    /**
     * @param $input
     * @param $id
     * @return bool
     */
    public function update($input, $id)
    {
        $data        = $this->model->find($id);
        $description = $data->description;

        $update = $data->update($input);
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                    ' Alterou a observação do pedido:'.$data->order_id.
                    ', Descrição:'.$data->description)
            );

            return true;
        }

        return false;
    }




    /**
     * @param $id
     * @return mixed
     */
    public function countNotes($id)
    {
        return $this->model->where('order_id',$id)->count();
    }




}