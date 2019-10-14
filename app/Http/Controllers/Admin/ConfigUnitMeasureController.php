<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Http\Controllers\AdminAjaxTablesController;
use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigUnitMeasureInterface as InterModel;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as InterConfigSystem;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;


class ConfigUnitMeasureController extends AdminAjaxTablesController
{
    
    protected $ability = 'config-unit-measure';
    protected $view    = 'backend.settings.unit-measures';
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
        $this->last_url   = array('last_url' => 'config/units-measures');
        $this->messages = array(
            'unit.required'   => 'A unidade é obrigatória.',
            'name.required'   => 'O nome é obrigatório.',
            'order.required'  => 'A ordem é obrigatória.',
            'title_index'     => 'Unidades de Medidas',
            'title_create'    => 'Adicionar Unidade de Medida',
            'title_edit'      => 'Editar Perfil',
            'store_true'      => 'A unidade foi cadastrada.',
            'store_false'     => 'Não foi possível cadastrar a unidade.',
            'update_true'     => 'A unidade foi alterada.',
            'update_false'    => 'Não foi possível alterar a unidade.',
            'delete_true'     => 'A unidade foi excluida.',
            'delete_false'    => 'Não foi possível excluir a unidade.'
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
