<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Http\Controllers\AdminAjaxTablesController;

use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigPercentInterface as InterModel;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as InterConfigSystem;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;


class ConfigPercentController extends AdminAjaxTablesController
{
    
    protected $ability = 'config-percent';
    protected $view    = 'backend.settings.percents';
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
        $this->last_url   = array('last_url' => 'config/percents');
        $this->messages   = array(
            'percent.required'   => 'A porcentagem é obrigatória.',
            'percent.unique'     => 'Esta porcentagem já se encontra utilizado.',
            'order.required'     => 'A ordem é obrigatória.',
            'title_index'        => 'Editar Porcentagens',
            'title_create'       => 'Adicionar Porcentagem',
            'title_edit'         => 'Editar porcentagem',
            'store_true'         => 'A porcentagem foi cadastrada.',
            'store_false'        => 'Não foi possível cadastrar a porcentagem.',
            'update_true'        => 'A porcentagem foi alterada.',
            'update_false'       => 'Não foi possível alterar a porcentagem.',
            'delete_true'        => 'A porcentagem foi excluida.',
            'delete_false'       => 'Não foi possível excluir a porcentagem.'
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
