<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigTemplateInterface as InterModel;
use AVDPainel\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;


class ConfigTemplateController extends Controller
{
    protected $content = 'Configuração: Template do Site';
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
                'tmp' => 'Template',
                'name' => 'Nome',
                'module' => "Modulo",
                'active' => 'Status',
                'status' => 'Status',
                'save' => 'Salvar',
                'cancel' => 'Cancelar',
                'update' => 'Alterar',
                'delete' => 'Excluir'
            ),
            "accesses" => array(
                'create' => "Adicionou {$this->content} ",
                'update' => "Alterou {$this->content} ",
                'delete' => "Excluiu {$this->content} ",
            ),
            'name.required' => 'A página é obrigatória',
            'name.unique' => 'Já existe uma página com este nome',
            'module.required' => 'O modulo é obrigatório',
            'active.required' => 'O status é obrigatório',
            'title_index' => $this->content,
            'create_model' => array(
                "create" => "Modulo",
                "title" => "Adicionar Modulo"
            ),
            'create_page' => array(
                "create" => "Página",
                "title" => "Adicionar Página"
            ),
            'select_text' => 'Selecione um',
            'edit_model' => "Editar Modulo",
            'edit_page' => "Editar Página",
            'create_true' => 'O registro foi salvo',
            'create_false' => 'Não foi possível salvar o registro',
            'update_true' => 'O registro foi alterado',
            'update_false' => 'Não foi possível alterar o registro',
            'delete_true' => 'O registro foi excluido',
            'delete_false' => 'Não foi possível excluir o registro',
            'status_true' => 'O status foi alterado',
            'status_false' => 'Não foi possível alterar o status',
            'error_serve' => 'Houve um erro no servidor.'
        );
    }



    public function index(ConfigPage $configPage)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $this->access->update($this->last_url);
        $config = $this->messages;

        $pages = $configPage->orderBy('name')->get();

        return view("{$this->view}.index", compact('config','pages'));
    }




    /**
     * Adicionar Modulo.
     *
     * @return View
     */
    public function create()
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $pages = \AVDPainel\Models\Admin\ConfigPage::orderBy('name')->get();

        $config = $this->messages;

        return view("{$this->view}.form-module-create", compact('config','pages'));
    }



    /**
     * Salvar Modulo
     *
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
     * Display the specified resource.
     *
     * @param  \AVDPainel\Models\Admin\ConfigTemplate  $configTemplate
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $pages = \AVDPainel\Models\Admin\ConfigPage::orderBy('name')->get();
        $data = $this->interModel->setId($id);
        $config = $this->messages;

        return view("{$this->view}.form-module-edit", compact('config','data', 'pages'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \AVDPainel\Models\Admin\ConfigTemplate  $configTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    public function destroy($id)
    {
        if( Gate::denies("{$this->ability}-delete") ) {
            return view("backend.erros.message-401");
        }

        $delete = $this->interModel->delete($id, $this->messages);

        return response()->json($delete);
    }
}
