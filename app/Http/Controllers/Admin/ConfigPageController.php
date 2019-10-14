<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigPageInterface as InterModel;
use AVDPainel\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;

class ConfigPageController extends Controller
{

    protected $content = 'Configuração: Templates do Site';
    protected $ability = 'config-site';
    protected $view    = 'backend.settings.template';
    protected $last_url;
    protected $model;

    public function __construct(
        InterModel $interModel,
        InterAccess $access)
    {

        $this->middleware('auth:admin');

        $this->interModel = $interModel;
        $this->access     = $access;
        $this->last_url   = array("last_url" => "config/page-site");

        $this->messages = array(
            "fields" => array(
                'name' => 'Nome',
                'module' => "Modulo",
                'active' => 'Status'
            ),
            "accesses" => array(
                'create' => "Adicionou {$this->content} ",
                'update' => "Alterou {$this->content} ",
                'delete' => "Excluiu {$this->content} ",
                'delete_all' => "Excluiu todos os modulos referente a página "
            ),
            'name.required' => 'A página é obrigatória',
            'name.unique' => 'Já existe uma página com este nome',
            'module.required' => 'O modulo é obrigatório',
            'active.required' => 'O status é obrigatório',
            'title_index' => $this->content,
            'title_page' => "Adicionar Página",
            'title_model' => "Adicionar Modulo",
            'text_page' => "Página",
            'text_model' => "Mólulo",
            'edit_page' => "Editar Página",
            'edit_model' => "Editar Módulo",
            'create_true' => 'O registro foi salvo',
            'create_false' => 'Não foi possível salvar o registro',
            'update_true' => 'O registro foi alterado',
            'update_false' => 'Não foi possível alterar o registro',
            'delete_true' => 'O registro foi excluido',
            'delete_false' => 'Não foi possível excluir o registro'
        );
    }

    /**
     * @return View
     */
    public function index()
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $this->access->update($this->last_url);
        $config = $this->messages;

        $pages = $this->interModel->getAll();


        return view("{$this->view}.index", compact('config','pages'));
    }

    /**
     * @return View
     */
    public function load()
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $config = $this->messages;

        $pages = $this->interModel->getAll();

        return view("{$this->view}.load", compact('config','pages'));
    }


    /**
     * @return View
     */
    public function create()
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $config = $this->messages;

        return view("{$this->view}.form-page-create", compact('config'));
    }


    /**
     * @param Request $request
     * @return json
     */
    public function store(Request $request)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $this->interModel->rules($request, $this->messages);

        $dataForm = $request->all();

        $create = $this->interModel->create($dataForm, $this->messages);

        return response()->json($create);
    }

    /**
     * @param $id
     * @return View
     */
    public function show($id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->setId($id);

        return view("{$this->view}.form-page-edit", compact('data'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return json
     */
    public function update(Request $request, $id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $this->interModel->rules($request, $this->messages, $id);

        $dataForm = $request->all();

        $update = $this->interModel->update($dataForm, $id, $this->messages);

        return response()->json($update);

    }

    /**
     * @param $id
     * @return json
     */
    public function destroy($id)
    {
        if( Gate::denies("{$this->ability}-delete") ) {
            return view("backend.erros.message-401");
        }

        $delete = $this->interModel->delete($id, $this->messages);

        return response()->json($delete);
    }
}
