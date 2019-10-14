<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigColorGroupInterface as InterModel;
use AVDPainel\Http\Controllers\AdminAjaxDataController;

use Illuminate\Http\Request;

class ConfigColorGroupController extends AdminAjaxDataController
{

    protected $ability      = 'config-color-group';
    protected $view         = 'backend.settings.images.colors-group';
    protected $route_edit   = 'grupo-colors.edit';
    protected $route_delete = 'grupo-colors.destroy';
    protected $last_url;


    public function __construct(
        InterAccess $access,
        InterModel $interModel)
    {
        $this->middleware('auth:admin');


        $this->access     = $access;
        $this->interModel = $interModel;
        $this->last_url   = array('last_url' => 'config/grupo-colors');
        $this->messages   = array(
            'code.required'  => 'A cor é obrigatória.',
            'code.unique'    => 'Esta cor já se encontra utilizada.',
            'name.required'  => 'O nome é obrigatório.',
            'name.unique'    => 'Este nome já se encontra utilizado.',
            'order.required' => 'A ordem é obrigatória.',
            'route'          => 'grupo-cores.edit',
            'title_index'    => 'Grupo de cores',
            'title_create'   => 'Adicionar Cor',
            'title_edit'     => 'Editar Cor',
            'store_true'     => 'A cor foi cadastrada.',
            'store_false'    => 'Não foi possível cadastrar a cor.',
            'update_true'    => 'A cor foi alterada.',
            'update_false'   => 'Não foi possível alterar a cor.',
            'delete_true'    => 'A cor foi excluida.',
            'delete_false'   => 'Não foi possível excluir a cor.'
        );
    }


    
}
