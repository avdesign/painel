<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\GridBrandInterface as InterModel;
use AVDPainel\Http\Controllers\AdminAjaxDataParamController;

use Illuminate\Support\Facades\Gate;

class GridBrandController extends AdminAjaxDataParamController
{

    protected $ability      = 'brand-grids';
    protected $view         = 'backend.brands.grids';


    public function __construct(
        InterModel $interModel,
        InterAccess $access)
    {
        $this->middleware('auth:admin');


        $this->interModel   = $interModel;
        $this->access       = $access;
        $this->messages     = array(
            'type.required'  => 'O tipo é obrigatório',
            'name.required'  => 'O nome da grade é obrigatório.',
            'label.required' => 'A grade é obrigatória.',
            'title_index'    => 'Grades da Seção',
            'delete_success' => 'A grade foi excluida.',
            'delete_error'   => 'Não foi possível excluir a grade.'
        );
    }

    public function load($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $title  = $this->messages['title_index'];
        $data   = $this->interModel->getAll($id);

        return view("{$this->view}-load", compact('id', 'data', 'title'));
    }

}
