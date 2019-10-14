<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\UserNote as Model;
use AVDPainel\Interfaces\Admin\UserNoteInterface;


class UserNoteRepository implements UserNoteInterface
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
                    ' Adicionou uma observação para o cliente:'.$data->user_id.
                    ', Observação: '.$data->label.
                    ', Descrição: '.$data->description)
            );

            return true;
        }
        return false;
    }

    /**
     * @param $input
     * @param $id
     * @return mixed
     */
    public function update($input, $id)
    {
        $data    = $this->model->find($id);

        $label       = $data->label;
        $admin       = $data->admin;
        $description = $data->description;

        $update = $data->update($input);
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(' Alterou a observação do cliente:'.$data->user_id.
                ', Admin:'.$admin.
                ', Titulo:'.$label.
                ', Descrição:'.$description.
                ', Para Admin:'.$data->admin.
                ', Titulo:'.$data->label.
                ', Descrição:'.$data->description)
            );

            return true;
        }
        return false;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $data   = $this->model->find($id);
        $delete = $data->delete();

        if ($delete) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                    ' Excluiu a observação do cliente:'.$data->user_id.
                    ', Titulo:'.$data->label.
                    ', Descrição:'.$data->description)
            );
            return true;
        }
        return false;
    }


}