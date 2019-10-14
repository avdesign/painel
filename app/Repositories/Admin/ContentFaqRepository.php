<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ContentFaq as Model;
use AVDPainel\Interfaces\Admin\ContentFaqInterface;

use Illuminate\Foundation\Validation\ValidatesRequests;

class ContentFaqRepository implements ContentFaqInterface
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
    public function create($input, $message)
    {
        $input['response'] = trim($input['response']);
        $count = strlen($input['order']);
        if ($count == 1) {
            $input['order'] = '0'.$input['order'];
        }

        $data = $this->model->create($input);

        if ($data) {

            $acc = $message['accesses'];
            $fid = $message['fields'];

            generateAccessesTxt(date('H:i:s').utf8_decode(
                    ', '.$acc['create'].
                    ', '.$fid['order'].':'.$data->order.
                    ', '.$fid['active'].':'.$data->active.
                    ', '.$fid['question'].':'.$data->question.
                    ', '.$fid['response'].':'.strip_tags($data->response))
            );

            $success = true;
            $message = $message['create_true'];

        } else {
            $success = true;
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
        $input['response'] = trim($input['response']);

        $data = $this->setId($id);

        $update = $data->update($input);
        if ($update) {

            $acc = $message['accesses'];
            $fid = $message['fields'];

            generateAccessesTxt(date('H:i:s').utf8_decode(
                    ', '.$acc['update'].
                    ', '.$fid['order'].':'.$data->order.
                    ', '.$fid['active'].':'.$data->active.
                    ', '.$fid['question'].':'.$data->question.
                    ', '.$fid['response'].':'.strip_tags($data->response))
            );

            $success = true;
            $message = $message['update_true'];
        } else {
            $success = false;
            $message = $message['update_false'];
        }

        $out = array(
            "success" => $success,
            "message" => $message,
            "question" => $input['question'],
            "response" => $input['response']
        );

        return $out;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id, $message)
    {
        $data   = $this->setId($id);
        $delete = $data->delete();
        if ($delete) {

            $acc = $message['accesses'];
            $fid = $message['fields'];

            generateAccessesTxt(date('H:i:s').utf8_decode(
                    ', '.$acc['delete'].
                    ', '.$fid['order'].':'.$data->order.
                    ', '.$fid['active'].':'.$data->active.
                    ', '.$fid['question'].':'.$data->question.
                    ', '.$fid['response'].':'.strip_tags($data->response))
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
     * Alterar Status
     *
     * @param  int $id
     * @return json
     */
    public function status($id, $message)
    {

        $data = $this->model->find($id);
        ($data->active == constLang('active_true') ?
            $change = ['active' => constLang('active_false')] :
            $change = ['active' => constLang('active_true')]);

        $update = $data->update($change);
        if ($update) {

            $acc = $message['accesses'];
            $fid = $message['fields'];

            generateAccessesTxt(date('H:i:s').utf8_decode(
                    ', '.$acc['update'].
                    ', '.$fid['order'].':'.$data->order.
                    ', '.$fid['active'].':'.$data->active.
                    ', '.$fid['question'].':'.$data->question.
                    ', '.$fid['response'].':'.strip_tags($data->response))
            );

            ($data->active == constLang('active_true') ? $class = 'button icon-tick with-tooltip' : $class = 'button icon-tick with-tooltip red');

            $out = array(
                "success" => true,
                "message" => "{$message['status_true']} para {$data->active}",
                "class"   => $class,
                "text"    => $data->active
            );

        } else {
            $out = array(
                "success"    => false,
                "message"    => "{$message['status_false']} para {$change['active']}"
            );
        }

        return $out;
    }



    /**
     * Retorna o input ordem
     *
     * @param $id
     * @return mixed
     */
    public function getOrder($id)
    {
        $data = $this->setId($id);
        return $data->order;
    }

    /**
     * Alterar ordem
     *
     * @param $input
     * @param $messages
     * @return array
     */
    public function updateOrder($input, $message)
    {
        $change['order'] = $input['order'];

        if (strlen($input['order']) == 1) {
            $change['order'] = '0'.$input['order'];
        }
        $data = $this->setId($input['id']);

        $update = $data->update($change);
        if ($update) {

            $acc = $message['accesses'];
            $fid = $message['fields'];

            generateAccessesTxt(date('H:i:s').utf8_decode(
                    ', '.$acc['update'].
                    ', '.$fid['order'].':'.$data->order.
                    ', '.$fid['active'].':'.$data->active.
                    ', '.$fid['question'].':'.$data->question.
                    ', '.$fid['response'].':'.strip_tags($data->response))
            );

            $success = true;
            $message = "{$message['order_true']} para {$data->order}";

        } else {
            $success = false;
            $message = $message['order_false'];
        }

        $out = array(
            "success" => $success,
            "message" => $message,
        );

        return $out;
    }


}