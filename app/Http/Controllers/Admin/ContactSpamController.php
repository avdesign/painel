<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Http\Controllers\AdminAjaxTablesController;
use AVDPainel\Interfaces\Admin\ContactSpamInterface as InterModel;
use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as ConfigSystem;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ContactSpamController extends AdminAjaxTablesController
{
    protected $ability  = 'contact';
    protected $view     = 'backend.contacts.spams';
    protected $upload;
    protected $last_url;
    protected $messages;

    public function __construct(
        InterAccess $access,
        InterModel $interModel,
        ConfigSystem $confUser)
    {
        $this->middleware('auth:admin');

        $this->access       = $access;
        $this->confUser     = $confUser;
        $this->interModel   = $interModel;
        $this->last_url     = array('last_url' => 'spams');
        $this->messages     = array(
            'title_index'       => 'Lista de Spam',
            'title_create'      => 'Enviar Mensagem',
            'update_true'       => 'A mensagem foi enviada.',
            'update_false'      => 'Não foi possível enviar a mensagem.',
            'delete_true'       => 'O contato foi excluido.',
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
     * @return View
     */
    public function details($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->setId($id);

        return view("{$this->view}.details", compact('data'));
    }

}
