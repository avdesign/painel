<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Http\Controllers\AdminAjaxTablesController;
use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigPermissionInterface as InterModel;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as InterConfigSystem;

use AVDPainel\Models\Admin\ConfigModule;
use AVDPainel\Models\Admin\ConfigProfile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class ConfigPermissionController extends AdminAjaxTablesController
{

    protected $ability = 'config-permission';
    protected $view    = 'backend.settings.permissions';
    protected $model;
    protected $select;
    protected $last_url;
    protected $messages;

    public function __construct(
        InterAccess $access,
        ConfigModule $module,        
        InterModel $interModel,
        InterConfigSystem $confUser)
    {
        $this->middleware('auth:admin');

        $this->access     = $access;
        $this->confUser   = $confUser;
        $this->interModel = $interModel;
        $this->last_url   = array('last_url' => 'config/permissions');
        $this->messages   = array(
            'module_id.required' => 'A permissão é obrigatória.',
            'name.required'      => 'A permissão é obrigatória.',
            'name.unique'        => 'Esta permissão já se encontra utilizada.',
            'label.required'     => 'A descrição é obrigatória.',
            'title_index'        => 'Permissões de Acesso',
            'title_create'       => 'Adicionar Permissão',
            'title_edit'         => 'Alterar Permissão',
            'store_true'         => 'A permissão foi cadastrada.',
            'store_false'        => 'Não foi possível cadastrar a permissão.',
            'update_true'        => 'A permissão foi alterada.',
            'update_false'       => 'Não foi possível alterar a permissão.',
            'delete_true'        => 'A permissão foi excluida.',
            'delete_false'       => 'Não foi possível excluir a permissão.'
        );

        $this->select  = array(
            'id'     => 'id',
            'name'   => 'name',
            'type'   => 'pluck',
            'edit'   => true,
            'create' => true, 
            'table'  => $module
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

    /**
     * distinct('admin_id') Não repetir registros (apenas um).
     * 
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showProfiles(Request $request, $id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data    = $this->interModel->setId($id);
        $active  = $data->profiles()->distinct('config_profile_id')->get();

        return view("{$this->view}.profiles", compact('data', 'active'));
    }


    /**
     * doesntHave: Obter apenas os que não tem permissão.
     * ->toSql() Debugar o sql.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createProfile($id)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->setId($id);

        $profiles = ConfigProfile::whereNotIn('id', function($query) use ($data){
            $query->select("config_permission_config_profile.config_profile_id");
            $query->from("config_permission_config_profile");
            $query->whereRaw("config_permission_config_profile.config_permission_id = {$data->id}");
        })->get();
        
        $title = "Vincular perfil a permissão:";

        return view("{$this->view}.form-profiles", compact('data', 'profiles', 'title'));
    }


    /**
     * Grava os profiles.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeProfiles(Request $request, $id)
    {

        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $total = count($request->get('profiles'));
        if (!$total) {
            $success = false ;
            $message = 'Selecione pelo menos um perfil.';
        } else {
            $insert = $this->interModel->addProfile($request->get('profiles'), $id);
            if ($insert) {
                $success = true;
                $message = 'Perfil adicionado.';
            } else {
                $success = true;
                $message = 'Não foi possível adicionar o perfil.';
            }
        }
        $out = array(
            'success' => $success, 
            'message' => $message 
        );

        return response()->json($out);
    }
    

    /**
     * Remove perfil da permissão
     *
     * @param  int  $id
     * @param  string  $idpro profile
     * @return \Illuminate\Http\Response
     */
    public function deleteProfile(Request $request, $id, $idpro)
    {

        if( Gate::denies("{$this->ability}-delete") ) {
            return view("backend.erros.message-401");
        }
        // name profile
        $name   = $request['name'];
        $delete = $this->interModel->delProfile($id, $idpro, $name);

        if ($delete) {
            $success = true;
            $message = 'Perfil excluido.';
        } else {
            $success = fase;
            $message = 'Erro ao excluir perfil.';
        }

        $out = array(
            'success' => $success, 
            'message' => $message 
        );

        return response()->json($out);
    }
}
