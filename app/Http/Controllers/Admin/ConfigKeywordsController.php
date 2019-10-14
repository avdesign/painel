<?php

namespace AVDPainel\Http\Controllers\Admin;


use AVDPainel\Http\Controllers\AdminAjaxTablesController;

use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigKeywordInterface as InterModel;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as InterConfigSystem;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class ConfigKeywordsController extends AdminAjaxTablesController
{

    protected $ability  = 'config-keyword';
    protected $view     = 'backend.settings.keywords';
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
        $this->last_url   = array('last_url' => 'config/keywords');
        $this->messages   = array(
            'title.required'        => 'O nome do titulo é obrigatório.',
            'title.unique'          => 'Este titulo já se encontra utilizado.',
            'genders.required'      => 'Os gêneros são obrigatórios.',
            'categories.required'   => 'As categorias são obrigatórias.',
            'description.required'  => 'A descrição é obrigatória.',
            'keywords.required'     => 'As tags são obrigatórias.',
            'title_index'           => 'TAGS - Palavras Chaves (SEO)',
            'title_create'          => 'Adicionar SEO',
            'title_edit'            => 'Alterar o SEO',
            'store_true'            => 'O SEO foi registrado.',
            'store_false'           => 'Não foi possível registrar o SEO.',
            'update_true'           => 'O SEO foi alterado.',
            'update_false'          => 'Não foi possível alterar o SEO.',
            'delete_true'           => 'O SEO foi excluido.',
            'delete_false'          => 'Não foi possível excluir o SEO.'
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
