<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Http\Controllers\AdminAjaxTablesController;

use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigColorPositionInterface as InterModel;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as InterConfigSystem;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;


class ConfigColorPositionController extends AdminAjaxTablesController
{
    
    protected $ability = 'config-image-product';
    protected $view    = 'backend.settings.images.colors-positions';
    protected $last_url;
    protected $messages;
    protected $confUser;


    public function __construct(
        InterAccess $access,
        InterModel $interModel,
        InterConfigSystem $confUser)
    {
        $this->middleware('auth:admin');

        $this->confUser   = $confUser;
        $this->interModel = $interModel;
        $this->access     = $access;
        $this->last_url   = array('last_url' => 'config/colors-positions');
        $this->messages   = array(
            'width.required'   => 'A largura é obrigatória.',
            'width.numeric'    => 'Digite um valor numérico para largura.',
            'height.required'  => 'A altura é obrigatória.',
            'height.numeric'   => 'Digite um valor numérico para altura.',
            'path.required'    => 'A pasta é obrigatória.',
            'title_index'      => 'Editar imagem padrão',
            'title_create'     => 'Adicionar imagem padrão',
            'title_edit'       => 'Editar imagem padrão',
            'store_true'       => 'A imagem padrão foi cadastrada.',
            'store_false'      => 'Não foi possível cadastrar a imagem padrão.',
            'update_true'      => 'A imagem padrão foi alterada.',
            'update_false'     => 'Não foi possível alterar a imagem padrão.',
            'delete_true'      => 'A imagem padrão foi excluida.',
            'delete_false'     => 'Não foi possível excluir a imagem padrão.'
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
