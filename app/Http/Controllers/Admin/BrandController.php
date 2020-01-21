<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Http\Controllers\AdminAjaxTablesController;

use AVDPainel\Interfaces\Admin\StateInterface as InterState;
use AVDPainel\Interfaces\Admin\BrandInterface as InterModel;
use AVDPainel\Interfaces\Admin\GridBrandInterface as InterGrids;
use AVDPainel\Interfaces\Admin\ConfigBrandInterface as ConfigBrand;
use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as ConfigSystem;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BrandController extends AdminAjaxTablesController
{
    protected $ability  = 'brand';
    protected $view     = 'backend.brands';
    protected $select;
    protected $upload;
    protected $last_url;
    protected $messages;
    protected $configImages = true;


    public function __construct(
        InterState $state,
        InterAccess $access,
        InterGrids $interGrids,
        InterModel $interModel,
        ConfigSystem $confUser,       
        ConfigBrand $configModel)
    {
        $this->middleware('auth:admin');

        $this->access       = $access;
        $this->confUser     = $confUser;
        $this->interModel   = $interModel;
        $this->interGrids   = $interGrids;
        $this->configModel  = $configModel->setId(1);
        $this->last_url     = array('last_url' => 'brands');
        $this->upload       = $this->configModel;
        $this->select       = array(
            'id'     => 'uf',
            'name'   => 'name',
            'type'   => 'pluck',
            'edit'   => true,
            'create' => true, 
            'table'  => $state
        );

        $this->messages = array(
            'name.required'  => 'O nome do é obrigatório.',
            'name.unique'    => 'Este nome já se encontra utilizado.',
            'order.required' => 'A ordem é obrigatória.',
            'title_index'    => 'Marcas dos Produtos',
            'title_create'   => 'Adicionar Marca',
            'title_edit'     => 'Alterar o Marca',
            'store_true'     => 'A Marca foi registrada.',
            'store_false'    => 'Não foi possível registrar a marca.',
            'update_true'    => 'A marca foi alterada.',
            'update_false'   => 'Não foi possível alterar a marca.',
            'delete_true'    => 'A marca foi excluida.',
            'delete_false'   => 'Não foi possível excluir a marca.'
        );
    }

    /**
     * Table getAll()
     *
     * @param  array  $request
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
     * Detals
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function details($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data        = $this->interModel->setId($id);
        $title       = 'Perfil do Fabricante';
        $configModel = $this->configModel;

        return view("{$this->view}.details", compact('data', 'title', 'configModel'));    
    }

}
