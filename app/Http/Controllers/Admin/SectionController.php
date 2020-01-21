<?php


namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Http\Controllers\AdminAjaxTablesController;

use AVDPainel\Interfaces\Admin\SectionInterface as InterModel;
use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\GridSectionInterface as InterGrids;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as ConfigSystem;
use AVDPainel\Interfaces\Admin\ConfigSectionInterface as ConfigSection;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SectionController extends AdminAjaxTablesController
{
    protected $ability  = 'section';
    protected $view     = 'backend.sections';
    protected $select;
    protected $upload;
    protected $last_url;
    protected $messages;
    protected $configImages = true;


    public function __construct(
        InterAccess $access,
        InterGrids $interGrids,
        InterModel $interModel,
        ConfigSystem $confUser,
        ConfigSection $configModel)
    {
        $this->middleware('auth:admin');

        $this->access       = $access;
        $this->confUser     = $confUser;
        $this->interModel   = $interModel;
        $this->interGrids   = $interGrids;
        $this->last_url     = array('last_url' => 'sections');
        $this->configModel  = $configModel->setId(1);
        $this->upload       = $this->configModel;
        $this->messages     = array(
            'name.required'  => 'O nome do é obrigatório.',
            'name.unique'    => 'Este nome já se encontra utilizado.',
            'order.required' => 'A ordem é obrigatória.',
            'title_index'    => 'Seções dos Produtos',
            'title_create'   => 'Adicionar Seção',
            'title_edit'     => 'Alterar o Seção',
            'store_true'     => 'A Seção foi registrada.',
            'store_false'    => 'Não foi possível registrar a seção.',
            'update_true'    => 'A seção foi alterada.',
            'update_false'   => 'Não foi possível alterar a seção.',
            'delete_true'    => 'A seção foi excluida.',
            'delete_false'   => 'Não foi possível excluir a seção.'
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
        $title       = 'Perfil da Seção';
        $configModel = $this->configModel;

        return view("{$this->view}.details", compact('data', 'title', 'configModel'));    
    }

}
