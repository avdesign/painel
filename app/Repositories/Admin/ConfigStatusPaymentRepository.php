<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ConfigStatusPayment as Model;
use AVDPainel\Interfaces\Admin\ConfigStatusPaymentInterface;

use Illuminate\Foundation\Validation\ValidatesRequests;



class ConfigStatusPaymentRepository implements ConfigStatusPaymentInterface
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
     * @return mixed
     */
    public function pluck()
    {
        return $this->model->orderBy('order')->where('active', 1)->pluck('label','id');
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  array $input
     * @return boolean true or false
     */
    public function create($input)
    {
        $data = $this->model->create($input);
        if ($data) {
            ($data->status == 1 ? $status = 'Ativo' : $status = 'Inativo');

            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Adicionou o status do pagamento: '.$data->label.
                ', Descrição:'.$data->description.
                ', Ordem:'.$data->order.
                ', Status: '.$status.
                ', Gateway:'.$data->gateway.
                ', Tipo:'.$data->type)
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

        $data        = $this->model->find($id);
        $type        = $data->type;
        $label       = $data->label;
        $order       = $data->order;
        $status      = $data->status;
        $gateway     = $data->gateway;
        $description = $data->description;


        $update = $data->update($input);
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Alterou o status do pagamento: '.$label.
                ', Descrição:'.$description.
                ', Ordem:'.$order.
                ', Status:'.$status.
                ', Gateway:'.$gateway.
                ', Tipo:'.$type.
                ' para Status:'.$data->label.
                ', Descrição:'.$data->description.
                ', Ordem:'.$data->order.
                ', Status:'.$data->status.
                ', Gateway:'.$data->gateway.
                ', Tipo:'.$data->type)
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
                ' Excluiu o status do pagamento: '.$data->label.
                ', Descrição: '.$data->description.
                ', Ordem:'.$data->order.
                ', Status: '.$data->status.
                ', Gateway:'.$data->gateway.
                ', Tipo:'.$data->type)
            );
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getExcluded()
    {
        return $this->model->onlyTrashed()->orderBy('order')->get();
    }

    /**
     * @param $id
     * @return bool
     */
    public function reactivate($id)
    {
        $data = $this->model->withTrashed()->find($id);
        if ( $data->restore() ){
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                    ' Reativou o status do pagamento:'.$data->label.
                    ', Descrição: '.$data->description)
            );
            return true;
        }

        return false;
    }

}