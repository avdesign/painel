<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ConfigSubjectContact as Model;
use AVDPainel\Interfaces\Admin\ConfigSubjectContactInterface;

use Illuminate\Foundation\Validation\ValidatesRequests;

class ConfigSubjectContactRepository implements ConfigSubjectContactInterface
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

    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this->model->orderBy('order')->get();
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
        // if < 10 add 0 in front
        $count = strlen($input['order']);
        if ($count == 1) {
            $input['order'] = '0'.$input['order'];
        }

        $data = $this->model->create($input);
        if ($data) {

            ($data->send_guest == 1 ? $send_guest = constLang('active_true') : $send_guest = constLang('active_false'));
            ($data->send_user == 1 ? $send_user = constLang('active_true') : $send_user = constLang('active_false'));
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                    ' Adicionou no formulário de contato Assunto'.$data->label.
                    ', Mensagem:'.$data->message.
                    ',Enviar para Visitante:'.$send_guest.
                    ', Cliente:'.$send_user.
                    ', Ordem:'.$data->order.
                    ', Status:'.$data->active)
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

        $data    = $this->model->find($id);


        $update = $data->update($input);
        if ($update) {
            ($data->send_guest == 1 ? $send_guest = constLang('active_true') : $send_guest = constLang('active_false'));
            ($data->send_user == 1 ? $send_user = constLang('active_true') : $send_user = constLang('active_false'));

            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                    ' Alterou no formulário de contato Assunto'.$data->label.
                    ', Mensagem:'.$data->message.
                    ',Enviar para Visitante:'.$send_guest.
                    ', Cliente:'.$send_user.
                    ', Ordem:'.$data->order.
                    ', Status:'.$data->active)
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
                    ' Excluiu o assunto do formulário Assunto: '.$data->label.
                    ', Mensagem: '.$data->message)
            );
            return true;
        }

        return false;
    }

}