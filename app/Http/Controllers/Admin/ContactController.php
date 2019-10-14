<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Http\Controllers\AdminAjaxTablesController;
use AVDPainel\Interfaces\Admin\ContactInterface as InterModel;
use AVDPainel\Interfaces\Admin\ContactSpamInterface as InterSpam;
use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as ConfigSystem;

use AVDPainel\Mail\ResponseContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class ContactController extends AdminAjaxTablesController
{
    protected $ability  = 'contact';
    protected $view     = 'backend.contacts';
    protected $last_url;
    protected $messages;

    public function __construct(
        InterAccess $access,
        InterSpam $interSpam,
        InterModel $interModel,
        ConfigSystem $confUser)
    {
        $this->middleware('auth:admin');

        $this->access       = $access;
        $this->confUser     = $confUser;
        $this->interSpam    = $interSpam;
        $this->interModel   = $interModel;
        $this->last_url     = array('last_url' => 'contatos');
        $this->messages     = array(
            'user_id.required'  => 'O atendente é obrigatório.',
            'subject.required'  => 'O Assunto é obrigatório.',
            'name.required'     => 'O Nome é obrigatório.',
            'email.required'    => 'O Nome é obrigatório.',
            'email.email'       => 'O email não é valído.',
            'message.required'  => 'A Mensagem é obrigatória.',
            'title_index'       => 'Mensagens do Site',
            'title_create'      => 'Enviar Mensagem',
            'store_true'        => 'A mensagem foi enviada.',
            'store_false'       => 'Não foi possível enviar a mensagem.',
            'delete_true'       => 'A mensagem foi excluida.',
            'delete_false'      => 'Não foi possível excluir a mensagem.'
        );
    }

    /**
     * @param Request $request
     * @return json
     */
    public function data(Request $request)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->getAll($request);

        return response()->json($data);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function message($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->setId($id);

        return view("{$this->view}.message", compact('data'));

    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->setId($id);

        return view("{$this->view}.details", compact('data'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return Json
     */
    public function response(Request $request, $id)
    {
        if( Gate::denies("{$this->ability}-response") ) {
            return view("backend.erros.message-401");
        }

        $dataForm = $request->all();

        if ($dataForm['return'] == '') {
            $success = false;
            $message = 'A mensagem é obrigatória';

        } else {

            $dataForm['send']   = 1;
            $dataForm['admin']  = auth()->user()->name;
            $dataForm['date_return'] = date('d/m/Y H:i:s');

            $data = $this->interModel->response($dataForm, $id);
            if ($data) {
                $success = true;
                $message = 'A mensagem foi enviada.';
                $contact = $this->interModel->setId($id);

                //Mail::to($contact)->send(new ResponseContact($contact));

            } else {
                $success = false;
                $message = "Houve um erro no servidor!<br/>Tente mais tarde.";
            }
        }

        $out = array(
            "success" => $success,
            "message" => $message,
            "refresh" => route('contacts.refresh', $id),
            'id' => $id
        );

        return response()->json($out);
    }

    /**
     * @param $id
     * @return View
     */
    public function refresh($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->setId($id);

        return view("{$this->view}.refresh", compact('data'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return Json
     */
    public function status(Request $request, $id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $dataForm = $request->all();

        $data = $this->interModel->status($dataForm, $id);
        if ($data) {
            $success = true;
            $message = 'O status alterado.';
        } else {
            $success = true;
            $message = 'Erro ao alterar o status.';
        }

        $out = array(
            "success" => $success,
            "message" => $message,
        );

        return response()->json($out);
    }

    /**
     * @param Request $request
     * @param $id
     * @return Json
     */
    public function spam(Request $request, $id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $contact = $this->interModel->setId($id);
        $input   = $contact->toArray();

        $input['admin'] = auth()->user()->name;

        $spam = $this->interSpam->create($input);
        if ($spam) {
            $data = $this->interModel->delete($id);
        }

        if ($data) {
            $success = true;
            $message = 'foi adicionado como spam.';
        } else {
            $success = true;
            $message = 'Erro ao alterar para spam.';
        }

        $out = array(
            "success" => $success,
            "message" => $message,
        );

        return response()->json($out);

    }




}
