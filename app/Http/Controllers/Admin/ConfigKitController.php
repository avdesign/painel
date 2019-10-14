<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Http\Controllers\AdminAjaxTablesController;
use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigKitInterface as InterModel;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as InterConfigSystem;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;


class ConfigkitController extends AdminAjaxTablesController
{
    
    protected $ability = 'config-kit';
    protected $view    = 'backend.settings.kits';
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
        $this->last_url   = array('last_url' => 'settings/kits');
        $this->messages = array(
            'name.required'   => 'O nome é obrigatório.',
            'order.required'  => 'A ordem é obrigatória.',
            'title_index'     => 'Configurar Kits',
            'title_create'    => 'Adicionar Kit',
            'title_edit'      => 'Editar Kit',
            'store_true'      => 'O kit foi cadastrado.',
            'store_false'     => 'Não foi possível cadastrar o kit.',
            'update_true'     => 'O kit foi alterada.',
            'update_false'    => 'Não foi possível alterar o kit.',
            'delete_true'     => 'O kit foi excluida.',
            'delete_false'    => 'Não foi possível excluir o kit.'
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


}
