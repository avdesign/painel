<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ConfigPage as Model;
use AVDPainel\Interfaces\Admin\ConfigPageInterface;
use AVDPainel\Interfaces\Admin\ConfigTemplateInterface as Template;

use Illuminate\Support\Str;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ConfigPageRepository implements ConfigPageInterface
{
    use ValidatesRequests;

    public $model;
    public $template;

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
    public function __construct(Model $model, Template $template)
    {
        $this->model = $model;
        $this->template = $template;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this->model->orderBy('name')->get();
        return $data;
    }

    /**
     * @param $input
     * @param $message
     * @return array
     */
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
     * @param $message
     * @return array
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

    /**
     * @param $id
     * @param $message
     * @return array
     */
    public function delete($id, $message)
    {

        $data   = $this->setId($id);

        $temp = $this->template->deleteAll($id, $message);
        $delete = $data->delete();
        if ($delete) {
            $acc = $message['accesses'];
            $fds = $message['fields'];
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                    ' '.$acc['delete'].$fds['module'].':'.$data->name)
            );

            $success = true;
            $message = $message['delete_true'];

        } else {
            $success = false;
            $message = $message['delete_false'];
        }

        $out = array(
            "success" => $success,
            "message" => $message
        );

        return $out;
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