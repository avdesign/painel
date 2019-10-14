<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Http\Controllers\AdminAjaxTablesController;

use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigProfileClientInterface as InterModel;
use AVDPainel\Interfaces\Admin\ConfigProductInterface as ConfigProduct;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as InterConfigSystem;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;


class ConfigProfileClientController extends AdminAjaxTablesController
{
    
    protected $ability = 'config-profile-client';
    protected $view    = 'backend.settings.customers-perfil';
    protected $last_url;
    protected $messages;


    public function __construct(
        InterAccess $access,
        InterModel $interModel,
        InterConfigSystem $confUser,
        ConfigProduct $configProduct)
    {
        $this->middleware('auth:admin');

        $this->access        = $access;
        $this->confUser      = $confUser;
        $this->interModel    = $interModel;
        $this->configProduct = $configProduct;
        $this->last_url      = array('last_url' => 'config/customers-perfil');
        $this->messages      = array(
            'order.required'        => 'A ordem é obrigatória.',
            'name.required'         => 'O perfil é obrigatório.',
            'profile.unique'        => 'Este perfil já se encontra utilizado.',
            'percent_cash.required' => 'O perfil à vísta é obrigatória.',
            'percent_card.required' => 'O perfil parcelado é obrigatória.',
            'title_index'           => 'Editar Perfil',
            'title_create'          => 'Adicionar Perfil',
            'title_edit'            => 'Editar Perfil',
            'store_true'            => 'O perfil foi cadastrado.',
            'store_false'           => 'Não foi possível cadastrar o perfil.',
            'update_true'           => 'O perfilfoi alterada.',
            'update_false'          => 'Não foi possível alterar o perfil.',
            'delete_true'           => 'O perfil foi excluido.',
            'delete_false'          => 'Não foi possível excluir o perfil.'
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


    public function prices(Request $request)
    {
        $configProduct = $this->configProduct->setId(1);
        $profiles      = $this->interModel->get();
        $dataForm      = $request->all();
        $price_card    = $dataForm['card'];

        return view("{$this->view}.prices", compact(
            'configProduct','profiles', 'price_card'
        ));
    }

    public function offers(Request $request)
    {
        if ($request['opc'] == 1) {
            $profiles      = $this->interModel->get();
            $configProduct = $this->configProduct->setId(1);

            return view("{$this->view}.offers", compact('configProduct','profiles'));
        }
    }



}
