<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Http\Controllers\AdminAjaxTablesController;
use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigModuleInterface as InterModel;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as InterConfigSystem;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ConfigModuleController extends AdminAjaxTablesController
{

    protected $ability  = 'config-module';
    protected $view     = 'backend.settings.modules';
    protected $last_url;
    protected $messages;


    public function __construct(
        InterAccess $access,
        InterModel $interModel,
        InterConfigSystem $confUser)
    {
        $this->middleware('auth:admin');

        $this->access     = $access;
        $this->confUser   = $confUser;
        $this->interModel = $interModel;
        $this->last_url   = array('last_url' => 'config/modules');
        $this->messages   = array(
            'type.required'      => 'O tipo é obrigatório.',
            'name.required'      => 'O nome do modulo é obrigatório.',
            'name.unique'        => 'Este modulo já se encontra utilizado.',
            'label.required'     => 'A descrição é obrigatória.',
            'title_index'        => 'Modulos do sistema',
            'title_create'       => 'Adicionar Modulo',
            'title_edit'         => 'Alterar Modulo',
            'store_true'         => 'O modulo foi registrado.',
            'store_false'        => 'Não foi possível registrar o modulo.',
            'update_true'        => 'O modulo foi alterado.',
            'update_false'       => 'Não foi possível alterar o modulo.',
            'delete_true'        => 'O modulo foi excluido.',
            'delete_false'       => 'Não foi possível excluir o modulo.'
        );
    }

    public function data(Request $request)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->getAll($request);

        return response()->json($data);     
    }

    /**
     * distinct('name_id') Não repetir registros (apenas um).
     * 
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showPermissions(Request $request, $id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }
        $title   = 'Adicionar Permissão';
        $data    = $this->interModel->setId($id);
        $ativos  = $data->permissions()->distinct('module_id')->get();

        return view("{$this->view}.permissions", compact('title', 'data', 'ativos'));
    }

    


}