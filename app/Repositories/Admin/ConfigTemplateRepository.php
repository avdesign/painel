<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ConfigTemplate as Model;
use AVDPainel\Interfaces\Admin\ConfigTemplateInterface;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Str;

class ConfigTemplateRepository implements ConfigTemplateInterface
{
    use ValidatesRequests;

    public $model;

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
     * Create construct.
     *
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }


    public function getAll()
    {
        return $this->model->orderBy('config_page_id')->get();
        return $data;
    }


    public function create($input, $message)
    {
        $input['module'] = Str::slug($input['module'], "-");

        $data = $this->model->create($input);
        if ($data) {
            $success = true;
            $message = $message['create_true'];
        } else {
            $success = false;
            $message = $message['create_false'];
        }

        $out = array(
            "success" => $success,
            "message" => $message
        );

        return $out;
    }


    /**
     * @param $input
     * @param $id
     * @return bool
     */
    public function update($input, $id, $message)
    {
        $input['module'] = Str::slug($input['module'], "-");

        $data = $this->setId($id);

        $update = $data->update($input);
        if ($update) {

            $acc = $message['accesses'];
            $fid = $message['fields'];

            generateAccessesTxt(date('H:i:s').utf8_decode(
                    ', '.$acc['update'].
                    ', '.$fid['module'].':'.$data->name.
                    ', '.$fid['tmp'].':'.$data->tmp.
                    ', '.$fid['active'].':'.$data->active)
            );

            $success = true;
            $message = $message['update_true'];
        } else {
            $success = false;
            $message = $message['update_false'];
        }

        $out = array(
            "success" => $success,
            "message" => $message
        );

        return $out;
    }


    public function delete($id, $message)
    {
        $data   = $this->setId($id);
        $delete = $data->delete();
        if ($delete) {

            $acc = $message['accesses'];
            $fid = $message['fields'];

            generateAccessesTxt(date('H:i:s').utf8_decode(
                    ', '.$acc['delete'].
                    ', '.$fid['module'].':'.$data->name.
                    ', '.$fid['active'].':'.$data->active)
            );
            $success = true;
            $message = $message['delete_true'];
        } else {
            $success = false;
            $message = $message['delete_false'];

        }

        $out = array(
            "success" => $success,
            "message"=> $message
        );

        return $out;
    }

    /**
     * Exclui todos os modulos referente ao $config_page_id
     * @param $config_page_id
     * @param $message
     */
    public function deleteAll($config_page_id, $message)
    {
        $data   = $this->model->where('config_page_id', $config_page_id);
        $delete = $data->delete();
        if ($delete) {
            $acc = $message['accesses'];
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                    ' '.$acc['delete_all']. $message['title_index'])
            );

            return true;
        }

        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function setId($id)
    {
        return $this->model->find($id);
    }

}